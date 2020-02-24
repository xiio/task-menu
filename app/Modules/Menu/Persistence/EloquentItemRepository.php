<?php


namespace App\Modules\Menu\Persistence;

use App\Domain\Menu\Entity\Item;
use App\Domain\Menu\Entity\Menu;
use App\Domain\Menu\Persistence\ItemRepository;

use App\Domain\Menu\Persistence\MenuRepository;
use App\Modules\Menu\Models as Models;

class EloquentItemRepository implements ItemRepository
{

    /**
     * @var MenuRepository
     */
    private $menuRepository;

    /**
     * EloquentItemRepository constructor.
     * @param MenuRepository $menuRepository
     */
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @inheritDoc
     */
    public function persist(Item $item): bool
    {
        $result = (bool)Models\Item::updateOrCreate(
            ['id' => $item->getId()],
            [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'parent_id' => $item->getParentId(),
                'menu_id' => $item->getMenuId(),
                'depth' => $item->getDepth()
            ]
        );

        if ($item->hasChildren()) {
            return (bool)$result;
        }

        foreach ($item->getChildren() as $child) {
            $this->persist($child);
        }

        return (bool)$result;
    }

    /**
     * @inheritDoc
     */
    public function getAllByMenu(Menu $menu): array
    {
        $dbItems = Models\Item::where('menu_id', $menu->getId())->get()->all();
        $itemsIndex = [];

        //convert to domain entites
        /** @var \App\Modules\Menu\Models\Item $dbItem */
        foreach ($dbItems as $dbItem) {
            $itemsIndex[$dbItem->id] = $dbItem->convertToDomainEntity($menu);
        }

        return $this->buildItemsTree($itemsIndex);
    }

    /**
     * @inheritDoc
     */
    public function deleteByMenuId($menuId): int
    {
        return Models\Item::where('menu_id', $menuId)->delete();
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id): bool
    {
        return Models\Item::destroy($id);
    }

    private function buildItemsTree(array $flatItems)
    {
        $itemsTree = [];

        /** @var Item $item */
        foreach ($flatItems as $item) {
            if ($item->hasParent()) {
                continue;
            }

            $children = $this->getChildrenFor($item->getId(), $flatItems);
            $flatItems[$item->getId()]->setChildren($children);
            $itemsTree[] = $flatItems[$item->getId()];
        }

        return $itemsTree;
    }

    /**
     * @inheritDoc
     */
    public function getDepthByMenuId($menuId): ?int
    {
        return Models\Item::where('menu_id', $menuId)->max('depth');
    }

    /**
     * @inheritDoc
     */
    public function getById($id): ?Item
    {
        $dbItem = Models\Item::find($id);

        if (!$dbItem) {
            return null;
        }
        $menu = $this->menuRepository->getById($dbItem->menu_id);
        return $dbItem->convertToDomainEntity($menu);
    }

    /**
     * @param $parentItemId
     * @return array|null null = parent not found
     */
    public function getChildren($parentItemId): ?array
    {
        $item = $this->getById($parentItemId);
        if (!$item) {
            return null;
        }
        $dbItems = Models\Item::where('menu_id', $item->getMenuId())->get()->all();
        $domainItems = [];
        foreach ($dbItems as $dbItem) {
            $domainItems[] = $dbItem->convertToDomainEntity($item->getMenu());
        }

        return $this->getChildrenFor($parentItemId, $domainItems);
    }

    /**
     * @param $parentId
     * @param Item[] $flatItems
     * @return array
     */
    private function getChildrenFor($parentId, array $flatItems)
    {
        $parentItems = [];

        foreach ($flatItems as $item) {
            if ($item->getParentId() !== $parentId) {
                continue;
            }

            if ($item->hasParent()) {
                $item->setChildren(
                    $this->getChildrenFor($item->getId(), $flatItems)
                );
            }

            $parentItems[] = $item;
        }

        return $parentItems;
    }
}
