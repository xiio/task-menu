<?php

namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;

use App\Domain\Menu\Entity as Entity;

class Menu extends Model
{
    protected $table = 'menus';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    public $connection = 'mysql';

    protected $fillable = ['id', 'name', 'max_depth', 'max_children'];

    /**
     * @param \App\Domain\Menu\Entity\Menu $menu
     * @return Menu
     */
    public static function createFromMenuItem(\App\Domain\Menu\Entity\Menu $menu): self
    {
        $menuModel = new self();
        $menuModel->id = $menu->getId();
        $menuModel->name = $menu->getName();
        $menuModel->max_depth = $menu->getMaxDepth();
        $menuModel->max_children = $menu->getMaxChildren();
        return $menuModel;
    }

    /**
     * @return Entity\Menu
     */
    public function convertToDomainEntity(): Entity\Menu
    {
        return new Entity\Menu(
            $this->id,
            $this->name,
            $this->max_depth,
            $this->max_children
        );
    }
}
