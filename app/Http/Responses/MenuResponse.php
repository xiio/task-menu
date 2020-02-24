<?php


namespace App\Http\Responses;

use App\Domain\Menu\Entity\Menu;

class MenuResponse implements \JsonSerializable
{

    /**
     * @var Menu
     */
    private $menu;

    /**
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->menu->getId(),
            'name' => $this->menu->getName(),
            'max_depth' => $this->menu->getMaxDepth(),
            'max_children' => $this->menu->getMaxChildren(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
