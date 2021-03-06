<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu\Persistence;

use App\Domain\Menu\Entity\Item;
use App\Domain\Menu\Entity\Menu;

/**
 * @package App\Domain\Menu\Persistence
 */
interface ItemRepository
{
    /**
     * @param Item $item
     * @return bool
     */
    public function persist(Item $item): bool;

    /**
     * @param Menu $menu
     * @return Entity\Item[]
     */
    public function getAllByMenu(Menu $menu): array;

    /**
     * @param $menuId
     * @return int items deleted
     */
    public function deleteByMenuId($menuId): int;

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id): bool;

    /**
     * Get items depth by menu id
     * @param $menuId
     * @return int|null null = menu not found
     */
    public function getDepthByMenuId($menuId): ?int;

    /**
     * Get item whiteout children preloaded
     *
     * @param $id
     * @return Item|null
     */
    public function getById($id) : ?Item;

    /**
     * @param $parentItemId
     * @return array|null
     */
    public function getChildren($parentItemId): ?array;
}
