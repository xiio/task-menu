<?php


namespace App\Modules\Menu;

use App\Domain\Menu\Service\IdentityGenerator;

class UniqueIdIdentityGenerator implements IdentityGenerator
{
    public function generate()
    {
        return uniqid();
    }
}
