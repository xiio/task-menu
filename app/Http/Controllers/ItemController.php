<?php declare(strict_types=1);
/**
 * Recruitment task for Cobiro ApS
 * @author Tomasz Ksionek
 */

namespace App\Http\Controllers;

use App\Domain\Menu\Exception\MenuDomainException;
use App\Domain\Menu\Exception\NestingDepthLimitExceeded;
use App\Domain\Menu\Exception\ValidationFailed;
use App\Domain\Menu\Menu;
use Illuminate\Http\Request;

class ItemController extends Controller
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
        $itemName = $request->get('name');
        $menuId = $request->get('menu_id');
        $menu = $this->menuService->menus()->getById($menuId);
        if (!$menu) {
            return response()->json(['error_msg' => 'Menu not found'], 412);
        }

        $parentId = $request->get('parent_id', null);
        $depth = 0;
        if ($parentId) {
            $parent = $this->menuService->items()->getById($menuId);
            if (!$parent) {
                return response()->json(['error_msg' => 'Parent not found'], 412);
            }
            $depth = $parent->getDepth() + 1;
        }

        try {
            $item = $this->menuService->items()->create($menu, null, $itemName, [], $depth);
            $this->menuService->items()->persist($item);
        } catch (MenuDomainException $e) {
            return response()->json(['error_msg' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error_msg' => 'Unexpected thinks happened!'], 500);
        }

        return response()->json($item, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $itemId
     * @return \Illuminate\Http\Response
     */
    public function show($itemId)
    {
        $item = $this->menuService->items()->getById($itemId);
        if (!$item) {
            return response()->json(null, 404);
        }

        return response()->json($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $itemId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $itemId)
    {
        $itemNewName = $request->get('name');
        if (!$itemNewName) {
            return response()->json(['error_msg' => 'Missing parameter: name'], 412);
        }

        $item = $this->menuService->items()->getById($itemId);

        if (!$item) {
            return response()->json(null, 404);
        }
        try {
            $item->setName($itemNewName);
            $this->menuService->items()->persist($item);
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

        return response()->json($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $itemId
     * @return \Illuminate\Http\Response
     */
    public function destroy($itemId)
    {
        $status = $this->menuService->items()->deleteById($itemId);
        if (!$status) {
            return response()->json(null, 412);
        }

        return response()->json(null, 200);
    }
}
