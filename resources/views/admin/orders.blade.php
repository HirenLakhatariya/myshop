@extends('layout.admin')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Orders</h1>

        <!-- Success message -->
        @if(session('status'))
            <div class="alert alert-success text-center">
                {{ session('status') }}
            </div>
        @endif

        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Number</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <!-- Row coloring based on order status -->
                    <tr class="@if($order->status == 'pending') table-warning @elseif($order->status == 'completed') table-success @elseif($order->status == 'cancelled') table-danger @endif">
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->number }}</td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </form>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#itemsModal-{{ $order->id }}">
                                View Items
                            </button>
                        </td>
                    </tr>

                    <!-- Modal for View Items -->
                    <div class="modal fade" id="itemsModal-{{ $order->id }}" tabindex="-1" aria-labelledby="itemsModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="itemsModalLabel">Order Items for Order ID: {{ $order->order_id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <ul class="list-group">
                                        @foreach($order->items as $item)
                                            <li class="list-group-item d-flex justify-content-between">
                                                {{ $item->product->name }} ({{ $item->quantity }})
                                                <span class="text-muted">₹{{ number_format($item->price, 2) }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap JS and Popper.js for modals -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
