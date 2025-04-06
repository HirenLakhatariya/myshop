<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;


class ProductImageController extends Controller
{
    // Show images for a particular product
    public function index($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('admin.images', compact('product'));
    }

    // Store uploaded images
    public function store(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'storage/' . $imagePath, // Store relative path
            ]);
        }

        return redirect()->route('admin.products.images', $id)->with('success', 'Image uploaded successfully.');
    }

    // Delete an image
    public function destroy(ProductImage $image)
    {
        if (Storage::disk('public')->exists(str_replace('storage/', '', $image->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));
        }

        $image->delete();
        return back()->with('success', 'Image deleted successfully.');
    }
}
