<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 * @author Tomasz Ksionek
 */

namespace App\Http\Controllers;

use App\Domain\Menu\Exception\ValidationFailed;
use App\Domain\Menu\Menu;
use App\Http\Responses\MenuResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $name = $request->get('name');
            $maxDepth = $request->get('max_depth', null);
            $maxChildren = $request->get('max_children', null);
            $menu = $this->menuService->menus()->createMenu($name, $maxDepth, $maxChildren);
        } catch (ValidationFailed $e) {
            return response()->json(
                [
                    'error_msg' => $e->getMessage(),
                    'errors' => $e->getErrors()
                ],
                412
            );
        } catch (\Exception $e) {
            return response()->json(
                ['error_msg' => 'Unexpected thinks happened! '],
                500
            );
        }

        return response()->json(
            new MenuResponse($menu)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param $menuId menu id
     * @return void
     */
    public function show($menuId)
    {
        $menu = $this->menuService->menus()->getById($menuId);

        if (!$menu) {
            return response()->json(null, 404);
        }

        return response()->json(
            new MenuResponse($menu)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $menuId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menuId)
    {
        $menu = $this->menuService->menus()->getById($menuId);

        if (!$menu) {
            return response()->json(null, 404);
        }

        $menu->setName($request->get('name'));
        $menu->setMaxDepth($request->get('max_depth'));
        $menu->setMaxChildren($request->get('max_children'));

        $this->menuService->menus()->persist($menu);

        return response()->json(
            new MenuResponse($menu)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $menuId
     * @return \Illuminate\Http\Response
     */
    public function destroy($menuId)
    {
        $status = $this->menuService->menus()->deleteById($menuId);
        $statusCode = $status ? 200 : 400;

        return response()->json(null, $statusCode);
    }
}
