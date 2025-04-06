@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Manage Product Images - {{ $product->name }}</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Image Upload Form -->
    <form action="{{ route('admin.products.images.upload', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <hr>

    <!-- Display Product Images -->
    <h4>Existing Images</h4>
    <div class="row">
        @foreach($product->images as $image)
            <div class="col-md-3 text-center">
                <img src="{{ asset($image->image_path) }}" class="img-thumbnail" width="150">
                <form action="{{ route('admin.products.images.delete', $image->id) }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
