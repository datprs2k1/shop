<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreRequest;
use App\Http\Requests\Cart\UpdateRequest;
use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Cart::with(['product'])->where('user_id', Auth::user()->id)->get();

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $inventory = Inventory::where('product_id', $request->product_id)->first();

        if ($inventory->quantity < $request->quantity) {
            return response()->json([
                'message' => 'Số lượng sản phẩm trong kho không đủ',
            ], 400);
        }

        Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Thêm thành công'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {

        $inventory = Inventory::where('product_id', $request->product_id)->first();

        if ($inventory->quantity < $request->quantity) {
            return response()->json([
                'message' => 'Số lượng sản phẩm trong kho không đủ',
            ], 400);
        }

        $cart = Cart::find($id);

        $cart->update([
            'quantity' => $request->quantity,
        ]);

        return response()->json(['message' => 'Cập nhật thành công'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cart = Cart::find($id);

        $cart->delete();

        return response()->json(['message' => 'Xóa thành công'], 200);
    }
}
