<?php

namespace App\Http\Controllers;

use App\Domain\Menu\Menu;
use Illuminate\Http\Request;

class ItemChildrenController extends Controller
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
     * @param $itemId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $itemId)
    {
        $parentItem = $this->menuService->items()->getById($itemId);
        if (!$parentItem) {
            return response()->json(null, 404);
        }

        $itemsToStore = $this->menuService->items()->createFromArray($parentItem->getMenu(), null, $request->post());
        $status = $this->menuService->items()->persistAll($itemsToStore);

        if (!$status) {
            return response()->json(['error_msg' => $e->getMessage()], 400);
        }

        return response()->json($itemsToStore, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $itemId
     * @return \Illuminate\Http\Response
     */
    public function show($itemId)
    {
        $children = $this->menuService->items()->getChildrenByItemId($itemId);
        if ($children === null) {
            return response()->json(null, 404);
        }

        return response()->json($children, 200);
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
