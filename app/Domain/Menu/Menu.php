<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu;

use App\Domain\Menu\Persistence\ItemRepository;
use App\Domain\Menu\Persistence\MenuRepository;
use App\Domain\Menu\Service as Service;

/**
 * Menu facade. Allows access to menu and items managment
 * @package App\Domain\Menu
 */
class Menu
{

    /**
     * @var Service\Menus
     */
    private $menusService;

    /**
     * @var Service\Item
     */
    private $itemsService;

    /**
     * @param MenuRepository $menuRepository
     * @param ItemRepository $itemRepository
     * @param Service\IdentityGenerator $idStrategy
     */
    public function __construct(
        MenuRepository $menuRepository,
        ItemRepository $itemRepository,
        Service\IdentityGenerator $idStrategy
    ) {
        $this->menusService = new Service\Menus($menuRepository, $idStrategy);
        $this->itemsService = new Service\Items($menuRepository, $itemRepository, $idStrategy);
    }

    /**
     * Get menu service
     * @return Service\Menus
     */
    public function menus() : Service\Menus
    {
        return $this->menusService;
    }

    /**
     * Get items service
     * @return Service\Items
     */
    public function items() : Service\Items
    {
        return $this->itemsService;
    }
}
