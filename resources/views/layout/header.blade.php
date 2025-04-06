<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('css/styles.css') }}">
    <link rel="stylesheet" href="{{ url('css/about.css') }}">
    <link rel="stylesheet" href="{{ url('css/footer.css') }}">
    <link rel="stylesheet" href="{{ url('css/iteminfo.css') }}">
    <link rel="stylesheet" href="https://cdn.rawgit.com/michalsnik/aos/2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/about.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <title>Prajapati's</title>

</head>
<body>

<header>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Prajapati Sweet</a>
            <!-- <div class="logo-container">
                <img src="{{ asset('uploads/logo2.webp') }}" alt="Logo" id="logo">
            </div> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/product">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/sweets">Sweets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/namkeens">Namkeen's</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cart" style="display: flex; align-items: center; position: relative;">
                        <img src="{{ asset('images/shopping-cart.png') }}" alt="Cart" style="width: 30px; height: 30px;">
                        <span class="cart-count" style="position: absolute; top: -5px; right: -5px; background-color: red; color: white; border-radius: 50%; padding: 3px 7px; font-size: 10px;">
                        {{ count(Session::get('cart', [])) }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</header>