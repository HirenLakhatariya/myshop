<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
    public function homePage(){
        $sweet = Product::where('type','S')->get();
        $farsan = Product::where('type','F')->get();
        $items = Product::all();
        return view('welcome')->with('sweet',$sweet)->with('farsan',$farsan)->with('items',$items);
    }
    public function test(){
        $sweet = Product::where('type','S')->get();
        $farsan = Product::where('type','F')->get();
        $items = Product::all();
        return view('test')->with('sweet',$sweet)->with('farsan',$farsan)->with('items',$items);
    }
    public function showSlider()
    {
        $sweet = Product::where('type','S')->get();
        $farsan = Product::where('type','F')->get();
        $items = Product::all();
        return view('testslider')->with('sweet',$sweet)->with('farsan',$farsan)->with('items',$items);
    }
    public function about(){
        return view('about');
    }
    public function contectUs(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'message' => 'required',
        ]);
        dd($data);
        return redirect()->back()->with('success', 'We will contact you soon!');
    } 
    public function iteminfo(){
        return view('iteminfo');
    }

    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);
        // Check if the product is already in the cart
        $found = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $request->id) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => 1,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // View the cart
    public function viewCart()
    {
        $cart = Session::get('cart', []);
        return view('cart', compact('cart'));
    }   

    // Send the cart details to WhatsApp
    public function sendToWhatsApp()
    {
        $cart = Session::get('cart', []);
        $message = "Hello! I would like to place an order:\n\n";

        $totalPrice = 0;

        foreach ($cart as $item) {
            $message .= "{$item['name']} - ₹{$item['price']} x {$item['quantity']} KG  \n";
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $message .= "\nTotal Price: ₹{$totalPrice}";

        $phoneNumber = '8000709370'; // Replace with your WhatsApp number
        $encodedMessage = urlencode($message);
        Session::forget('cart');
        return redirect("https://wa.me/{$phoneNumber}?text={$encodedMessage}");
    }

}
