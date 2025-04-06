document.addEventListener("DOMContentLoaded", function () {
    AOS.init(); // Initialize AOS

    // Back to Top Button Functionality
    // const backToTopButton = document.getElementById("backToTop");

    // window.addEventListener("scroll", () => {
    //     if (window.scrollY > 200) {
    //         backToTopButton.style.opacity = "1";
    //         backToTopButton.style.visibility = "visible";
    //     } else {
    //         backToTopButton.style.opacity = "0";
    //         backToTopButton.style.visibility = "hidden";
    //     }
    // });
    
    // backToTopButton.onclick = () => {
    //     window.scrollTo({ top: 0, behavior: "smooth" });
    // };

    // Back to Top Button
    // Buttons
        const backToTopButton = document.getElementById("backToTop");
        const whatsappButton = document.getElementById("whatsappButton");

        // Reveal WhatsApp button on page load
        window.addEventListener("load", () => {
            whatsappButton.style.opacity = "1";
            whatsappButton.style.transform = "translateY(0)";
        });

        // Show Back to Top button on scroll
        window.addEventListener("scroll", () => {
            if (window.scrollY > 200) {
                backToTopButton.style.opacity = "1";
                backToTopButton.style.visibility = "visible";
                backToTopButton.style.transform = "translateY(0)";
            } else {
                backToTopButton.style.opacity = "0";
                backToTopButton.style.visibility = "hidden";
                backToTopButton.style.transform = "translateY(50px)";
            }
        });

        // Smooth scroll to top
        backToTopButton.onclick = () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
        };


    // Remove the @foreach section and replace with pure JavaScript
    const swiperConfigs = {
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
    };

    // Initialize all swipers
    document.querySelectorAll(".swiper").forEach(el => {
        const swiper = new Swiper(el, swiperConfigs);
        
        el.addEventListener("mouseenter", () => swiper.autoplay.stop());
        el.addEventListener("mouseleave", () => swiper.autoplay.start());
    });
    
    var toastElement = document.getElementById('successToast');
    if (toastElement) {
        var toast = new bootstrap.Toast(toastElement, { delay: 5000 }); // Show for 5 seconds
        toast.show();
    }
    let searchInput = document.getElementById("searchInput");
    if (searchInput) {        
        document.getElementById('searchInput').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let productCards = document.querySelectorAll('.swiper-slide');
    
            productCards.forEach(function(card) {
                let productName = card.querySelector('h5').innerText.toLowerCase();
                let productDescription = card.querySelector('p').innerText.toLowerCase();
    
                if (productName.includes(filter) || productDescription.includes(filter)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }

    // Your existing elements
    let cartSlide = document.getElementById("cart-slide");
    let closeCart = document.querySelector(".close-cart");
    let firstItemName = document.querySelector(".cart-item-name");

    // Cart items from Laravel Blade
    window.updateCart = function(totle = 0) {
        if (cartItems.length > 0 || totle > 0) {
            firstItemName.textContent = "First Item: " + cartItems[0]; // Show first item name
            cartSlide.classList.remove("hide");
        } else {
            firstItemName.textContent = "Cart is Empty";
            cartSlide.classList.add("hide");
        }
    }

    // Hide cart when close button is clicked
    closeCart.addEventListener("click", function () {
        cartSlide.classList.add("hide");
    });

    // Prevent the close button from triggering the drag event
    closeCart.addEventListener("mousedown", function (e) {
        e.stopPropagation();
    });

    updateCart();

    // Draggable functionality
    let isDragging = false;
    let offsetX, offsetY;

    // Set initial cursor
    cartSlide.style.cursor = "grab";

    cartSlide.addEventListener("mousedown", (e) => {
        isDragging = true;
        // Calculate offset between mouse position and the top-left of the element
        offsetX = e.clientX - cartSlide.getBoundingClientRect().left;
        offsetY = e.clientY - cartSlide.getBoundingClientRect().top;
        cartSlide.style.cursor = "grabbing";
    });

    document.addEventListener("mousemove", (e) => {
        if (!isDragging) return;
        let x = e.clientX - offsetX;
        let y = e.clientY - offsetY;
        // Update the element's position
        cartSlide.style.left = `${x}px`;
        cartSlide.style.top = `${y}px`;
        // Remove fixed positioning from bottom/right to allow free movement
        cartSlide.style.bottom = "auto";
        cartSlide.style.right = "auto";
    });

    document.addEventListener("mouseup", () => {
        isDragging = false;
        cartSlide.style.cursor = "grab";
    });

    window.showSuccessToast = function(message) {
        // Remove existing toast if present
        $('#dynamic-toast').remove();
    
        // Create toast element
        let toastHtml = `
            <div id="dynamic-toast" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>`;
    
        // Append and show the toast
        $('body').append(toastHtml);
        
        // Automatically hide the toast after 3 seconds
        setTimeout(() => {
            $('#dynamic-toast').fadeOut(500, function() {
                $(this).remove();
            });
        }, 3000);
    }

    $(".addToCartBtn").click(function() {
        var productId = $(this).data("id"); // Get product ID from button
        var form = $("#addToCartForm-" + productId); // Select the correct form
        var token = $('meta[name="csrf-token"]').attr("content"); // Get CSRF token
    
        // Get form data
        var data = {
            id: form.find('input[name="id"]').val(),
            name: form.find('input[name="name"]').val(),
            price: form.find('input[name="price"]').val(),
            quantity: form.find('select[name="quantity"]').val(),
        };
        // Send AJAX request
        $.ajax({
            url: "/cart/add",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": token
            },
            data: JSON.stringify(data),
            contentType: "application/json",
            processData: false,
            success: function(response) {
                $('.total-items').html(`Total Items: ${response.cart_count}`);
                $('.cart-count').text(response.cart_count);
                if (response.first_item_name) {
                    $('.cart-item-name').text(response.first_item_name);
                } else {
                    $('.cart-item-name').text('Cart is Empty');
                }
                showSuccessToast(response.message);
                updateCart(totle = response.cart_count);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert("Error adding to cart!");
            }
        });
    });

    const logo = document.getElementById('logo');
    if (logo) {
        logo.addEventListener('animationend', function () {
            this.classList.add('fixed');  // Keep logo fixed after animation
        });
    }
    // window.addEventListener('resize', () => {
    //     const button = document.querySelector('.addToCartBtn');
    //     if (window.innerWidth <= 768) {
    //         button.textContent = "Add";
    //     } else {
    //         button.textContent = "Add to Cart";
    //     }
    // });
    
    // // Trigger on page load
    // window.dispatchEvent(new Event('resize'));
    
});
