<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 * @author Tomasz Ksionek
 */

namespace App\Http\Controllers;

use App\Domain\Menu\Menu;

class MenuDepthController extends Controller
{

    /**
     * @var Menu
     */
    private $menuService;

    public function __construct(Menu $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $menuId
     * @return \Illuminate\Http\Response
     */
    public function show($menuId)
    {
        $depth = $this->menuService->items()->getDepthByMenuId($menuId);
        if ($depth === null) {
            return response()->json(null, 404);
        }

        return response()->json(['depth' => $depth]);
    }
}
