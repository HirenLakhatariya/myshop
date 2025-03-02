@extends('layout.app')

@section('main-section')
<div class="container">
        <div class="product-section">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image" id="mainImage">
                    <img id="currentImage" src="https://picsum.photos/500/400" alt="Zoomable Image">
                    <div class="zoom-lens" id="zoomLens"></div>
                </div>
                <div class="zoom-result" id="zoomResult">
                    <img id="zoomedImage" src="https://picsum.photos/500/400" alt="Zoomed Image">
                </div>
                <div class="thumbnail-row">
                    <img src="https://picsum.photos/500/400" alt="Thumbnail 1" onclick="changeImage(this)">
                    <img src="https://picsum.photos/500/401" alt="Thumbnail 2" onclick="changeImage(this)">
                    <img src="https://picsum.photos/500/402" alt="Thumbnail 3" onclick="changeImage(this)">
                    <img src="https://picsum.photos/500/403" alt="Thumbnail 4" onclick="changeImage(this)">
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <h1>Delicious Sweet</h1>
                <p>
                    Our signature sweet is made with premium ingredients to deliver the best taste and quality. Perfect for celebrations, festivals, and daily treats.
                </p>
                <p>
                    Each piece is crafted with care to ensure a rich flavor and delightful texture, making it a favorite among all age groups.
                </p>
            </div>
        </div>

        <!-- Order Form -->
        <div class="order-form">
            <h2>Order Now</h2>
            <form id="orderForm">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Your Email" required>
                <label for="date">Pickup Date</label>
                <input type="date" id="date" name="date" required>
                <label for="time">Pickup Time</label>
                <input type="time" id="time" name="time" required>
                <label for="message">Additional Message</label>
                <textarea id="message" name="message" rows="4" placeholder="Any specific instructions?"></textarea>
                <button type="submit">Submit Order</button>
            </form>
        </div>
    </div>

    <script>
       // Image switching functionality
        function changeImage(thumbnail) {
            const mainImage = document.getElementById("mainImage");
            const zoomedImage = document.getElementById("zoomedImage");
            mainImage.src = thumbnail.src;
            zoomedImage.src = thumbnail.src;
        }

        // Zoom functionality
        const mainImage = document.getElementById("mainImage");
        const zoomLens = document.getElementById("zoomLens");
        const zoomResult = document.getElementById("zoomResult");
        const zoomImage = zoomResult.querySelector("img");

        mainImage.addEventListener("mouseenter", () => {
            zoomLens.style.display = "block";
            zoomResult.style.display = "block";
        });

        mainImage.addEventListener("mouseleave", () => {
            zoomLens.style.display = "none";
            zoomResult.style.display = "none";
        });

        mainImage.addEventListener("mousemove", (e) => {
            const rect = mainImage.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const lensX = x - zoomLens.offsetWidth / 2;
            const lensY = y - zoomLens.offsetHeight / 2;

            const lensLeft = Math.max(0, Math.min(lensX, rect.width - zoomLens.offsetWidth));
            const lensTop = Math.max(0, Math.min(lensY, rect.height - zoomLens.offsetHeight));

            zoomLens.style.left = lensLeft + "px";
            zoomLens.style.top = lensTop + "px";

            const zoomX = -lensLeft * (zoomImage.width / rect.width);
            const zoomY = -lensTop * (zoomImage.height / rect.height);

            zoomImage.style.left = zoomX + "px";
            zoomImage.style.top = zoomY + "px";
        });

        // Order form submission
        document.getElementById("orderForm").addEventListener("submit", function (e) {
            e.preventDefault();
            alert("Your order has been placed! We will contact you shortly.");
        });

    </script>
@endsection