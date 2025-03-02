<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ImageUploadController extends Controller
{
    public function showForm(){
        return view('sweetform');
    }

    public function upload(Request $req){
        
        $req->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'type' => 'required',
        ]);

            $obj = new Product();
            $obj->name=$req->name;
            $obj->description=$req->description;
            $obj->price=$req->price;
            $obj->type=$req->type;

            $uploadPath = public_path('products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath,0755,true);
            }
            if ($req->file('img')) {
                $imgName = time().'.'.$req->img->extension();
                $req->img->move($uploadPath,$imgName);
                $obj->img=$imgName;
            }
            $obj->save();
                return redirect()->route('image.form')->with('Good', 'Image upload failed.');
            }
}
