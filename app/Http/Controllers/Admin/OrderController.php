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

        foreach ($order->products as $product) {
            $inventory = Inventory::where('product_id', $product->id)->first();
            if ($inventory->quantity < $product->pivot->quantity) {
                return response()->json(
                    [
                        'message' =>
                            'Sản phẩm ' .
                            $product->name .
                            ' không đủ số lượng để đáp ứng đơn hàng',
                    ],
                    422
                );
            }
        }

        $order->status = 1;
        $order->save();

        foreach ($order->products as $product) {
            $inventory = Inventory::where('product_id', $product->id)->first();
            $inventory->quantity =
                $inventory->quantity - $product->pivot->quantity;
            $inventory->save();

            $inventory->logs()->create([
                'quantity' => $product->pivot->quantity,
                'remain' => $inventory->quantity,
                'status' => 1,
            ]);

            if ($inventory->quantity <= 0) {
                $inventory->status = 2;
                $inventory->save();

                $product = $inventory->product;
                $product->status = 1;
                $product->save();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Order successfully approved',
        ]);
    }

    public function cancel($id)
    {
        $order = Order::with('products')->find($id);
        if ($order->status == 1) {
            foreach ($order->products as $product) {
                $inventory = Inventory::where(
                    'product_id',
                    $product->id
                )->first();

                $inventory->quantity =
                    $inventory->quantity + $product->pivot->quantity;

                $inventory->status = 1;
                $inventory->save();

                $inventory->logs()->create([
                    'quantity' => $product->pivot->quantity,
                    'remain' => $inventory->quantity,
                    'status' => 2,
                ]);

                $product = $inventory->product;
                $product->status = 0;
                $product->save();
            }
        }
        $order->status = 2;
        $order->save();

        return response()->json([
            'status' => 200,
            'message' => 'Order successfully canceled',
        ]);
    }
}
