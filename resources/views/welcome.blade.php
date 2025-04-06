@extends('layout.app')


@section('main-section')
<main>
<!-- <div class="container my-3">
    <input type="text" id="searchInput" class="form-control w-50" placeholder="Search for products...">
</div> -->
<h1 id="products" class="text-center my-4">Products</h1>
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

<!-- Sweets Section -->
<div id="productCarousel" class="carousel slide mx-auto" style="max-width: 1200px;" data-bs-ride="carousel" data-bs-interval="5000" aria-label="Product Carousel">
    <div class="carousel-inner">
        @foreach($sweet as $index => $allitem)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset($allitem->img) }}" class="d-block w-100 carousel-image" alt="{{ $allitem->name }}" loading="lazy">
                <div class="carousel-caption d-md-block">
                    <h5 class="text-white">{{ $allitem->name }}</h5>
                    <p class="text-white">{{ Str::limit($allitem->description, 50) }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" aria-label="Previous">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next" aria-label="Next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
    
    <!-- Carousel Indicators -->
    <div class="carousel-indicators">
        @foreach($sweet as $index => $allitem)
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>
</div>

<div class="container my-5">
    @foreach(['Product' => $items, 'Sweets' => $sweet, 'Namkeens' => $farsan] as $title => $allItems)
    
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h2 class="text-start">{{ $title }}</h2>
        <a href="/{{ strtolower($title) }}" class="btn btn-primary">View All {{ $title }}</a>
    </div>
        <div class="swiper mySwiper-{{ strtolower($title) }}">
            <div class="swiper-wrapper">
                @foreach($allItems as $allitem)
                    <div class="swiper-slide">
                        <div class="product-card">
                            <img src="{{ asset($allitem->img) }}" alt="{{ $allitem->name }}">
                            <h5 class="text-truncate">{{ $allitem->name }}</h5>
                            <h6 class="text-muted">₹{{ $allitem->price }} / KG</h6>
                            <p class="text-truncate hide-on-mobile">{{ $allitem->description }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <form id="addToCartForm-{{ $allitem->id }}" class="flex-grow-1">
                                    <input type="hidden" name="id" value="{{ $allitem->id }}">
                                    <input type="hidden" name="name" value="{{ $allitem->name }}">
                                    <input type="hidden" name="price" value="{{ $allitem->price }}">
                                    <!-- Quantity Selector -->
                                    <div class="m-2">
                                        <select name="quantity" id="quantity-{{ $allitem->id }}" class="form-select">
                                            <option value="200">200g</option>
                                            <option value="500">500g</option>
                                            <option value="1000" selected>1 Kg</option>
                                            <option value="5000">5 Kg</option>
                                        </select>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-danger w-100 addToCartBtn" data-id="{{ $allitem->id }}"></button>
                                        <a href="/iteminfo/{{$allitem->id}}"><button type="button" class="btn btn-info ms-1">Info</button></a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    @endforeach
</div>

<!-- About Us Section -->
<div class="about-section" id="about">
    <div class="container">
        <h2 class="text-center mb-4">About Us</h2>
        <div class="about-content">
            <div class="about-image">
                <img src="{{ asset('uploads/admin.jpeg') }}" alt="About Person" class="img-fluid rounded-circle shadow" style="width: 250px; height: 250px;" loading="lazy"> <!-- Ensuring circular shape -->
            </div>
            <div class="about-description">
                <h3>Meet Our Founder</h3>
                <p>Welcome to Prajapati Sweet! Our journey began with a passion for creating delightful sweets that bring joy to every celebration. Our founder, [Founder's Name], has dedicated their life to perfecting the art of sweet-making. With years of experience and a commitment to quality, they have crafted a range of products that reflect the love and care we put into every item.</p>
                <p>At Prajapati Sweet, we believe in using only the finest ingredients, ensuring that each bite is a moment of happiness. Our mission is to provide our customers with exceptional products and unforgettable experiences. Join us on this sweet journey!</p>
                <a href="/about" class="btn btn-danger mt-3">Learn More</a>
            </div>
        </div>
    </div>
</div>
</main>

<!-- Modal for Product Info -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Product details will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<!-- <button
        type="button"
        class="btn btn-danger btn-floating btn-lg"
        id="btn-back-to-top"
        >
  <i class="fas fa-arrow-up"></i>
</button> -->

@endsection