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
    function codeLog($data, $filename = 'local') {
        $logPath = storage_path("logs/{$filename}.log");
        dd($logPath);
        $logData = "[" . now() . "] " . print_r($data, true) . "\n";

        file_put_contents($logPath, $logData, FILE_APPEND);
    }
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
        $cartCount = count($cart);
        $firstItemName = $cart[0]['name'] ?? null;
        return response()->json([
            'success' => true,
            'cartItems' => $cart,
            'cart_count' => $cartCount,
            'first_item_name' => $firstItemName,
            'message' => 'Product added to cart!',
        ]);
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
            foreach ($cart as &$item) {
                if ($item['id'] == $request->id) {
                    $current = $item['quantity'];
        
                    if ($action === 'plus') {
                        if ($current === 200) {
                            $item['quantity'] = 500;
                        } elseif ($current === 500) {
                            $item['quantity'] = 1000;
                        } elseif ($current === 1000) {
                            $item['quantity'] = 1200;
                        } else {
                            // After 1000g, alternate +200g and +300g to match pattern
                            $lastStep = $current % 500 === 0 ? 200 : 300;
                            $item['quantity'] = $current + $lastStep;
                        }
                    }
        
                    if ($action === 'minus') {
                        if ($current === 500) {
                            $item['quantity'] = 200;
                        } elseif ($current === 1000) {
                            $item['quantity'] = 500;
                        } elseif ($current === 1200) {
                            $item['quantity'] = 1000;
                        } elseif ($current > 1200) {
                            // Reverse alternate: subtract 200 if mod 700, else subtract 300
                            $lastStep = ($current - 200) % 500 === 0 ? 200 : 300;
                            $item['quantity'] = max(200, $current - $lastStep);
                        }
                    }
                }
            }
        }
    
        Session::put('cart', array_values($cart));
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
