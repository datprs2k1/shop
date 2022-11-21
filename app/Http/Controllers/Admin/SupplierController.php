<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\StoreRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $model;

    public function __construct()
    {
        $this->model = Supplier::query();
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
        $file_name = time() . '_' . $request->logo->getClientOriginalName();
        $file_path = $request->file('logo')->storeAs('images/suppliers', $file_name, 'public');

        $supplier = new Supplier();

        $supplier->name = $request->name;
        $supplier->description = $request->description;
        $supplier->address = $request->address;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->website = $request->website;
        $supplier->logo = '/storage/' . $file_path;

        $supplier->save();

        File::cleanDirectory(public_path('/tmp/uploads'));


        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công.',
        ], 201);
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
        $supplier = $this->model->find($id);

        $supplier->name = $request->name;
        $supplier->description = $request->description;
        $supplier->address = $request->address;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->website = $request->website;

        if ($request->file('logo') != null) {
            Storage::disk('public')->delete($supplier->logo);
            $file_name = time() . '_' . $request->logo->getClientOriginalName();
            $file_path = $request->file('logo')->storeAs('images/suppliers', $file_name, 'public');
            $supplier->logo = '/storage/' . $file_path;
        }

        $supplier->save();

        File::cleanDirectory(public_path('/tmp/uploads'));

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
        $supplier = $this->model->find($id);
        $supplier->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xoá thành công.'
        ], 200);
    }

    public function listTrash(Request $request)
    {
        $q = $request->q;

        $data = Supplier::onlyTrashed()
            ->when($q, function ($query, $q) {
                $query->where('name', 'like', '%' . $q . '%');
            })
            ->paginate(10)->withQueryString();;

        return response()->json($data, 200);
    }

    public function deleteFromTrash($id)
    {
        $supplier = $this->model->withTrashed()->find($id);

        $supplier->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xoá thành công.'
        ]);
    }

    public function restoreFromTrash($id)
    {
        $supplier = $this->model->withTrashed()->find($id);

        $supplier->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Khôi phục thành công.'
        ]);
    }
}
