<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductStatus;
use App\Enums\ProductUnit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Mockery\Undefined;

class ProductController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = Product::query();
    }

    public function index(Request $request)
    {
        $q = $request->q;

        $data = $this->model->with(['category', 'supplier', 'inventory'])
            ->when($q, function ($query, $q) {
                $query->where('name', 'like', '%' . $q . '%')
                    ->orWhere('description', 'like', '%' . $q . '%');
            })
            ->paginate(10)->withQueryString();

        $unit = ProductUnit::getProductUnit();
        $status = ProductStatus::getProductStatus();

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
        $file_name = time() . '_' . $request->image->getClientOriginalName();
        $file_path = $request->file('image')->storeAs('images/products', $file_name, 'public');

        $product = new Product();

        $product->name = $request->name;
        $product->description = $request->description;
        $product->manual = $request->manual;
        $product->unit = $request->unit;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->image = $file_path;

        $product->save();


        $product->inventory()->create([
            'supplier_id' => $request->supplier_id,
        ]);

        $images = explode(',', $request->images);

        foreach ($images as $image) {
            $from = public_path('tmp/uploads/' . $image);
            $to = storage_path('app/public/images/products/' . $image);


            File::move($from, $to);


            $product->images()->create([
                'name' => $image,
            ]);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công.',
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


        $product = Product::find($id);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->manual = $request->manual;
        $product->unit = $request->unit;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        if ($request->file('image') != null) {
            $file_name = time() . '_' . $request->image->getClientOriginalName();
            $file_path = $request->file('image')->storeAs('images/products', $file_name, 'public');
            Storage::disk('public')->delete($request->image);
            $product->image = $file_path;
        }

        $product->save();


        $product->inventory()->update([
            'supplier_id' => $request->supplier_id,
        ]);


        if ($request->add_images != null) {
            $add_images = explode(',', $request->add_images);

            foreach ($add_images as $image) {
                $from = public_path('tmp/uploads/' . $image);
                $to = storage_path('app/public/images/products/' . $image);


                File::move($from, $to);


                $product->images()->create([
                    'name' => $image,
                ]);
            }
        }


        if ($request->delete_images != null) {
            $delete_images = explode(',', $request->delete_images);
            foreach ($delete_images as $image) {
                Storage::disk('public')->delete('images/products/' . $image);
                $product->images()->where('name', $image)->delete();
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Sửa thành công.',
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
        $product = $this->model->find($id);
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xoá thành công.'
        ], 200);
    }

    public function listTrash(Request $request)
    {
        $q = $request->q;

        $data = product::onlyTrashed()
            ->when($q, function ($query, $q) {
                $query->where('name', 'like', '%' . $q . '%');
            })
            ->paginate(10)->withQueryString();;

        return response()->json($data, 200);
    }

    public function deleteFromTrash($id)
    {
        $product = $this->model->withTrashed()->find($id);

        $product->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xoá thành công.'
        ], 200);
    }

    public function restoreFromTrash($id)
    {
        $product = $this->model->withTrashed()->find($id);

        $product->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Khôi phục thành công.'
        ], 200);
    }

    public function getProductStatus()
    {
        $data = ProductStatus::getProductStatus();
        return response()->json($data, 200);
    }

    public function getProductUnit()
    {
        $data = ProductUnit::getProductUnit();
        return response()->json($data, 200);
    }
}
