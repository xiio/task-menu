<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu\Persistence;

use App\Domain\Menu\Entity\Menu;

/**
 * @package App\Domain\Menu\Persistence
 */
interface MenuRepository
{

    /**
     * @param Menu $menu
     * @return bool
     */
    public function persist(Menu $menu): bool;

    /**
     * @param $id
     * @return Menu|null
     */
    public function getById($id) : ?Menu;

    /**
     * @param $id
     * @return bool
     */
    public function deleteById($id) : bool;
}
