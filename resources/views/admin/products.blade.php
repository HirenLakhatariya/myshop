@extends('layout.admin')

@section('content')
    <div class="container">
        <h1>Products</h1>
        <div class="container">
            @if(session('msg successful'))
                    <div class="alert alert-primary" role="alert">
                    {{ session('msg successful') }}
                    </div>
            @endif
            @if(session('msg danger'))
                <div class="alert alert-danger" role="alert">
                {{ session('msg') }}
                </div>
            @endif
        </div>
        <button class="btn btn-primary">Add New Product</button>
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
	                <th>Image</th>
                    <th>Product Name</th>
	                <th>Product Info</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Is Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @php $i = 1 @endphp
            @foreach($products as $item)
            <tr>
            <th>{{$i}}</th>
            <td><img src="{{ asset('products/' . $item->img) }}" style="width:100px"></td>
            <td>{{$item->name}}</td>
            <td>{{$item->description}}</td>
            <td>{{$item->price}}</td>
            <td>5</td>
            <td>{{ $item->is_active ? 'Yes' : 'No' }}</td>
            <td>
                <div class="action-buttons">
                <a class="btn btn-primary edit-product-btn" data-id="{{ $item->id }}" role="button">Edit</a>
                    <form method="POST" action="{{ route('product.delete', $item->id) }}" class="delete-form d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger Deletepopup">Delete</button>
                    </form>
                </div>
            </td>
            </tr>
            @php $i++ @endphp
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form Fields -->
                        <input type="hidden" id="editProductId" name="id">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Name</label>
                            <input type="text" id="editProductName" name="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Description</label>
                            <textarea id="editProductDescription" name="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Price</label>
                            <input type="number" id="editProductPrice" name="price" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="editProductStock" class="form-label">Stock</label>
                            <input type="number" id="editProductStock" name="stock" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Product Image</label>
                            <input type="file" id="editProductImage" name="img" class="form-control">
                            <img id="currentProductImage" src="" alt="Current Image" style="max-width: 50%; margin-top: 10px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
