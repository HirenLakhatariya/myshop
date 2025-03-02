<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Shop Slider</title>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <style>
        .swiper {
            width: 100%;
            height: auto;
            padding: 15px 0;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease-in-out;
        }

        .swiper-slide:hover {
            transform: scale(1.05);
        }

        .product-card {
            width: 100%;
            max-width: 160px; /* Smaller cards for mobile */
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            padding: 10px;
            background: #fff;
        }

        .product-card img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 6px;
        }

        .product-card h5 {
            font-size: 14px;
            margin-top: 5px;
        }

        .product-card h6 {
            font-size: 12px;
            color: #555;
        }

        .product-card p {
            font-size: 11px;
            color: #777;
        }

        .product-card .btn {
            font-size: 12px;
            padding: 5px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    @foreach(['Items' => $items, 'Sweets' => $sweet, 'Namkins' => $farsan] as $title => $allItems)
        <h2 class="text-center mb-4">{{ $title }}</h2>

        <div class="text-end mb-2">
            <a href="/{{ strtolower($title) }}" class="btn btn-primary">View All {{ $title }}</a>
        </div>

        <div class="swiper mySwiper-{{ strtolower($title) }}">
            <div class="swiper-wrapper">
                @foreach($allItems as $allitem)
                    <div class="swiper-slide">
                        <div class="product-card">
                            <img src="{{ asset('products/' . $allitem->img) }}" alt="{{ $allitem->name }}">
                            <h5 class="text-truncate">{{ $allitem->name }}</h5>
                            <h6 class="text-muted">₹{{ $allitem->price }} / KG</h6>
                            <p class="text-truncate">{{ $allitem->description }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <form method="POST" action="{{ route('add.to.cart') }}" class="flex-grow-1">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $allitem->id }}">
                                    <input type="hidden" name="name" value="{{ $allitem->name }}">
                                    <input type="hidden" name="price" value="{{ $allitem->price }}">
                                    <button type="submit" class="btn btn-danger w-100">Add to Cart</button>
                                </form>
                                <button class="btn btn-info ms-1" data-bs-toggle="modal" data-bs-target="#productModal"
                                    data-name="{{ $allitem->name }}" data-description="{{ $allitem->description }}" data-price="₹{{ $allitem->price }}">
                                    Info
                                </button>
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

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        @foreach(['items', 'sweets', 'namkins'] as $category)
        new Swiper(".mySwiper-{{ $category }}", {
            slidesPerView: 2,
            spaceBetween: 5,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                400: { slidesPerView: 3, spaceBetween: 5 },
                540: { slidesPerView: 4, spaceBetween: 10 },
                768: { slidesPerView: 5, spaceBetween: 15 },
                1024: { slidesPerView: 6, spaceBetween: 20 },
            }
        });
        @endforeach
    });
</script>

</body>
</html>
