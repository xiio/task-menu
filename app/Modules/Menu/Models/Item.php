<?php

namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;

use App\Domain\Menu\Entity as Entity;

class Item extends Model
{
    protected $table = 'items';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    public $connection = 'mysql';

    protected $fillable = ['id', 'name', 'parent_id', 'menu_id', 'depth'];

    /**
     * @return Entity\Item
     */
    public function convertToDomainEntity(Entity\Menu $menu): Entity\Item
    {
        return new Entity\Item(
            $menu,
            $this->parent_id,
            $this->id,
            $this->name,
            [],
            $this->depth
        );
    }
}
