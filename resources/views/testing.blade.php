@extends('layout.app')
<style>
    /* 🌟 Base Styles */
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #fdfdfd;
    color: #333;
}

/* 🌅 Hero Section */
.hero-section {
    background: url('https://source.unsplash.com/1600x900/?sweets') center/cover no-repeat;
    color: white;
    text-align: center;
    padding: 100px 20px;
}

.hero-content h1 {
    font-size: 3rem;
    margin-bottom: 10px;
}

.hero-content p {
    font-size: 1.2rem;
}

.btn-hero {
    background: #e63946;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s;
}

.btn-hero:hover {
    background: #d62828;
}

/* 🎡 Carousel */
.carousel-image {
    height: 400px;
    object-fit: cover;
    border-radius: 10px;
}

.carousel-caption {
    background: rgba(0, 0, 0, 0.7);
    padding: 15px;
    border-radius: 8px;
}

/* 🛒 Product Grid */
.container {
    padding: 40px 20px;
    text-align: center;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.product-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 15px;
    transition: transform 0.3s;
}

.product-card:hover {
    transform: translateY(-10px);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.card-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
}

.btn-primary,
.btn-secondary {
    padding: 8px 15px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: background 0.3s;
}

.btn-primary {
    background: #6a994e;
    color: white;
}

.btn-primary:hover {
    background: #386641;
}

.btn-secondary {
    background: #f4a261;
    color: white;
}

.btn-secondary:hover {
    background: #e76f51;
}

/* 👥 About Section */
.about-section {
    background: #f0efeb;
    padding: 40px;
    display: flex;
    align-items: center;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.about-img {
    width: 250px;
    height: 250px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e76f51;
}

/* 📞 Footer */
.footer {
    background: #222;
    color: white;
    text-align: center;
    padding: 20px;
}

.footer-content {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    padding: 20px 0;
}

.footer-content h3 {
    margin-bottom: 10px;
    color: #f4a261;
}

.footer-content ul {
    list-style: none;
    padding: 0;
}

.footer-content a {
    color: white;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-content a:hover {
    color: #e76f51;
}

.social-icons a {
    margin: 0 10px;
    font-size: 1.5rem;
    transition: transform 0.3s;
}

.social-icons a:hover {
    transform: scale(1.2);
}

/* 📱 Responsive Styles */
@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }

    .about-section {
        flex-direction: column;
        text-align: center;
    }

    .product-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
}

</style>
@section('main-section')
<!-- 🌟 Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1>Prajapati Sweets & Namkeen</h1>
        <p>Authentic Indian Flavors Crafted with Love</p>
        <a href="#products" class="btn-hero">Explore Our Delights</a>
    </div>
</section>

<!-- 🍬 Product Carousel -->
<div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach($sweet as $index => $allitem)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ asset('products/' . $allitem->img) }}" class="d-block w-100 carousel-image" alt="{{ $allitem->name }}">
                <div class="carousel-caption">
                    <h5>{{ $allitem->name }}</h5>
                    <p>{{ Str::limit($allitem->description, 50) }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- 🛍️ Featured Products (Limited Display) -->
<div class="container" id="products">
    <h2>Featured Products</h2>
    <div class="product-grid">
        @foreach($items->take(8) as $allitem) {{-- Displaying only 8 items --}}
            <div class="product-card">
                <img src="{{ asset('products/' . $allitem->img) }}" alt="{{ $allitem->name }}">
                <h3>{{ $allitem->name }}</h3>
                <p>₹{{ $allitem->price }} / KG</p>
                <div class="card-actions">
                    <form method="POST" action="{{ route('add.to.cart') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $allitem->id }}">
                        <button type="submit" class="btn-primary">Add to Cart</button>
                    </form>
                    <a href="/iteminfo/{{ $allitem->id }}" class="btn-secondary">Info</a>
                </div>
            </div>
        @endforeach
    </div>
    <a href="/all-products" class="btn-view-more">View More Products</a>
</div>

<!-- ℹ️ About Us Section -->
<section class="about-section">
    <div class="about-content">
        <img src="{{ asset('uploads/admin.jpeg') }}" alt="About Us" class="about-img">
        <div>
            <h2>About Us</h2>
            <p>We bring traditional Indian sweets and namkeen with authentic flavors to your plate. Made with love and rich heritage.</p>
        </div>
    </div>
</section>

<!-- 📞 Footer -->
<footer class="footer">
    <div class="footer-content">
        <div>
            <h3>About Us</h3>
            <p>Serving sweetness and spice with love for generations.</p>
        </div>
        <div>
            <h3>Quick Links</h3>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <div>
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </div>
    <p>&copy; 2025 Prajapati Sweets. All Rights Reserved.</p>
</footer>

@endsection
