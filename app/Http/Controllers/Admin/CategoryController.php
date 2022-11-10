<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $model;

    public function __construct()
    {
        $this->model = Category::query();
    }

    public function index(Request $request)
    {
        $q = $request->q;

        $data = $this->model
            ->when($q, function ($query, $q) {
                $query->where('name', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%');
            })
            ->paginate(10)->withQueryString();

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
        $category = new Category();

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return response()->json([
            'message' => 'Thêm thành công.'
        ], 200);
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
    public function update(UpdateRequest $request, $id)
    {
        $category = $this->model->find($id);

        if ($category == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy danh mục.'
            ], 422);
        }

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sửa thành công.'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->model->find($id);

        if ($category == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy danh mục.'
            ], 422);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xoá thành công.'
        ], 200);
    }

    public function listTrash(Request $request)
    {
        $q = $request->q;

        $data = Category::onlyTrashed()
            ->when($q, function ($query, $q) {
                $query->where('name', 'like', '%' . $q . '%');
            })
            ->paginate(10)->withQueryString();;

        return response()->json($data, 200);
    }

    public function deleteFromTrash($id)
    {
        $category = $this->model->withTrashed()->find($id);

        $category->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xoá thành công.'
        ]);
    }

    public function restoreFromTrash($id)
    {
        $category = $this->model->withTrashed()->find($id);

        $category->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Khôi phục thành công.'
        ]);
    }
}
