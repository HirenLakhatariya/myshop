@extends('layout.admin')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Add New Product</h2>
        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Products
        </a>
    </div>

    <div class="card shadow rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label">Price (₹)</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                    </div>

                    <div class="col-md-6">
                        <label for="img" class="form-label">Main Image</label>
                        <input type="file" name="img" id="img" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="images" class="form-label">Additional Images</label>
                        <input type="file" name="images[]" id="images" class="form-control" multiple>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control" required></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="productType" class="form-label">Product Type</label>
                        <select id="productType" name="type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="S">Sweet</option>
                            <option value="F">Namkeens</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="is_active" class="form-label">Status</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-1"></i> Save Product
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn btn-outline-danger">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
