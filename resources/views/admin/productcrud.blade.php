<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- SweetAlert (optional) -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<title>sweet</title>
</head>
<body>
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
	<table class="table">
	  <thead class="thead-dark">
	    <tr>
	      <th scope="col">Id</th>
	      <th scope="col">Image</th>
	      <th scope="col">Name</th>
	      <th scope="col">Discription</th>
	      <th scope="col">Price</th>
	      <th scope="col">Active</th>
	      <th scope="col">Action</th>
	    </tr>
	  </thead>
	  <tbody>
	  	@php $i = 1 @endphp
	  	@foreach($products as $item)
	    <tr>
	      <th scope="row">{{$i}}</th>
	      <td><img src="{{ asset('products/' . $item->img) }}" style="width:150px"></td>
	      <td>{{$item->name}}</td>
	      <td>{{$item->description}}</td>
	      <td>{{$item->price}}</td>
	      <td>{{ $item->is_active ? 'Yes' : 'No' }}</td>
	      <td>
	      	<a class="btn btn-primary" href="{{ route('minus.update.cart',$item->id) }}" role="button">Edit</a>
	        <form method="POST" action="{{ route('item.delete', $item->id) }}" class="d-inline delete-form">
	            @csrf
	            @method('DELETE')
	            <button type="button" class="btn btn-danger Deletepopup">Delete</button>
	        </form>
	      </td>
	    </tr>
	    @php $i++ @endphp
	  	@endforeach
</body>
</html>

<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('.Deletepopup').on('click', function(event) {
        event.preventDefault();
        const form = jQuery(this).closest('form'); // Get the closest form

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this item!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                form.submit(); // Submit the form
            }
        });
    });
});
</script>