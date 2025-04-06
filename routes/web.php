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
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Auth;


Route::get('/',[MainController::class,'homePage'])->name('home');
Route::get('/sweets',[SweetController::class,'showSweet']);
Route::get('/namkeens',[SweetController::class,'showNamkeens']);
Route::get('/product', [SweetController::class, 'showAllProducts']);
Route::get('/about',[MainController::class,'about']);
Route::post('/contectus',[MainController::class,'contectUs']);
Route::get('/iteminfo/{id}',[MainController::class,'iteminfo']) ->name('item.info');
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



Route::get('products/item/{id}/edit',[AdminController::class,'ProductItemShow'])->name('item.edit');
Route::put('products/item/{id}/edit',[AdminController::class,'updateitem'])->name('items.update');
Route::delete('products/item/{id}/delete',[AdminController::class,'deleteitem'])->name('item.delete');

// Fallback login route
// Route::get('/login', function () {

//     if (request()->is('admin/*')) {
//         return redirect()->route('admin.login.form'); // Redirect admins
//     }
//     dd('here');
//     return redirect()->route('user.login.form'); // Redirect normal users
// })->name('login');

// Normal User Login Routes

// 🟢 User Authentication Routes
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('user.login.form');
Route::post('/login', [UserAuthController::class, 'login'])->name('user.login');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

// 🟢 Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login.form');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// 🛑 Ensure admin routes are protected by auth:admin
Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('admin')->group(function () {

        // 📊 Dashboard - Admin and User can see
        Route::middleware('role:Admin,User')->group(function () {
            Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        });

        // 👑 Admin Only - Register New Admin, Settings
        Route::middleware('role:Admin')->group(function () {
            Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register.form');
            Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register');
            Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        });

        // 🛒 Products View - All roles
        Route::middleware('role:Admin,Editor,User')->group(function () {
            Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
            Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
        });

        // 🛒 Products Update/Delete - Admin Only
        Route::middleware('role:Admin')->group(function () {
            // Route::post('/products', [ProductController::class, 'store'])->name('product.store');
            Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
            Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
            Route::post('/products/{id}/upload-images', [ProductController::class, 'uploadImages'])->name('product.uploadImages');
            Route::delete('/products/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
        });

        // 📦 Orders View - All roles
        Route::middleware('role:Admin,Editor,User')->group(function () {
            Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
            Route::get('/orders/{order}', [AdminController::class, 'show'])->name('orders.show');
        });

        // 📦 Orders Update - Admin Only
        Route::middleware('role:Admin,Editor')->group(function () {
            Route::delete('/admin/orders/{id}/delete', [AdminController::class, 'deleteOrder'])->name('orders.delete');
            Route::put('/orders/{id}/update-status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
            Route::get('/product/add',[ProductController::class,'addProduct'])->name('product.create'); 
            Route::post('/product/store', [ProductController::class, 'storeProduct'])->name('product.store');
        });

        // 👥 Customers & Contact Us - Admin and User only
        Route::middleware('role:Admin,User')->group(function () {
            Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
            Route::get('/contact-us', [AdminController::class, 'contactUs'])->name('admin.contactUs');
        });
    });
});


// 🟢 Fallback for undefined routes (redirect to login)
Route::fallback(function () {
    return redirect()->route('user.login.form');
});

// Route::middleware([
//     fn ($request, $next) => Auth::guard('admin')->check() ? $next($request) : redirect()->route('admin.login.form')
// ])->group(function () {

//     Route::prefix('admin')->group(function () {

//         // Only Admin can register new admins
//         Route::middleware('role:Admin')->group(function () {
//             Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register.form');
//             Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register');
//         });

//         // All roles can access the dashboard
//         Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

//         // 🛒 Products Management (Admin & Editor)
//         Route::middleware('role:Admin,Editor')->group(function () {
//             Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
//             Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
//             Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
//             Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
//             Route::post('/products/{id}/upload-images', [ProductController::class, 'uploadImages'])->name('product.uploadImages');
//             Route::delete('/products/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
//         });

//         // 📦 Order Management (Admin & Editor)
//         Route::middleware('role:Admin,Editor')->group(function () {
//             Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
//             Route::put('/orders/{id}/update-status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
//             Route::get('/orders/{order}', [AdminController::class, 'show'])->name('orders.show');
//             Route::put('/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
//         });

//         // 👥 Customers & Contact Us (All Roles can View)
//         Route::middleware('role:Admin,Editor,User')->group(function () {
//             Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
//             Route::get('/contact-us', [AdminController::class, 'contactUs'])->name('admin.contactUs');
//         });

//         // ⚙️ Admin Settings (Admin Only)
//         Route::middleware('role:Admin')->group(function () {
//             Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
//         });

//         // 🖼️ Product Image Management (Admin & Editor)
//         Route::middleware('role:Admin,Editor')->group(function () {
//             Route::get('products/{id}/images', [ProductImageController::class, 'index'])->name('admin.products.images');
//             Route::post('products/{id}/images/upload', [ProductImageController::class, 'store'])->name('admin.products.images.upload');
//             Route::delete('products/images/{image}', [ProductImageController::class, 'destroy'])->name('admin.products.images.delete');
//         });

//     });

// });





// Route::middleware(AdminMiddleware::class)->group(function () {
//     Route::prefix('admin')->group(function () {
//         Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('admin.register.form');
//         Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register');
//         Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//         Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
//         Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
//         Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
//         Route::post('/products/{id}/upload-images', [ProductController::class, 'uploadImages'])->name('product.uploadImages');
//         // Route::delete('/products/images/{id}', [ProductController::class, 'deleteImage'])->name('product.deleteImage');
//         Route::delete('/products/delete-image/{id}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');

//         // Route::post('/products/{id}/upload-images', [ProductController::class, 'uploadImages'])->name('product.upload.images');
//         // Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
//         Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
//         // Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
//         Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->name('product.delete');
//         // Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('product.edit');
        
//         // Order releted routes
//         Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
//         Route::put('orders/{id}/update-status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
//         Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
//         // Route to view orders with optional search and sorting
//         // Route::get('/orders', [AdminController::class, 'searchOrder'])->name('admin.orders');
//         Route::get('/orders/{order}', [AdminController::class, 'show'])->name('orders.show');
    
//         // Route to update order status
//         Route::put('/orders/{order}/status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
    
//         // contact us details.
//         Route::get('/contact-us', [AdminController::class, 'contactUs'])->name('admin.contactUs');
    
//         Route::get('products/{id}/images', [ProductImageController::class, 'index'])->name('admin.products.images');
//         Route::post('products/{id}/images/upload', [ProductImageController::class, 'store'])->name('admin.products.images.upload');
//         Route::delete('products/images/{image}', [ProductImageController::class, 'destroy'])->name('admin.products.images.delete');
    
//     });
// });

// Auth::routes();
// Normal user dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

