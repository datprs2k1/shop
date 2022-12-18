<?php

namespace App\Http\Controllers;

use App\Http\Requests\Address\StoreRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function city()
    {
        return response()->file(public_path('address/index.json'));
    }

    public function district($city)
    {
        return response()->file(public_path('address/data/' . $city . '.json'));
    }

    public function index()
    {
        $data = Address::where('user_id', auth()->user()->id)->get();

        return response()->json($data, 200);
    }

    public function store(StoreRequest $request)
    {
        $address = new Address();

        $address->user_id = auth()->user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->district = $request->district;
        $address->ward = $request->ward;

        $address->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công.',
        ], 200);
    }
}
