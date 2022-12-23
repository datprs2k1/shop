<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InventoryLogEnum;
use App\Enums\InventoryStatusEnum;
use App\Exports\InventoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreRequest;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as DatabaseQueryBuilder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    public function index()
    {
        $data = Inventory::with('product', 'supplier', 'logs')
            ->paginate(10)
            ->withQueryString();

        return response()->json($data, 200);
    }

    public function getStatus()
    {
        $data = InventoryStatusEnum::getInventoryStatus();

        return response()->json($data, 200);
    }

    public function getLogStatus()
    {
        $data = InventoryLogEnum::getInventoryLogStatus();

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = Inventory::with('product', 'supplier', 'logs')->findOrFail($id);

        return response()->json($data, 200);
    }

    public function export()
    {
        return Excel::download(new InventoryExport(), 'inventoy.xlsx');
    }

    public function store(StoreRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        $supplier = Category::findOrFail($product->supplier_id);

        $inventory = Inventory::where(
            'product_id',
            $request->product_id
        )->first();

        if ($inventory) {
            $inventory->logs()->create([
                'status' => InventoryLogEnum::NHAP,
                'quantity' => $request->quantity,
                'remain' => $inventory->quantity + $request->quantity,
            ]);

            $inventory->update([
                'quantity' => $inventory->quantity + $request->quantity,
                'status' => InventoryStatusEnum::CON_HANG,
            ]);
        } else {
            $inventory = Inventory::create([
                'product_id' => $request->product_id,
                'supplier_id' => $supplier->id,
                'quantity' => $request->quantity,
                'status' => InventoryStatusEnum::CON_HANG,
            ]);

            $inventory->logs()->create([
                'status' => InventoryLogEnum::NHAP,
                'quantity' => $request->quantity,
                'remain' => $request->quantity,
            ]);
        }

        return response()->json(
            [
                'message' => 'Thêm mới thành công',
                'data' => $inventory,
            ],
            201
        );
    }
}
