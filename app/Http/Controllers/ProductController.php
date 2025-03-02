<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function show($id) {

        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function updateProduct(Request $req, $id){
        $data = Product::findOrFail($id);
        
        // Update only modified fields
        $updates = array_filter(
        $req->only(['name', 'description', 'price', 'is_active']),
        fn($value, $key) => $value != $data->$key,
        ARRAY_FILTER_USE_BOTH
        );
        $data->fill($updates);

        // Handle image upload
        if ($req->hasFile('img')) {
            $uploadPath = public_path('products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $imgName = time() . '.' . $req->file('img')->extension();
            $req->file('img')->move($uploadPath, $imgName);
            // Remove old image if exists
            if ($data->img && file_exists(public_path('products/' . $data->img))) {
                unlink(public_path('products/' . $data->img));
            }
            $data->img = $imgName;
        }

        // Save only if data has changed
        if ($data->isDirty()) {
            $data->save();
            return Redirect::back()->with('msg', 'Update successful!');
        }
        return Redirect::back()->with('msg', 'No changes were made.');
    }
    
    public function deleteProduct($id){
        $item = Product::findOrFail($id);
        if ($item) {
            $filePath = public_path('products/' . $item->img);
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file
            }
            // Delete the product record from the database
            $item->delete();
            return redirect::back()->with('msg successful','Item deleted successful');
        }
        return redirect::back()->with('msg danger','Item Not deleted');
    }
}
