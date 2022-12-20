<?php

namespace App\Http\Controllers;

use App\Enums\ProductStatus;
use App\Enums\ProductUnit;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function detail($id)
    {
        $data = Product::with(['category', 'supplier', 'inventory', 'images'])->find($id);

        return response()->json($data, 200);
    }

    public function getProductStatus()
    {
        $data = ProductStatus::getProductStatus();
        return response()->json($data, 200);
    }

    public function getProductUnit()
    {
        $data = ProductUnit::getProductUnit();
        return response()->json($data, 200);
    }

    public function search(Request $request)
    {
        $data = Product::where('name', 'like', '%' . $request->name . '%')
            ->limit(5)
            ->get();

        return response()->json($data, 200);
    }
}
