@extends('layout.app')

@section('main-section')
<div class="container">
    <div class="product-section">
        <!-- Product Images -->
        <div class="product-images">
            <div class="main-image" id="mainImage">
                <img id="currentImage" src="{{ asset($items->img) }}" alt="Zoomable Image">
                <div class="zoom-lens" id="zoomLens"></div>
            </div>
            <div class="zoom-result" id="zoomResult">
                <img id="zoomedImage" src="{{ asset($items->img) }}" alt="Zoomed Image">
            </div>
            <div class="thumbnail-row">
                @if($itemsImg->images)
                    @foreach($itemsImg->images as $images)
                        <img src="{{ asset($images->image_path) }}" alt="Thumbnail" onclick="changeImage(this)">
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <h1>{{$items->name}}</h1>
            <h5>{{$items->price}}/kg</h5>
            <p>
                {{$items->description}}
            </p>
            <form id="addToCartForm-{{ $items->id }}" class="flex-grow-1">
                <input type="hidden" name="id" value="{{ $items->id }}">
                <input type="hidden" name="name" value="{{ $items->name }}">
                <input type="hidden" name="price" value="{{ $items->price }}">

                <select name="quantity" id="quantity-{{ $items->id }}" class="form-select form-select-sm mb-2 w-50">
                    <option value="200">200g</option>
                    <option value="500">500g</option>
                    <option value="1000" selected>1 Kg</option>
                    <option value="5000">5 Kg</option>
                </select>

                    <button type="button" class="btn btn-danger btn-sm w-50 addToCartBtn" data-id="{{ $items->id }}"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="category-products-section mt-5">
    <h3 class="text-center mb-4">✨ Other Products in the Same Category ✨</h3>
    <div class="text-end">
        <a href="{{ $items->type == 'F' ? '/namkeens' : '/sweets' }}" class="btn btn-primary">
            More
        </a>
    </div>
    <div class="row justify-content-center" style="margin: 0;">  <!-- Remove row margin -->
        @foreach($products as $product)
            <div class="col-6 col-md-4 col-lg-2 px-1">  <!-- Compact padding -->
                <div class="card-info h-100 shadow-sm product-card hover-effect">
                    <div class="card-img-container">
                        <img class="card-img-top" src="{{ asset($product->img) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="card-body-info d-flex flex-column">
                        <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 30) }}</p>

                        <!-- Buttons in one line -->
                        <div class="d-flex justify-content-between align-items-center mt-2">  
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
                            <!-- <button type="button" class="btn btn-danger btn-sm w-50 addToCartBtn" data-id="{{ $product->id }}"></button> -->
                            <!-- <a href="/iteminfo/{{$product->id}}" class="btn btn-info btn-sm w-50 ms-2">ℹ️ Info</a> -->
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

    <script>
    // Image switching functionality
    function changeImage(thumbnail) {
        const currentImage = document.getElementById("currentImage");
        const zoomedImage = document.getElementById("zoomedImage");
        const thumbnailRow = document.querySelector(".thumbnail-row");
        // currentImage.src = thumbnail.src;
        // zoomedImage.src = thumbnail.src;

            // ✅ Create a new thumbnail from the current main image
        const newThumbnail = document.createElement("img");
        newThumbnail.src = currentImage.src;  // Set the current main image as a new thumbnail
        newThumbnail.alt = "Thumbnail";
        newThumbnail.onclick = function () {
            changeImage(this);
        };

        // ✅ Add the current main image to the thumbnail row
        thumbnailRow.appendChild(newThumbnail);

        // ✅ Set the clicked image as the new main image
        currentImage.src = thumbnail.src;
        zoomedImage.src = thumbnail.src;

        // ✅ Remove the clicked image from thumbnails
        thumbnail.remove();
    }

    const mainImageContainer = document.getElementById("mainImage");
    const mainImage = document.getElementById("currentImage");
    const zoomLens = document.getElementById("zoomLens");
    const zoomResult = document.getElementById("zoomResult");
    const zoomImage = document.getElementById("zoomedImage");

    // Show zoom lens and zoom result when hovering over image
    mainImageContainer.addEventListener("mouseenter", () => {
        zoomLens.style.display = "block";
        zoomResult.style.display = "block";
    });

    // Hide zoom lens when mouse leaves
    mainImageContainer.addEventListener("mouseleave", () => {
        zoomLens.style.display = "none";
        zoomResult.style.display = "none";
    });

    mainImageContainer.addEventListener("mousemove", (e) => {
        const rect = mainImageContainer.getBoundingClientRect();
        const lensSize = 100; // Lens size (adjustable)
        
        // Get mouse position inside the image
        let x = e.clientX - rect.left;
        let y = e.clientY - rect.top;

        // Keep lens inside image boundaries
        let lensLeft = Math.max(0, Math.min(x - lensSize / 2, rect.width - lensSize));
        let lensTop = Math.max(0, Math.min(y - lensSize / 2, rect.height - lensSize));

        zoomLens.style.left = `${lensLeft}px`;
        zoomLens.style.top = `${lensTop}px`;

        // Get scale ratio for zoom
        const scaleX = zoomImage.width / mainImage.width;
        const scaleY = zoomImage.height / mainImage.height;

        // Move zoomed image accordingly
        zoomImage.style.transform = `translate(${-lensLeft * scaleX}px, ${-lensTop * scaleY}px)`;
    });

    const orderForm = document.getElementById("orderForm");

    if (orderForm) {  // Check if form exists
        orderForm.addEventListener("submit", function (e) {
            e.preventDefault();
            alert("Your order has been placed! We will contact you shortly.");
        });
    }
    </script>
@endsection