document.addEventListener("DOMContentLoaded", function () {
    AOS.init(); // Initialize AOS

    // Modal Handling
    const productModal = document.getElementById("productModal");
    if (productModal) {
        productModal.addEventListener("show.bs.modal", (event) => {
            const button = event.relatedTarget; // Button that triggered the modal
            const name = button.getAttribute("data-name");
            const description = button.getAttribute("data-description");
            const price = button.getAttribute("data-price");
            const quantity = button.getAttribute("data-quantity");

            const modalBody = productModal.querySelector("#modalBody");
            modalBody.innerHTML = `<div><h5>${name}</h5><p>${description}</p><p>${price}</p><p>${quantity}</p></div>`;
        });
    }

    // Back to Top Button Functionality
    const backToTopButton = document.getElementById("backToTop");
    if (backToTopButton) {
        window.onscroll = function () {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                backToTopButton.style.display = "block";
            } else {
                backToTopButton.style.display = "none";
            }
        };

        backToTopButton.onclick = function () {
            window.scrollTo({ top: 0, behavior: "smooth" });
        };
    }

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

        // Your existing elements
        let cartSlide = document.getElementById("cart-slide");
        let closeCart = document.querySelector(".close-cart");
        let firstItemName = document.querySelector(".cart-item-name");
    
        // Cart items from Laravel Blade
        function updateCart() {
            if (cartItems.length > 0) {
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
});
