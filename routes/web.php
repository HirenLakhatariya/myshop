<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SweetController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ContactUsController;


Route::get('/',[MainController::class,'homePage'])->name('home');
Route::get('/sweets',[SweetController::class,'showSweet']);
Route::get('/farsan',[SweetController::class,'showFarsan']);
Route::get('/products',[SweetController::class,'showAllItems']);
Route::get('/about',[MainController::class,'about']);
Route::post('/contectus',[MainController::class,'contectUs']);
Route::get('/iteminfo',[MainController::class,'iteminfo']);
Route::get('/test',[MainController::class,'test']);
Route::get('/testslider',[MainController::class,'showSlider']);
Route::post('/contact-us', [ContactUsController::class, 'store'])->name('contact-us.store');
// Route::get('/contact', function () {
//     return view('contact');
// })->name('contact');
// Route::post('/contact/send', [ContactController::class, 'sendEmail'])->name('contact.send');

// Route to add to cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [CartController::class, 'viewCart'])->name('view.cart');
Route::get('/Checkout', [CartController::class, 'Checkout'])->name('view.Checkout');
Route::post('/set-phone-number', function (Illuminate\Http\Request $request) {
    $phone = $request->input('phone');

    // Validate the phone number
    if (!is_numeric($phone) || strlen($phone) !== 10) {
        return response()->json(['status' => 'error', 'message' => 'Invalid phone number'], 400);
    }

    // Save the phone number to the session
    session(['phone' => $phone]);

    return response()->json(['status' => 'success', 'redirect_url' => route('send.to.whatsapp')]);
})->name('set.phone.number');
Route::get('/send-to-whatsapp', [CartController::class, 'sendToWhatsApp'])->name('send.to.whatsapp');

// Route to display the cart
Route::post('/cart/update/{action}', [CartController::class, 'updateCart'])->name('update.cart');

// Route to send order via WhatsApp
Route::get('/upload', [ImageUploadController::class, 'showForm'])->name('image.form');
Route::post('/upload', [ImageUploadController::class, 'upload'])->name('image.upload');



Route::get('admin/products/sweets',[AdminController::class,'ShowSweets']);
Route::get('products/item/{id}/edit',[AdminController::class,'ProductItemShow'])->name('item.edit');
Route::put('products/item/{id}/edit',[AdminController::class,'updateitem'])->name('items.update');
Route::delete('products/item/{id}/delete',[AdminController::class,'deleteitem'])->name('item.delete');
Route::get('admin/products/namkeens',[AdminController::class,'ShowNamkeens']);


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
    Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('product.edit');
    
    // Order releted routes
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::put('orders/{id}/update-status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    // Route to view orders with optional search and sorting
    // Route::get('/orders', [AdminController::class, 'searchOrder'])->name('admin.orders');
    Route::get('/orders/{order}', [AdminController::class, 'show'])->name('orders.show');

    // Route to update order status
    Route::put('/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');

});