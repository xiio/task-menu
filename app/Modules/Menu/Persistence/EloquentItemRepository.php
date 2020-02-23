<?php


namespace App\Modules\Menu\Persistence;

use App\Domain\Menu\Entity\Item;
use App\Domain\Menu\Entity\Menu;
use App\Domain\Menu\Persistence\ItemRepository;

use App\Modules\Menu\Models as Models;

class EloquentItemRepository implements ItemRepository
{

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
    public function deleteById($menuId): int
    {
        return Models\Item::where('menu_id', $menuId)->delete();
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
    public function getDepthByMenuId($menuId) : ?int
    {
        return Models\Item::where('menu_id', $menuId)->max('depth');
    }

    /**
     * @param $parentId
     * @param array $flatItems
     * @return array
     */
    private function getChildrenFor($parentId, array $flatItems)
    {
        $parentItems = [];

        /** @var Item $item */
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
