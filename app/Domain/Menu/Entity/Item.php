<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 *
 * @author Tomasz Ksionek <dev@ksionek.com>
 */

namespace App\Domain\Menu\Entity;

use _HumbugBox069fea7e7fc7\Nette\Schema\ValidationException;
use App\Domain\Menu\Exception\ChildrenLimitExceeded;
use App\Domain\Menu\Exception\NestingDepthLimitExceeded;
use App\Domain\Menu\Exception\ValidationFailed;

/**
 * Menu item
 * @package App\Domain\Menu\Entity
 */
class Item implements \JsonSerializable
{

    /**
     * @var mixed
     */
    private $id;

    /**
     * @var mixed
     */
    private $parentId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Item[]
     */
    private $children = [];

    /**
     * @var int|null
     */
    private $maxChildren = null;

    /**
     * @var int
     */
    private $depth;

    /**
     * @var int
     */
    private $maxDepth;

    /**
     * @var mixed
     */
    private $menuId;

    /**
     * @var Menu
     */
    private $menu;

    /**
     * @param Menu $menu
     * @param null $parentId
     * @param $id
     * @param string $name
     * @param array $children
     * @param int $depth
     */
    public function __construct(Menu $menu, $parentId = null, $id, string $name, array $children = [], int $depth = 0)
    {
        if ($depth > $menu->getMaxDepth()) {
            throw new NestingDepthLimitExceeded($menu->getMaxDepth());
        }

        $this->id = $id;
        $this->parentId = $parentId;
        $this->menu = $menu;
        $this->menuId = $menu->getId();
        $this->name = $name;
        $this->depth = $depth;
        $this->maxDepth = $menu->getMaxDepth();
        $this->maxChildren = $menu->getMaxChildren();

        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    /**
     * @param Item $child
     */
    public function addChild(Item $child): void
    {
        if ($this->getChildrenCount() === $this->maxChildren) {
            throw new ChildrenLimitExceeded($this->maxChildren);
        }
        if ($this->maxDepth !== null && $this->depth + 1 > $this->maxDepth) {
            throw new NestingDepthLimitExceeded($this->maxDepth);
        }
        $child->setDepth($this->depth + 1);
        $child->setParentId($this->id);
        $this->children[] = $child;
    }

    public function getChildrenFor(Item $item) : ?Item
    {

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $itemNewName
     */
    public function setName(string $itemNewName): void
    {
        if (strlen($itemNewName) === 0) {
            $validationException = new ValidationFailed("Name is invalid!");
            $validationException->addError('name', 'Name is empty!', $itemNewName);
            return;
        }
        $this->name = $itemNewName;
    }

    /**
     * @return Item[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @return int
     */
    public function getChildrenCount(): int
    {
        return count($this->children);
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @return mixed
     */
    public function getMenuId()
    {
        return $this->menuId;
    }

    /**
     * @return Menu
     */
    public function getMenu() : Menu
    {
        return $this->menu;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return !empty($this->children);
    }

    /**
     * @return int
     */
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     */
    public function setDepth(int $depth): void
    {
        $this->depth = $depth;

        foreach ($this->children as &$child) {
            $child->setDepth($depth + 1);
        }
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $result = [
            'name' => $this->name,
        ];

        if ($this->hasChildren()) {
            $result['children'] = $this->children;
        }

        return $result;
    }

    /**
     * @param Item[] $children
     */
    public function setChildren(array $children)
    {
        $this->children = [];
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    /**
     * @param $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return bool
     */
    public function hasParent(): bool
    {
        return (bool)$this->parentId;
    }

}
