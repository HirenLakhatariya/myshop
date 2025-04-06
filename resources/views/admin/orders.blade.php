@extends('layout.admin')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Orders</h1>

    <!-- 🔍 Search Bar -->
    <form method="GET" action="{{ route('admin.orders') }}" class="d-flex justify-content-end mb-4">
        <input type="text" name="search" class="form-control w-25 me-2" placeholder="Search Order ID / Number / Status" value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <!-- ✅ Orders Table -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                @php
                    $headers = [
                        'order_id' => 'Order ID',
                        'number' => 'Number',
                        'total_amount' => 'Total Amount',
                        'status' => 'Status',
                    ];
                @endphp

                @foreach ($headers as $field => $label)
                    @php
                        $direction = ($sortField === $field && $sortDirection === 'asc') ? 'desc' : 'asc';
                        $arrow = '';

                        if ($sortField === $field) {
                            $arrow = $sortDirection === 'asc' ? '↑' : '↓';
                        }
                    @endphp
                    <th>
                        <a href="{{ route('admin.orders', array_merge(request()->all(), ['sort_by' => $field, 'order' => $direction])) }}" class="text-white text-decoration-none">
                            {{ $label }} {!! $arrow !!}
                        </a>
                    </th>
                @endforeach
                <th>Update Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr class="@if($order->status == 'pending') table-warning @elseif($order->status == 'completed') table-success @elseif($order->status == 'cancelled') table-danger @endif">
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->number }}</td>
                    <td>₹{{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>

                    <!-- Status Update -->
                    <td>
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>

                    <!-- View Items Button -->
                    <td class="d-flex gap-2">
                        <!-- View Items Button -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#itemsModal-{{ $order->id }}">
                            View Items
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="itemsModal-{{ $order->id }}" tabindex="-1" aria-labelledby="itemsModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Order Items for {{ $order->order_id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="list-group">
                                    @foreach($order->items as $item)
                                        <li class="list-group-item d-flex justify-content-between">
                                            {{ $item->product->name }} ({{ $item->quantity }})
                                            <span>₹{{ number_format($item->price, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <tr><td colspan="7" class="text-center">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- 📄 Pagination -->
    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
</div>
    <!-- Add Bootstrap JS and Popper.js for modals -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
