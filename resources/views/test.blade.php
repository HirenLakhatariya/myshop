<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="{{ url('css/styles.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ url('css/about.css') }}"> -->
    <link rel="stylesheet" href="{{ url('css/iteminfo.css') }}">
    <link rel="stylesheet" href="https://cdn.rawgit.com/michalsnik/aos/2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <script src="{{ asset('js/about.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Prajapati's</title>
    <!-- <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
        }
        footer {
            background: #fff;
            padding: 20px;
            box-shadow: 0px -2px 10px rgba(0,0,0,0.1);
        }
        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
        }
        .contact-info {
            flex: 1;
            min-width: 250px;
            text-align: left;
        }
        .contact-info h3 {
            margin-top: 10px;
        }
        .contact-info p img {
            margin-right: 8px;
            width: 16px;
            height: 16px;
            vertical-align: left;
        }
        .contact-form {
            flex: 1;
            min-width: 250px;
            text-align: center;
            background: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
        }
        .contact-form h3 {
            color: #333;
        }
        .contact-form form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 400px;
            margin: 0 auto;
        }
        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .contact-form button {
            padding: 12px;
            background: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        .contact-form button:hover {
            background: #3578c8;
        }
        .map-container {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
        iframe {
            width: 100%;
            height: 300px;
            border: 0;
        }
        .get-directions {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background: #4a90e2;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                text-align: right;
            }
            .map-container {
                margin-top: 20px;
            }
        }
    </style> -->
    <!-- <style> -->
        <!-- body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        
        h1, h2 {
            color: #C0392B;
        }

        .navbar {
            background-color: #2C3E50;
        }

        .navbar-brand, .navbar-nav .nav-link {
            color:rgb(255, 255, 255);
        }

        .footer {
            background-color: #34495E;
            color: white;
            padding: 40px 20px;
        }

        .footer-column {
            margin-bottom: 20px;
        }

        .footer-links a, .social-links a {
            color: #ECF0F1;
            text-decoration: none;
        }

        .footer-links a:hover, .social-links a:hover {
            text-decoration: underline;
        }

        .carousel-image {
            height: 400px; /* Set a fixed height for the images */
            object-fit: cover; /* Ensures images cover the area without distortion */
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background for better readability */
            border-radius: 5px; /* Rounded corners for the caption */
        }

        .about-section {
            background-color: #f9f9f9;
            padding: 50px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 30px 0;
        }
        
        .about-content {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 30px;
        }       
        .about-image img {
            width: 100%;
            max-width: 250px;
            height: auto;
            border: 4px solid #ddd;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .about-description {
            max-width: 600px;
            color: #333;
        }

        .about-description h3 {
            font-size: 24px;
            color: #C0392B;
            margin-bottom: 15px;
        }

        .about-description p {
            line-height: 1.6;
            font-size: 18px;
            margin-bottom: 15px;
            text-align: justify;
        }

        @media (max-width: 768px) {
            .about-content {
                flex-direction: column;
                align-items: center;
            }

            .about-image {
                margin-bottom: 20px;
            }

            h1, h2 {
                font-size: 1.5rem; /* Responsive font size for headings */
            }

            .footer {
                padding: 20px 10px; /* Less padding on mobile */
            }

            .carousel-image {
                height: 300px; /* Adjust height for smaller screens */
            }

            #productCarousel {
                max-width: 100%; /* Allow full width on smaller screens */
            }
            .carousel-inner{
                height: 300px;
            }
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Back to Top Button */
        #backToTop {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
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

        .btn {
            font-size: 12px; /* Adjust button font size */
            padding: 5px 10px; /* Adjust button padding */
        } -->
    <!-- </style> -->
    <style>
    /* Footer Styling */
    .site-footer {
        color: #ddd;
        padding: 15px;
        font-size: 14px; 
    }
    .site-footer .footer-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 15px;
        gap: 20px;
    }
    .site-footer .contact-info {
        flex: 1;
        min-width: 200px;
        text-align: left;
    }
    .site-footer .contact-info h3 {
        margin-top: 20px;
        font-size: 16px;
        color: black;
        font-weight: bold;
    }
    .site-footer .contact-info p {
        color: black;
        font-size: 14px;
        margin: 5px 0;
        margin-left: 37px;
    }
    .site-footer .contact-info h3 img {
        margin-right: 6px;
        width: 25px;
        height: 25px;
        vertical-align: middle;
    }
    .site-footer .contact-form {
        flex: 1;
        min-width: 200px;
        text-align: center;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 2px 4px white;
    }
    .site-footer .contact-form h3 {
        color: black;
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 10px;
    }
    .site-footer .contact-form form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 350px;
        margin: 0 auto;
    }
    .site-footer .contact-form input, 
    .site-footer .contact-form textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #555;
        border-radius: 4px;
        font-size: 14px;
        /* background: white; */
        /* color: white; */
    }
    .site-footer .contact-form input::placeholder, 
    .site-footer .contact-form textarea::placeholder {
        color: black;
    }
    .site-footer .contact-form button {
        padding: 10px;
        background: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s ease;
    }
    .site-footer .contact-form button:hover {
        background: #388E3C;
    }
    .site-footer .map-container {
        width: 100%;
        text-align: center;
        margin-top: 15px;
    }
    .site-footer iframe {
        width: 100%;
        height: 250px;
        border: 0;
        border-radius: 5px;
    }
    .site-footer .get-directions {
        display: inline-block;
        margin-top: 8px;
        padding: 8px 12px;
        background: #4CAF50;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
        border-radius: 4px;
    }
    .site-footer .get-directions:hover {
        background: #388E3C;
    }
    
    /* Mobile Optimization */
    @media (max-width: 768px) {
        .site-footer {
            font-size: 13px;
            padding: 10px;
        }
        .site-footer .footer-container {
            flex-direction: column;
            text-align: left;
            gap: 10px;
        }
        .site-footer .contact-form {
            padding: 10px;
        }
        .site-footer .contact-form input, 
        .site-footer .contact-form textarea {
            padding: 6px;
            font-size: 12px;
        }
        .site-footer .contact-form button {
            padding: 8px;
            font-size: 12px;
        }
        .site-footer .map-container {
            margin-top: 10px;
        }
        .site-footer iframe {
            height: 200px;
        }
    }
