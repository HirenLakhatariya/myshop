@extends('layout.admin')

@section('content')
<div class="container">
    <h1>Products</h1>
    <div class="container">
        @if(session('msg_successful'))
            <div class="alert alert-primary" role="alert">
                {{ session('msg_successful') }}
            </div>
        @endif
        @if(session('msg_danger'))
            <div class="alert alert-danger" role="alert">
                {{ session('msg_danger') }}
            </div>
        @endif
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
        <a href="{{ route('product.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Product
        </a>

        <form class="d-flex align-items-center" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Search products...">
            <button class="btn btn-outline-primary">
                <i class="bi bi-search"></i> Search
            </button>
        </form>
    </div>
    <div class="product-table-wrapper">
        <table class="table table-striped table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>
                        <a href="{{ route('admin.products', ['sort_by' => 'id', 'order' => $sortField === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc'] + request()->except(['page'])) }}">
                            ID
                            @if($sortField === 'id')
                                <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif

                        </a>
                    </th>
                    <th>Main Image</th>
                    <th>
                        <a href="{{ route('admin.products', ['sort_by' => 'name', 'order' => $sortField === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc'] + request()->except('page')) }}">
                            Name {!! $sortField === 'name' ? '<i class="bi bi-arrow-' . ($sortDirection === 'asc' ? 'up' : 'down') . '"></i>' : '' !!}
                        </a>
                    </th>
                    <th>Description</th>
                    <th>
                        <a href="{{ route('admin.products', ['sort_by' => 'price', 'order' => $sortField === 'price' && $sortDirection === 'asc' ? 'desc' : 'asc'] + request()->except('page')) }}">
                            Price {!! $sortField === 'price' ? '<i class="bi bi-arrow-' . ($sortDirection === 'asc' ? 'up' : 'down') . '"></i>' : '' !!}
                        </a>
                    </th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Gallery</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $i => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset($item->img) }}" class="img-thumbnail" style="width: 80px; height: auto;">
                    </td>
                    <td>{{ $item->name }}</td>
                    <td class="text-truncate" style="max-width: 200px;">{{ $item->description }}</td>
                    <td>₹{{ $item->price }}</td>
                    <td>5</td>
                    <td>
                        <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($item->images as $image)
                                <img src="{{ asset($image->image_path) }}" style="width: 40px; height: 40px; object-fit: cover;" class="rounded border">
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary edit-product-btn" data-id="{{ $item->id }}">Edit</a>
                        <form method="POST" action="{{ route('product.delete', $item->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger Deletepopup">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
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
                        <label for="editProductImage" class="form-label">Main Product Image</label>
                        <input type="file" id="editProductImage" name="img" class="form-control">
                        <img id="currentProductImage" src="" alt="Current Image" style="max-width: 50%; margin-top: 10px;">
                    </div>
                    <h5>Product Additional Images</h5>
                    <div id="imagesContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

            <!-- Separate Upload Form -->
            <form id="uploadImagesForm" enctype="multipart/form-data" class="p-3">
                @csrf
                <input type="file" name="images[]" multiple class="form-control mb-2">
                <button type="submit" class="btn btn-primary">Upload Images</button>
            </form>
        </div>
    </div>
</div>


@endsection
