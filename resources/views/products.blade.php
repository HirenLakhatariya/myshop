@extends('layout.app')

@section('main-section')
@if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<!-- Search Box -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <input type="text" id="searchInput" class="form-control mb-4" placeholder="Search Products...">
        </div>
    </div>
</div>

<!-- Product Cards Section -->
<div class="container mt-3">
    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3" id="productList">
        @forelse($product as $product)
            <div class="col product-card" data-name="{{ strtolower($product->name) }} {{ strtolower($product->description) }}">
                <div class="card h-100">
                    <img class="card-img-top" src="{{ asset($product->img) }}" alt="{{ $product->name }}" style="height: 160px; object-fit: cover;">
                    <div class="card-body d-flex flex-column p-2">
                        <h6 class="card-title text-truncate" style="font-size: 13px; margin-bottom: 5px;">{{ $product->name }}</h6>
                        <h6 class="card-subtitle text-muted" style="font-size: 12px;">₹{{ $product->price }} / KG</h6>
                        <p class="card-text text-truncate" style="font-size: 11px; margin-bottom: 5px;">{{ $product->description}}</p>

                        <form id="addToCartForm-{{ $product->id }}" class="flex-grow-1">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">

                            <select name="quantity" id="quantity-{{ $product->id }}" class="form-select form-select-sm mb-2">
                                <option value="200">200g</option>
                                <option value="500">500g</option>
                                <option value="1000" selected>1 Kg</option>
                                <option value="5000">5 Kg</option>
                            </select>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-danger btn-sm w-100 addToCartBtn" data-id="{{ $product->id }}"></button>
                                <a href="/iteminfo/{{$product->id}}"><button type="button" class="btn btn-info ms-1">Info</button></a>
                            </div>
                        </form>
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

<!-- JavaScript for Search Filter -->
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        let filter = this.value.toLowerCase();
        let productCards = document.querySelectorAll(".product-card");

        productCards.forEach(card => {
            let productName = card.getAttribute("data-name");
            card.style.display = productName.includes(filter) ? "block" : "none";
        });
    });
</script>

@endsection
