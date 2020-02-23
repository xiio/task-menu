<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu\Service;

use App\Domain\Menu\Exception\ValidationFailed;
use App\Domain\Menu\Persistence\MenuRepository;
use App\Domain\Menu\Entity as Entity;

/**
 * Menu service.
 * @package App\Domain\Menu\Service
 */
class Menus
{

    /**
     * @var MenuRepository
     */
    private $menuRepository;

    /**
     * @var IdentityGenerator
     */
    private $idGenerator;

    /**
     * @param MenuRepository $menuRepository
     * @param IdentityGenerator $idGenerator
     */
    public function __construct(MenuRepository $menuRepository, IdentityGenerator $idGenerator)
    {
        $this->menuRepository = $menuRepository;
        $this->idGenerator = $idGenerator;
    }

    /**
     * @param string $name
     * @param int|null $maxChildren
     * @param int|null $maxDepth
     * @return Entity\Menu
     *
     * @throws ValidationFailed
     */
    public function createMenu(string $name, ?int $maxDepth = null, ?int $maxChildren = null): Entity\Menu
    {
        $menu = new Entity\Menu(
            $this->idGenerator->generate(),
            $name,
            $maxDepth,
            $maxChildren
        );
        $this->menuRepository->persist($menu);

        return $menu;
    }

    /**
     * @param $id
     * @return Entity\Menu|nulmenuRepositoryl
     */
    public function getById($id): ?Entity\Menu
    {
        return $this->menuRepository->getById($id);
    }

    /**
     * @param Entity\Menu $menu
     * @return Entity\Menu
     */
    public function persist(Entity\Menu $menu): Entity\Menu
    {
        $this->menuRepository->persist($menu);

        return $menu;
    }

    /**
     * @param Entity\Identity $id
     * @return bool
     */
    public function deleteById($id): bool
    {
        return $this->menuRepository->deleteById($id);
    }
}
