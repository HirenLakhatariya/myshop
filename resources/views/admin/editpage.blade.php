<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit {{ $data->name }}</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container my-5">
		@if(session('msg'))
			<div class="alert alert-primary" role="alert">
			  {{ session('msg') }}
			</div>
		@endif
		<div class="pb-3">
			<a class="btn btn-primary" href="{{ url()->previous() }}" role="button">Back</a>
		</div>
	    <div class="card shadow">
	        <div class="card-header bg-primary text-white">
	            <h2 class="card-title">Edit Item: {{ $data->name }}</h2>
	        </div>
	        <div class="card-body">
	            <form action="{{ route('items.update', $data->id) }}" method="POST" enctype="multipart/form-data" >
	                @csrf
	                @method('PUT')
	                
	                <div class="mb-3">
	                    <label for="name" class="form-label">Name</label>
	                    <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" required>
	                </div>

	                <div class="mb-3">
	                    <label for="description" class="form-label">Description</label>
	                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ $data->description }}</textarea>
	                </div>

	                <div class="mb-3">
	                    <label for="price" class="form-label">Price</label>
	                    <input type="number" class="form-control" id="price" name="price" value="{{ $data->price }}" required>
	                </div>
	                <div class="mb-3">
	                    <label for="image" class="form-label">Upload Image</label>
	                    <input type="file" class="form-control" id="image" name="img">
	                    @if($data->img)
	                        <img src="{{ asset('products/' . $data->img) }}" alt="Current Image" class="img-thumbnail mt-2" style="width: 150px; height: auto;">
	                    @endif
	                </div>
	                <div class="mb-3">
	                    <label for="status" class="form-label">Status</label>
	                    <select class="form-select" id="status" name="is_active" required style="width: 200px;">
	                        <option value="1" {{ $data->is_active === '1' ? 'selected' : '' }}>Active</option>
	                        <option value="0" {{ $data->is_active === '0' ? 'selected' : '' }}>Inactive</option>
	                    </select>
	                </div>
	                <div class="d-flex justify-content-between">
	                    <button type="submit" class="btn btn-primary">Update</button>
	                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
	                </div>
	            </form>
	        </div>
	    </div>
	</div>
	
	<!-- Bootstrap JS Bundle -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
