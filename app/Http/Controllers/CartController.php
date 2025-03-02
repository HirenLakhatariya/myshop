<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderitem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // Add to Cart
    // public function addToCart(Request $request){
    //     $cart = Session::get('cart', []);
    //     // Check if the product is already in the cart
    //     $found = false;
    //     foreach ($cart as &$item) {
    //         if ($item['id'] == $request->id) {
    //             $item['quantity'] += 1;
    //             $found = true;
    //             break;
    //         }
    //     }

    //     if (!$found) {
    //         $cart[] = [
    //             'id' => $request->id,
    //             'name' => $request->name,
    //             'price' => $request->price,
    //             'quantity' => 1,
    //         ];
    //     }
    //     Session::put('cart', $cart);

    //     return redirect()->back()->with('success', 'Product added to cart!');
    // }
    
    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);
    
        // Convert quantity to grams if needed
        $quantity = $request->quantity;
        $quantityInGrams = $this->convertQuantityToGrams($quantity);
        $found = false;
        // dd($quantityInGrams);
        foreach ($cart as &$item) {
            if ($item['id'] == $request->id) {
                // Update quantity instead of incrementing by 1
                $item['quantity'] += $quantityInGrams;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'id' => $request->id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $quantityInGrams, // Store quantity in grams
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // Helper function to convert quantity to grams
    private function convertQuantityToGrams($quantity)
    {
        switch ($quantity) {
            case '200': return 200;
            case '500': return 500;
            case '1k': return 1000;
            case '5k': return 5000;
            default: return 1000; // Default to 1kg
        }
    }
    

    // View Cart
    public function viewCart()
    {
        $cart = Session::get('cart', []);
        return view('cart', compact('cart'));
    }

    public function updateCart(Request $request, $action) {
        $cart = Session::get('cart', []);
    
        if ($action === 'delete') {
            // Remove item from cart
            $cart = array_filter($cart, function ($item) use ($request) {
                return $item['id'] != $request->id;
            });
        } else {
            // Define weight rules
            $weightMap = [
                'minus' => [200 => 200, 500 => 200, 1000 => 500],
                'plus'  => [200 => 500, 500 => 1000]
            ];
    
            foreach ($cart as &$item) {
                if ($item['id'] == $request->id) {
                    $currentWeight = $item['quantity'];
    
                    if ($action === 'minus') {
                        // Decrease quantity using mapping or reduce by 1kg
                        $item['quantity'] = $weightMap['minus'][$currentWeight] ?? max(200, $currentWeight - 1000);
                    } elseif ($action === 'plus') {
                        // Increase quantity using mapping or increase by 1kg
                        $item['quantity'] = $weightMap['plus'][$currentWeight] ?? $currentWeight + 1000;
                    }
                }
            }
        }
    
        Session::put('cart', array_values($cart)); // Reset array keys
        return redirect()->route('view.cart')->with('success', 'Cart updated!');
    }
    

    // Send the cart details to WhatsApp
    public function sendToWhatsApp()
    {
        $phone = Session::get('phone');
        $cart = Session::get('cart', []);
        $message = "Hello! I would like to place an order:\n\n";
    
        $totalPrice = 0;
        foreach ($cart as $item) {
            $quantityInKg = $item['quantity'] / 1000; // Convert grams to KG
            $itemTotalPrice = $item['price'] * $quantityInKg; // Calculate item total price
    
            $message .= "{$item['name']} - ₹{$item['price']} per KG x {$quantityInKg} KG = ₹{$itemTotalPrice} \n";
            $totalPrice += $itemTotalPrice;
        }
    
        // Save order to database
        $this->createOrder($phone, $cart, $totalPrice);
    
        $message .= "\nTotal Price: ₹{$totalPrice}";
    
        $phoneNumber = '9327407161'; // Replace with your WhatsApp number
        $encodedMessage = urlencode($message);
    
        // Clear cart and phone session after order is sent
        Session::forget('cart');
        Session::forget('phone');
    
        return redirect("https://wa.me/{$phoneNumber}?text={$encodedMessage}");
    }    

    public function createOrder($phone, $cart, $totalPrice){
        $orderInfo = new Order();
        $orderInfo->number = $phone;
        $orderInfo->total_amount = $totalPrice;
        $orderInfo->save();
        foreach ($cart as $item) {
            $order_ItemInfo = new Orderitem();
            $order_ItemInfo->order_id = $orderInfo->order_id;
            $order_ItemInfo->product_id = $item['id'];
            $order_ItemInfo->quantity = $item['quantity'];
            $order_ItemInfo->price = $item['price'];
            $order_ItemInfo->save();
        }
        return $orderInfo;
    }
}
