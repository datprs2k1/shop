<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Models\Category;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    public function index()
    {
        $data = Category::with('products')->get();

        return response()->json($data, 200);
    }

    public function detail($id)
    {
        $data = Category::with('products')->find($id);

        return response()->json($data, 200);
    }

    public function export()
    {
        return Excel::download(new CategoryExport, 'users.xlsx');
    }
}
