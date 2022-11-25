<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::paginate(10)->withQueryString();

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approve($id)
    {
        $order = Order::with('products')->find($id);
        $order->status = 1;
        $order->save();

        foreach ($order->products as $product) {
            $inventory = Inventory::where('product_id', $product->id)->first();
            $inventory->quantity = $inventory->quantity - $product->pivot->quantity;
            $inventory->save();

            $inventory->logs()->create([
                'quantity' => $product->pivot->quantity,
                'status' => 1
            ]);

            if ($inventory->quantity <= 0) {
                $product = $inventory->product;
                $product->status = 0;
                $product->save();
            }
        }


        return response()->json([
            'status' => 200,
            'message' => 'Order successfully approved'
        ]);
    }

    public function cancel($id)
    {
        $order = Order::with('products')->find($id);
        $order->status = 2;
        $order->save();

        foreach ($order->products as $product) {
            $inventory = Inventory::where('product_id', $product->id)->first();
            $inventory->quantity = $inventory->quantity + $product->pivot->quantity;
            $inventory->save();

            $inventory->logs()->create([
                'quantity' => $product->pivot->quantity,
                'status' => 2
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Order successfully canceled'
        ]);
    }
}
