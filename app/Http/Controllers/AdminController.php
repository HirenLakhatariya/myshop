<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\Order;
use App\Models\ContactUs;
use App\Models\Orderitem;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{
    
    public function dashboard()
    {
        // Orders per month
        $orders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');
    
        $months = [];
        $orderCounts = [];
    
        foreach (range(1, now()->month) as $month) {
            $months[] = Carbon::create()->month($month)->format('F');
            $orderCounts[] = $orders[$month] ?? 0;
        }
    
        // Monthly product sales (line chart)
        $productSalesRaw = Orderitem::selectRaw('MONTH(orderitems.created_at) as month')
            ->join('products', 'orderitems.product_id', '=', 'products.id')
            ->selectRaw('products.name as product_name, SUM(orderitems.quantity) as total_sold')
            ->groupBy('month', 'product_name')
            ->orderBy('month')
            ->get();
    
        // Ensure all months are present
        $salesLabels = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        })->toArray();
    
        // Structure product-wise monthly data
        $productsData = [];
        foreach ($productSalesRaw as $sale) {
            $monthName = Carbon::create()->month($sale->month)->format('F');
            $productsData[$sale->product_name][$monthName] = $sale->total_sold;
        }
    
        // Fill missing months with 0
        $allProductData = collect($productsData)->map(function ($sales, $productName) use ($salesLabels) {
            $data = collect($salesLabels)->map(fn($month) => $sales[$month] ?? 0)->toArray();
            return [
                'label' => $productName,
                'data' => $data,
            ];
        })->values();
    
        // Pie chart (total sales by product)
        $pieChartData = Orderitem::join('products', 'orderitems.product_id', '=', 'products.id')
            ->select('products.name as product_name', DB::raw('SUM(orderitems.quantity) as total_sold'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->get()
            ->map(fn($item) => [
                'label' => $item->product_name,
                'value' => (int) $item->total_sold,
        ]);
        
        // Monthly Order Count + Total Amount
        $monthlyOrderStats = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total_orders, SUM(total_amount) as total_amount')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $orderSalesMonths = [];
        $orderCounts = [];
        $totalAmounts = [];

        foreach ($monthlyOrderStats as $row) {
        $orderSalesMonths[] = Carbon::create()->month($row->month)->format('F');
        $orderCounts[] = (int) $row->total_orders;
        $totalAmounts[] = (float) $row->total_amount;
        }


        return view('admin.dashboard', [
            'months' => $months,
            'orderCounts' => $orderCounts,
            'salesLabels' => $salesLabels,
            'allProductData' => $allProductData,
            'pieChartData' => $pieChartData,
            'orderSalesMonths' => $orderSalesMonths,
            'orderCounts' => $orderCounts,
            'totalAmounts' => $totalAmounts,
        ]);
    }
    

    public function products() {
        $products= Product::all();
        return view('admin.products',['products' => $products]);
    }

    public function orders(Request $request)
    {
        $query = Order::query();
    
        // 🔍 Search filter
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'LIKE', "%{$search}%")
                  ->orWhere('number', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }
    
        // 🔁 Sorting
        $sortField = $request->query('sort_by', 'id');
        $sortDirection = $request->query('order', 'desc');
    
        // 📄 Pagination (15 per page as you wanted earlier)
        $orders = $query->orderBy($sortField, $sortDirection)
                        ->paginate(8)
                        ->appends($request->all());
    
        return view('admin.orders', compact('orders', 'sortField', 'sortDirection'));
    }
    
    public function customers()
    {
        return view('admin.customers');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function ProductItemShow($id){
        $data = Product::find($id);
        return view('admin/editpage',['data' => $data]);
    }

    // Method to update the order status
    public function updateStatus(Request $request, $id){
        // dd($request->all());
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

    public function contactUs(Request $request){
        $sort = $request->get('sort', 'id'); // Default sorting by ID
        $order = $request->get('order', 'asc'); // Default order is ascending
    
        $validColumns = ['id', 'name', 'email', 'contact_number', 'created_at']; // Valid columns for sorting
    
        if (!in_array($sort, $validColumns)) {
            $sort = 'id'; // Fallback to default if invalid column is provided
        }
    
        $ContactUsInfo = ContactUs::orderBy($sort, $order)->paginate(10);
    
        return view('admin/contact-us', compact('ContactUsInfo'));
    }

    public function deleteOrder($id) {
        $order = Order::findOrFail($id);

        // Start transaction
        DB::beginTransaction();

        try {
            // Delete related order items
            Orderitem::where('order_id', $order->order_id)->delete();

            // Delete the order
            $order->delete();

            DB::commit();
            return redirect()->back()->with('status', 'Order deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('status', 'Error deleting order: ' . $e->getMessage());
        }
    }

}
