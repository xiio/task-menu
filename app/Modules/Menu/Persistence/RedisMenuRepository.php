<?php


namespace App\Modules\Menu\Persistence;

use App\Domain\Menu\Entity\Menu;
use App\Domain\Menu\Persistence\MenuRepository;
use App\Modules\Menu\Models as Models;

class RedisMenuRepository implements MenuRepository
{

    /**
     * @var MenuRepository
     */
    private $targetRepository;

    /**
     * @param MenuRepository $targetRepository
     */
    public function __construct(MenuRepository $targetRepository)
    {
        $this->targetRepository = $targetRepository;
    }

    /**
     * @inheritDoc
     */
    public function persist(\App\Domain\Menu\Entity\Menu $menu): bool
    {
        //refresh cache for item
        return $this->targetRepository->persist($menu);
    }

    /**
     * @inheritDoc
     */
    public function getById($id): ?Menu
    {
        //get from cache
        //if not exists cache it and return
        return $this->targetRepository->getById($id);
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id): bool
    {
        //refresh cache for item
        return $this->targetRepository->deleteById($id);
    }
}
