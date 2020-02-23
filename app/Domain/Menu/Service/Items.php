<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu\Service;

use App\Domain\Menu\Persistence\ItemRepository;
use App\Domain\Menu\Persistence\MenuRepository;
use App\Domain\Menu\Entity as Entity;

/**
 * Item service
 * @package App\Domain\Menu\Service
 */
class Items
{

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var IdentityGenerator
     */
    private $idGenerator;

    /**
     * @var MenuRepository
     */
    private $menuRepository;

    /**
     * @param MenuRepository $menuRepository
     * @param ItemRepository $itemRepository
     * @param IdentityGenerator $idGenerator
     */
    public function __construct(
        MenuRepository $menuRepository,
        ItemRepository $itemRepository,
        IdentityGenerator $idGenerator
    ) {
        $this->menuRepository = $menuRepository;
        $this->itemRepository = $itemRepository;
        $this->idGenerator = $idGenerator;
    }

    /**
     * @param Entity\Menu $menu
     * @param mixed|null $parentId
     * @param string $name
     * @param array $children
     * @param int $depth
     * @return Entity\Item
     */
    public function create(Entity\Menu $menu, $parentId = null, string $name, array $children, int $depth): Entity\Item
    {
        $menu = new Entity\Item(
            $menu,
            $parentId,
            $this->idGenerator->generate(),
            $name,
            $children,
            $depth
        );

        return $menu;
    }

    /**
     * @param Entity\Menu $menu
     * @param mixed|null $parentId
     * @param array $itemsData array of items with following structure
     * [
     *  [
     *      name => "",
     *      children => "" (optional)
     *  ],
     *  ...
     * ]
     * @return array
     */
    public function createFromArray(Entity\Menu $menu, $parentId = null, array $itemsData): array
    {
        return $this->createItemsRecursive($menu, $parentId, $itemsData, 0);
    }

    /**
     * @param Entity\Menu $menu
     * @param mixed|null $parentId
     * @param array $itemsData array of items with following structure
     * [
     *  [
     *      name => "",
     *      children => "" (optional)
     *  ],
     *  ...
     * ]
     * @param int $currentDepth
     * @return array
     */
    private function createItemsRecursive(Entity\Menu $menu, $parentId = null, array $itemsData, int $currentDepth)
    {
        $items = [];
        foreach ($itemsData as $itemData) {
//            $this->validate();
            $item = $this->create($menu, $parentId, $itemData['name'], [], $currentDepth);
            if (isset($itemData['children']) && is_array($itemData['children']) && !empty($itemData['children'])) {
                $children = $this->createItemsRecursive($menu, $parentId, $itemData['children'], $currentDepth + 1);
                $item->setChildren($children);
            }
            $items[] = $item;
        }

        return $items;
    }

    /**
     * @param $id
     * @return Entity\Item
     */
    public function getById($id): Entity\Item
    {
        return $this->itemRepository->getById($id);
    }

    /**
     * @param array $items
     * @return bool
     */
    public function persistAll(array $items): bool
    {
        $affectedRowsCount = 0;
        /** @var Entity\Item $item */
        foreach ($items as $item) {
            $affectedRowsCount = (bool)$this->itemRepository->persist($item);

            if ($item->hasChildren()) {
                $this->persistAll($item->getChildren());
            }
        }

        return $affectedRowsCount;
    }

    /**
     * @param $menu
     * @return Entity\Item[]
     */
    public function getAllForMenu($menu) : array
    {
        return $this->itemRepository->getAllByMenu($menu);
    }

    /**
     * @param $menuId
     * @return int items deleted
     */
    public function deleteByMenuId($menuId) : int
    {
        return $this->itemRepository->deleteById($menuId);
    }

    /**
     * Get items depth by menu id
     * @param $menuId
     * @return int|null null = menu not found
     */
    public function getDepthByMenuId($menuId): ?int
    {
        return $this->itemRepository->getDepthByMenuId($menuId);
    }
}
