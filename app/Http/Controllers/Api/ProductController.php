<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::latest()
        ->get();

        return $this->sendSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id'=>'nullable',
            'photo'=>'required|image',
            'name'=>'required|unique:products,name',
            'description'=>'required',
            'price'=>'required'
        ]);

        $upload = Storage::put('image',$request->photo);
        $photo = "storage/{$upload}";

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
            Product::create([
                'category_id'=>$request->category_id,
                'photo'=>$photo,
                'name'=>$request->name,
                'description'=>$request->description,
                'price'=>$request->price
            ]);

            return $this->sendMessage("Produk $request->name berhasil ditambahkan");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Product::find($id);
        return $this->sendSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'category_id'=>'nullable',
            'photo'=>'nullable',
            'name'=>['required',Rule::unique('products')->ignore($id)],
            'description'=>'required',
            'price'=>'required'
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
            if ($request->photo==null) {
                Product::findOrFail($id)
                ->update([
                    'category_id'=>$request->category_id,
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'price'=>$request->price
                ]);
            }else{
                $dataunlink = Product::find($id);
                $unlinkimg = substr($dataunlink['photo'],strpos($dataunlink['photo'],'/')+1);
                Storage::delete($unlinkimg);
                $upload = Storage::put('image',$request->photo);
                $photo = "storage/{$upload}";

                Product::findOrFail($id)
                ->update([
                    'category_id'=>$request->category_id,
                    'photo'=>$photo,
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'price'=>$request->price
                ]);
            }

            return $this->sendMessage("Produk $request->name berhasil diubah");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::find($id)->photo;
        $unlinkimg = substr($data,strpos($data,'/')+1);
        Storage::delete($unlinkimg);

        Product::findOrFail($id)
        ->delete();

         return $this->sendMessage('Data berhasil dihapus');
    }
}
