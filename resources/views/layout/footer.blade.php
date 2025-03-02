@php 
    $cartItems = Session::get('cart', []);
@endphp

<div id="cart-slide" class="cart-slide hide">
    <div class="cart-content">
        <span class="cart-item-name">
            {{ count($cartItems) > 0 ? $cartItems[0]['name'] : 'Cart is Empty' }}
        </span>
        <span class="total-items">Total Items: {{ count($cartItems) }}</span>
        <div class="cart-buttons">
            <a href="{{ route('view.cart') }}"><button class="view-cart">View Cart</button></a>
            <button class="close-cart">✖</button>
        </div>
    </div>
</div>
<!-- Footer -->
<footer class="site-footer"> 
    <div class="footer-container">
        <div class="contact-info">
            <h3><img src="{{ asset('images/address-icon.png') }}" alt="Address Icon"> Our Office</h3>
            <p>Prajapati Sweet mart, opp Alfha school, vishvakarma chock,<br> ratanpar, Surendranagar, Gujrat 363020</p>

            <h3><img src="{{ asset('images/email-icon.png') }}" alt="Email Icon"> General Enquiries</h3>
            <p>mukeshrlakhatariya@gmail.com</p>

            <h3><img src="{{ asset('images/phone-icon.png') }}" alt="Phone Icon"> Call Us</h3>
            <p>+91 9327407160</p>

            <h3><img src="{{ asset('images/clock-icon.png') }}" alt="Clock Icon"> Our Timing</h3>
            <p>Mon - Sun: 10:00 AM - 07:00 PM</p>
        </div>

        <div class="contact-form">
            <h3>Contact Us</h3>
            <form action="{{ route('contact-us.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="contact_number" placeholder="Your Contact No." required>
                <textarea placeholder="Your Message" name= "message" rows="3" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.988713159137!2d71.63148121532972!3d22.71156518511427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959416d934d5d81%3A0x292cd3bb01fa05c9!2sPrajapati%20Sweet%20%26%20Fastfood!5e0!3m2!1sen!2sin!4v1677867413820!5m2!1sen!2sin" allowfullscreen loading="lazy"></iframe>
    </div>
</footer>
<!-- End Footer -->
<!-- <footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-3 footer-column">
                <h3>About Us</h3>
                <p>We are dedicated to providing high-quality products and excellent customer service. Your satisfaction is our priority.</p>
            </div>
            <div class="col-md-3 footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-column">
                <h3>Follow Us</h3>
                <ul class="social-links">
                    <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                </ul>
            </div>
            <div class="col-md-3 footer-column">
                <h3>Find Us</h3>
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.988713159137!2d71.63148121532972!3d22.71156518511427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959416d934d5d81%3A0x292cd3bb01fa05c9!2sPrajapati%20Sweet%20%26%20Fastfood!5e0!3m2!1sen!2sin!4v1677867413820!5m2!1sen!2sin"
                        width="100%"
                        height="200"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <p>&copy; 2025 Your Company. All Rights Reserved.</p>
        </div>
    </div>
</footer> -->


<script>
    let cartItems = @json(array_map(fn($item) => $item['name'], $cartItems));
</script>
<script src="https://cdn.rawgit.com/michalsnik/aos/2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>