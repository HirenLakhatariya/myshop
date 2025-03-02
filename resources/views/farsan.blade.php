@extends('layout.app')

@section('main-section')
<div class="container mt-4">
  <div class="row">
      @forelse($farsan as $farsan)
          <div class="col-md-1 col-sm-4 col-lg-2 mb-3"> <!-- Adjust column size -->
              <div class="card h-80">
                  <img class="card-img-top" src="{{ asset('uploads/' . $farsan->img) }}" alt="{{ $farsan->name }}" style="height: 200px; object-fit: cover;">
                  <div class="card-body d-flex flex-column">
                      <h5 class="card-title text-truncate">{{ $farsan->name }}</h5>
                      <h6 class="card-subtitle mb-2 text-muted">{{ $farsan->price }} / KG</h6>
                      <p class="card-text text-truncate">{{ $farsan->description }}</p>
                      <a href="#" class="btn btn-primary mt-auto">View Details</a>
                  </div>
              </div>
          </div>
      @empty
          <div class="col-12">
              <p class="text-center text-muted">No sweets available at the moment.</p>
          </div>
      @endforelse
 </div>
</div>
@endsection
