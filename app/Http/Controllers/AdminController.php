<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\Order;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch orders grouped by month
        $orders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data for Chart.js
        $months = [];
        $orderCounts = [];

        foreach ($orders as $order) {
            $months[] = Carbon::create()->month($order->month)->format('F'); // Convert month number to name
            $orderCounts[] = $order->total;
        }

        return view('admin.dashboard', compact('months', 'orderCounts'));
    }
    
    public function products()
    {
        $products= Product::all();
        return view('admin.products',['products' => $products]);
    }

    public function orders()
    {
        $orders = Order::with(['items.product'])->get();
        // dd($orders->toArray());
        return view('admin.orders',compact('orders'));
    }

    public function customers()
    {
        return view('admin.customers');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function ShowSweets(){
        $sweet = Product::where('type','S')->get();
        return view('admin/productcrud',['products' => $sweet]);
    }

    public function ShowNamkeens(){
        $farsan = Product::where('type','F')->get();
        return view('admin/productcrud',['products' => $farsan]);
    }

    public function ProductItemShow($id){
        $data = Product::find($id);
        return view('admin/editpage',['data' => $data]);
    }

    // Method to update the order status
    public function updateStatus(Request $request, $id){
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('status', 'Order status updated successfully!');
    }

    //  as of now it not in use
    public function searchOrder(Request $request)
    {
        $query = Order::query();

        // Handle Search functionality (Search by ID, Number, or Status)
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%$search%")
                  ->orWhere('number', 'like', "%$search%")
                  ->orWhere('status', 'like', "%$search%");
            });
        }

        // Handle Date Filter functionality (Filter by Date)
        if ($request->has('date')) {
            $date = $request->get('date');
            $dates = explode(' - ', $date);
            if (count($dates) == 2) {
                $startDate = $dates[0];
                $endDate = $dates[1];
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }

        // Handle Sorting functionality (Sort by Order ID)
        if ($request->has('sort')) {
            $sort = $request->get('sort');
            $query->orderBy($sort);
        }

        // Pagination (50 records per page)
        $orders = $query->with('items.product')->paginate(50);

        return view('admin/orders', compact('orders'));
    }

}
