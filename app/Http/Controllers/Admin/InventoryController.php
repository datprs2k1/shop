<?php

namespace App\Http\Controllers\Admin;

use App\Enums\InventoryLogEnum;
use App\Enums\InventoryStatusEnum;
use App\Exports\InventoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreRequest;
use App\Models\Inventory;
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
        $data = Inventory::with('product', 'supplier', 'logs')->paginate(10)->withQueryString();

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
        return Excel::download(new InventoryExport, 'inventoy.xlsx');
    }

    public function store(StoreRequest $request)
    {

        $inventory = Inventory::where('product_id', $request->product_id)
            ->first();

        $inventory->logs()->create([
            'status' => InventoryLogEnum::NHAP,
            'quantity' => $request->quantity,
            'remain' => $inventory->quantity + $request->quantity,
        ]);

        return response()->json([
            'message' => 'Thêm mới thành công',
            'data' => $inventory
        ], 201);
    }
}
