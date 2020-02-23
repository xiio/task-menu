<?php


namespace App\Modules\Menu\Persistence;

use App\Domain\Menu\Entity\Menu;
use App\Domain\Menu\Persistence\MenuRepository;
use App\Modules\Menu\Models as Models;

class EloquentMenuRepository implements MenuRepository
{

    /**
     * @inheritDoc
     */
    public function persist(\App\Domain\Menu\Entity\Menu $menu): bool
    {
        return (bool)Models\Menu::updateOrCreate(
            ['id' => $menu->getId()],
            [
                'id' => $menu->getId(),
                'name' => $menu->getName(),
                'max_depth' => $menu->getMaxDepth(),
                'max_children' => $menu->getMaxChildren()
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function getById($id): ?Menu
    {
        /** @var Models\Menu $menuModel */
        $menuModel = Models\Menu::find($id);
        return $menuModel ? $menuModel->convertToDomainEntity() : null;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id): bool
    {
        return (bool)Models\Menu::destroy($id);
    }
}