</style>
</head>
<body>
<!-- Back to Top Button -->
<!-- <h3><i class="fas fa-map-marker-alt"></i> Our Office Address</h3>
<h3><i class="fas fa-envelope"></i> General Enquiries</h3>
<h3><i class="fas fa-phone"></i> Call Us</h3>
<h3><i class="fas fa-clock"></i> Our Timing</h3> -->



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
            <form action="/contectus" method="POST">
                @csrf
                <input type="text" placeholder="Your Name" required>
                <input type="email" placeholder="Your Email" required>
                <input type="text" placeholder="Your Contact No." required>
                <textarea placeholder="Your Message" rows="3" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <div class="map-container">
        <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=72.8163%2C19.1730%2C72.8563%2C19.1930&layer=mapnik" allowfullscreen loading="lazy"></iframe>
        <a href="https://www.google.com/maps" target="_blank" class="get-directions">Get Directions</a>
    </div>
</footer>



<!-- 
<footer>
    <div class="footer-container">
        <div class="contact-info">
            <h3 style="color: #333; margin-top: 40px;"><img src="{{ asset('images/address-icon.png') }}" alt="Address Icon" style="width: 25px; height:25px"> Our Office Address</h3>
            <p style="color: #333;">Palm Court Bldg M, 501/8, 5th Floor, New Link Road,<br>Malad West, Mumbai, Maharashtra 400064</p>

            <h3 style="color: #333; margin-top: 40px;" class="mt-10"><img src="{{ asset('images/email-icon.png') }}" alt="Email Icon" style="width: 25px; height:25px"> General Enquiries</h3>
            <p style="color: #333;">websupport@justdial.com</p>

            <h3 style="color: #333; margin-top: 40px;"><img src="{{ asset('images/phone-icon.png') }}" alt="Phone Icon" style="width: 25px; height:25px"> Call Us</h3>
            <p style="color: #333;">+91 8888888888</p>

            <h3 style="color: #333; margin-top: 40px;"><img src="{{ asset('images/clock-icon.png') }}" alt="Clock Icon" style="width: 25px; height:25px"> Our Timing</h3>
            <p style="color: #333;">Mon - Sun: 10:00 AM - 07:00 PM</p>
        </div>
        <div class="contact-form">
            <h3>Contact Us</h3>
            <form>
                <input type="text" placeholder="Your Name" required>
                <input type="email" placeholder="Your Email" required>
                <input type="text" placeholder="Your Contact No." required>
                <textarea placeholder="Your Message" rows="4" required></textarea>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div class="map-container">
        <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=72.8163%2C19.1730%2C72.8563%2C19.1930&layer=mapnik" allowfullscreen="" loading="lazy"></iframe>
        <a href="https://www.google.com/maps" target="_blank" class="get-directions">Get Directions</a>
    </div>
</footer> -->
</body>
</html>