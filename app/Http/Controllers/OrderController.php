<?php

namespace App\Http\Controllers;

use App\Enums\OrderMethod;
use App\Enums\OrderStatus;
use App\Http\Requests\Order\StoreRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
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
        $data = Order::where('user_id', auth()->id())->get();

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
        $cart = Cart::where('user_id', auth()->id())->get();

        $total = 0;

        foreach ($cart as $item) {
            $total += $item->product->price * $item->quantity;
        }

        $order = new Order();
        $order->user_id = auth()->id();
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->ward = $request->ward;
        $order->district = $request->district;
        $order->city = $request->city;
        $order->method = $request->method;
        $order->total = $total;
        $order->save();

        foreach ($cart as $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $item->product_id;
            $orderDetail->quantity = $item->quantity;
            $orderDetail->price = $item->product->price;
            $orderDetail->total = $item->product->price * $item->quantity;
            $orderDetail->save();
        }

        Cart::where('user_id', auth()->id())->delete();

        return response()->json([
            'message' => 'Order successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Order::with('products')->where('user_id', auth()->id())->where('id', $id)->first();

        return response()->json($data, 200);
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

    public function getMethod()
    {
        return response()->json([
            'status' => 200,
            'data' => OrderMethod::getOrderMethod()
        ]);
    }

    public function getStatus()
    {
        return response()->json([
            'status' => 200,
            'data' => OrderStatus::getOrderStatus()
        ]);
    }
}
