<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 * @author Tomasz Ksionek
 */

namespace App\Http\Controllers;

use App\Domain\Menu\Menu;
use Illuminate\Http\Request;

class MenuItemController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $menuId
     * @return void
     */
    public function store(Request $request, $menuId)
    {
        try {
            $menu = $this->menuService->menus()->getById($menuId);

            if (!$menu) {
                return response()->json(null, 404);
            }

            $items = $this->menuService->items()->createFromArray($menu, null, $request->post());
            $this->menuService->items()->persistAll($items);

            return response()->json($items);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error_msg' => $e->getMessage(),
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $menuId
     * @return \Illuminate\Http\Response
     */
    public function show($menuId)
    {
        $menu = $this->menuService->menus()->getById($menuId);

        if (!$menu) {
            return response()->json(null, 404);
        }

        $menuItems = $this->menuService->items()->getAllForMenu($menu);

        return response()->json($menuItems);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $menuId
     * @return \Illuminate\Http\Response
     */
    public function destroy($menuId)
    {
        $this->menuService->items()->deleteByMenuId($menuId);

        return response()->json();
    }
}
