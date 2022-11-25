<?php

namespace App\Http\Controllers;

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
}
