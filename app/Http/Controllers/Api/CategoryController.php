<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::latest()
        ->get();

        return $this->sendSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'icon'=>'required|image',
            'name'=>'required|unique:categories,name'
        ]);

        $upload = Storage::put('image',$request->icon);
        $icon = "storage/{$upload}";

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
            Category::create([
                'icon'=>$icon,
                'name'=>$request->name
            ]);

            return $this->sendMessage("Kategori $request->name berhasil ditambahkan");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Category::find($id);
        return $this->sendSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'icon'=>'nullable',
            'name'=>['required',Rule::unique('categories')->ignore($id)]
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequest($validator->messages());
        }else{
            if($request->icon == null){
                Category::findOrFail($id)
                ->update([
                    'name'=>$request->name
                ]);
            }else{
                $dataunlink = Category::find($id)->icon;
                $unlinkimg = substr($dataunlink,strpos($dataunlink,'/')+1);
                Storage::delete($unlinkimg);
                $upload = Storage::put('image',$request->icon);
                $icon = "storage/{$upload}";

                Category::findOrFail($id)
                ->update([
                    'icon'=>$icon,
                    'name'=>$request->name
                ]);
            }

            return $this->sendMessage("Kategori $request->name berhasil diubah");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Category::find($id)->icon;
        $unlinkimg = substr($data,strpos($data,'/')+1);
        Storage::delete($unlinkimg);

        Category::findOrFail($id)
        ->delete();

        return $this->sendMessage('Data berhasil dihapus');
    }
}
