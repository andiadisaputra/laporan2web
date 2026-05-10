<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return response()->json(['success' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity'    => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
        $item = Item::create($request->all());
        return response()->json(['success' => true, 'message' => 'Item created successfully', 'data' => $item->load('category')], 201);
    }

    public function show(Item $item)
    {
        return response()->json(['success' => true, 'data' => $item->load('category')]);
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity'    => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
        $item->update($request->all());
        return response()->json(['success' => true, 'message' => 'Item updated successfully', 'data' => $item->load('category')]);
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(['success' => true, 'message' => 'Item deleted successfully']);
    }
}