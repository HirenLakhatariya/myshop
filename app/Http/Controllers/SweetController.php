<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SweetController extends Controller
{

    public function showSweet(){
        $sweet = Product::where('type','S')->get();
        return view('sweet',['product'=>$sweet]);
    }
    public function showFarsan(){
        $farsan = Product::where('type','F')->get();
        return view('sweet',['product'=>$farsan]);
    }
    public function showAllItems(){
        $Products = Product::get();
        return view('sweet',['product'=>$Products]);
    }
}
