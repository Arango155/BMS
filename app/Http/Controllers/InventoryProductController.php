<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryProduct;

class InventoryProductController extends Controller
{
    // ✅ List all products
    public function index()
    {
        return response()->json(InventoryProduct::all());
    }

    // ✅ Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:inventory_products',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'sale_price' => 'required|numeric|min:0',
        ]);

        $product = InventoryProduct::create($request->all());

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    // ✅ Show a specific product
    public function show($id)
    {
        $product = InventoryProduct::find($id);
        return $product ? response()->json($product) : response()->json(['error' => 'Product not found'], 404);
    }

    // ✅ Update a product
    public function update(Request $request, $id)
    {
        $product = InventoryProduct::find($id);
        if (!$product) return response()->json(['error' => 'Product not found'], 404);

        $request->validate([
            'code' => "required|unique:inventory_products,code,$id",
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'sale_price' => 'required|numeric|min:0',
        ]);

        $product->update($request->all());

        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    // ✅ Delete a product
    public function destroy($id)
    {
        $product = InventoryProduct::find($id);
        if (!$product) return response()->json(['error' => 'Product not found'], 404);

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }

    // ✅ Get best-selling products
    public function bestSellers()
    {
        $products = InventoryProduct::orderBy('sold_quantity', 'desc')->take(10)->get();
        return response()->json($products);
    }

    // ✅ Get warehouse (in-stock) products
    public function inWarehouse()
    {
        $products = InventoryProduct::where('stock', '>', 0)->get();
        return response()->json($products);
    }
}
