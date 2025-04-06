<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

use function Laravel\Prompts\alert;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(Request $request) {
        $query = Product::query();

        // 🔍 Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('price', 'LIKE', "%{$search}%");
            });
        }

        // 🔁 Sort
        $sortField = $request->get('sort_by', 'id');
        $sortDirection = $request->get('order', 'desc');

        // 📄 Pagination
        $products = $query->orderBy($sortField, $sortDirection)
                            ->paginate(8)
                            ->appends($request->all());

        return view('admin.products', compact('products', 'sortField', 'sortDirection'));
    }

    public function show($id) {
        $product = Product::with('images')->findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $req, $id) {
        $product = Product::findOrFail($id);
        $product->update($req->only(['name', 'description', 'price', 'is_active']));

        if ($req->hasFile('img')) {
            $imgName = time() . '_' . $req->file('img')->getClientOriginalName();
            $req->file('img')->move(public_path('products'), $imgName);
            $product->img = 'products/' . $imgName;
            $product->save();
        }

        return response()->json(['message' => 'Product updated successfully!']);
    }

    public function uploadImages(Request $req, $id) {
        foreach ($req->file('images') as $image) {
            $imgName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('products'), $imgName);
            ProductImage::create([
                'product_id' => $id,
                'image_path' => 'products/' . $imgName
            ]);
        }

        return response()->json(['message' => 'Images uploaded successfully!']);
    }

    public function deleteImage($id)
    {
        $image = ProductImage::find($id);
        
        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }

        // Delete the image file from storage
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }
    
        // Delete from DB
        $image->delete();
    
        return response()->json(['success' => 'Image deleted']);
    }

    public function addProduct()
    {
        return view('admin.product_create');
    }

    public function storeProduct(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'img' => 'required|image|mimes:jpeg,png,jpg',
            'images.*' => 'image|mimes:jpeg,png,jpg',
        ]);

        // Save main image
        $mainImgName = time() . '_' . $request->img->extension();
        $request->img->move(public_path('products'), $mainImgName);
        $mainImagePath = 'products/' . $mainImgName;
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'img' => $mainImagePath,
            'type' => $request->type ?? '',
            'is_active' => $request->is_active,
        ]);
        // Save additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->extension();
                $image->move(public_path('products'), $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'products/' . $imageName,
                ]);
            }
        }

        return redirect()->route('admin.products')->with('msg_successful', 'Product added successfully!');
    }
    public function deleteProduct($id)
    {
        $item = Product::findOrFail($id);
    
        if ($item) {
            // 🔹 Delete Main Product Image
            $mainImagePath = public_path($item->img);
            if (file_exists($mainImagePath)) {
                unlink($mainImagePath);
            }
    
            // 🔹 Delete Additional Images
            foreach ($item->images as $img) {
                $imgPath = public_path($img->image_path);
                if (file_exists($imgPath)) {
                    unlink($imgPath);
                }
                $img->delete(); // delete DB record
            }
    
            // 🔹 Delete Product Record
            $item->delete();
    
            return redirect()->back()->with('msg_successful', 'Item deleted successfully');
        }
    
        return redirect()->back()->with('msg_danger', 'Item not deleted');
    }
    
}

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Product;
// use Illuminate\Support\Facades\Redirect;
// use App\Models\ProductImage;


// class ProductController extends Controller
// {
//     public function show($id) {
//         $product = Product::findOrFail($id);
//         $images = $product->images; // Fetch related images
    
//         return response()->json([
//             'product' => $product,
//             'images' => $images
//         ]);
//     }
//     public function uploadImages(Request $request, $productId)
//     {
//         $request->validate([
//             'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validate images
//         ]);

//         if ($request->hasFile('images')) {
//             foreach ($request->file('images') as $image) {
//                 $imagePath = $image->store('products', 'public'); // Store images in 'storage/app/public/products'

//                 ProductImage::create([
//                     'product_id' => $productId,
//                     'image_path' => $imagePath
//                 ]);
//             }
//         }

//         return response()->json(['message' => 'Images uploaded successfully']);
//     }
    
//     // public function updateProduct(Request $req, $id) {
//     //     $data = Product::findOrFail($id);
    
//     //     // Update only modified fields
//     //     $updates = array_filter(
//     //         $req->only(['name', 'description', 'price', 'is_active']),
//     //         fn($value, $key) => $value != $data->$key,
//     //         ARRAY_FILTER_USE_BOTH
//     //     );
//     //     $data->fill($updates);
    
//     //     // Handle new image uploads
//     //     if ($req->hasFile('images')) {
//     //         foreach ($req->file('images') as $file) {
//     //             $imgName = time() . '_' . $file->getClientOriginalName();
//     //             $file->move(public_path('products'), $imgName);
    
//     //             ProductImage::create([
//     //                 'product_id' => $id,
//     //                 'image_path' => 'products/' . $imgName,
//     //             ]);
//     //         }
//     //     }
    
//     //     // Save only if data has changed
//     //     if ($data->isDirty()) {
//     //         $data->save();
//     //         return Redirect::back()->with('msg', 'Update successful!');
//     //     }
//     //     return Redirect::back()->with('msg', 'No changes were made.');
//     // }
//     public function updateProduct(Request $req, $id) {
//         $product = Product::findOrFail($id);
    
//         // ✅ Update fields only if they are present
//         $product->update($req->only(['name', 'description', 'price', 'is_active']));
    
//         // ✅ Handle new main image upload
//         if ($req->hasFile('img')) {
//             $imgName = time() . '_' . $req->file('img')->getClientOriginalName();
//             $req->file('img')->move(public_path('products'), $imgName);
//             $product->img = 'products/' . $imgName;
//             $product->save();
//         }
    
//         return response()->json(['message' => 'Product updated successfully!']);
//     }
    

//     // Delete additional images
//     public function deleteProductImage($id) {
//         $image = ProductImage::findOrFail($id);
//         $filePath = public_path($image->image_path);

//         if (file_exists($filePath)) {
//             unlink($filePath); // Delete file
//         }

//         $image->delete();
//         return response()->json(['msg' => 'Image deleted successfully']);
//     }
// }
