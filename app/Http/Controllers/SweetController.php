<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SweetController extends Controller
{

    public function showSweet(){
        $sweet = Product::where('type','S')->get();
        return view('products',['product'=>$sweet]);
    }
    public function showNamkeens(){
        $farsan = Product::where('type','F')->get();
        return view('products',['product'=>$farsan]);
    }
    public function showAllProducts(){
        $Products = Product::get();
        return view('products',['product'=>$Products]);
    }
}
