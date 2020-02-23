<?php


namespace Tests\Unit\Menu\Entity;

use App\Domain\Menu\Exception\ChildrenLimitExceeded;
use App\Domain\Menu\Exception\NestingDepthLimitExceeded;
use Tests\TestCase;
use App\Domain\Menu\Entity\Item;

class ItemTest extends TestCase
{

    /**
     * @return void
     */
    public function testChildrenLimit()
    {
        $menuMock = \Mockery::mock(\App\Domain\Menu\Entity\Menu::class);
        $menuMock->shouldReceive('getId')->andReturn(uniqid());
        $menuMock->shouldReceive('getMaxChildren')->andReturn(null);
        $menuMock->shouldReceive('getMaxDepth')->andReturn(0);
        $this->expectException(NestingDepthLimitExceeded::class);
        $itemLvl2 = new Item($menuMock, null, uniqid(), 'test');
        $itemLvl1= new Item($menuMock, null, uniqid(), 'child node', [$itemLvl2]);
        new Item($menuMock, null, uniqid(), 'test', [$itemLvl1]);
    }

    /**
     * @return void
     */
    public function testNestingDepthLimit()
    {
        $menuMock = \Mockery::mock(\App\Domain\Menu\Entity\Menu::class);
        $menuMock->shouldReceive('getId')->andReturn(uniqid());
        $menuMock->shouldReceive('getMaxChildren')->andReturn(2);
        $menuMock->shouldReceive('getMaxDepth')->andReturn(null);
        $item = new Item($menuMock, null, uniqid(), 'test');
        $childItem = new Item($menuMock, null, uniqid(), 'child node');
        $this->expectException(ChildrenLimitExceeded::class);
        $item->addChild($childItem);
        $item->addChild($childItem);
        $item->addChild($childItem);
    }
}
