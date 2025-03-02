@extends('layout.app')

@section('main-section')
<div class="container">
    <h1>Cart</h1>
        @if (count($cart) > 0)        
        <div class="card shadow p-4">
            <ul class="list-group mb-4">
                @foreach ($cart as $item)
                    <li class="list-group-item border border-primary d-flex justify-content-between align-items-center m-2">
                        <div>
                            <h5 class="mb-1">{{ $item['name'] }}</h5>
                            <p class="mb-0 text-muted">₹{{ $item['price'] }} per KG x {{ $item['quantity'] / 1000 }} KG</p>
                            </div>
                            <div class="btn-group" role="group">
                                <form action="{{ route('update.cart', 'delete') }}" method="post" class="d-inline m-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <button type="submit" class="btn btn-outline-danger"><img src="{{ asset('images/delete-icon.png') }}" alt="Cart" style="width: 20px; height: 20px;"></button>
                                </form>
                                <form action="{{ route('update.cart', 'minus') }}" method="post" class="d-inline m-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <button type="submit" class="btn btn-outline-danger">-</button>
                                </form>
                                <form action="{{ route('update.cart', 'plus') }}" method="post" class="d-inline m-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <button type="submit" class="btn btn-outline-success">+</button>
                                </form>
                            </div>
                    </li>
                @endforeach
            </ul>

            <div class="text-end">
                <h4 class="mb-3">Total Price: ₹
                    {{ array_reduce($cart, fn($sum, $item) => $sum + ($item['price'] * ($item['quantity'] / 1000)), 0) }}
                </h4>
                <!-- Main Button -->
                <a class="btn btn-success btn-lg" id="sendToWhatsAppBtn" href="#" style="background-color: #25d366;">
                    <i class="bi bi-whatsapp"></i> Send Order via WhatsApp
                </a>
            </div>
        </div>

        <!-- Popup Modal -->
        <div id="numberPopup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; background: white; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <h3>Enter Phone Number</h3>
            <input type="text" id="phoneNumber" placeholder="Enter WhatsApp Number" style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
            <button id="sendNumberBtn" style="background-color: #25d366; color: white; padding: 8px 16px; border: none; border-radius: 4px;">Send</button>
            <button id="closePopupBtn" style="background-color: #ccc; color: black; padding: 8px 16px; border: none; border-radius: 4px; margin-left: 10px;">Cancel</button>
        </div>

        <!-- Overlay -->
        <div id="popupOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

    @else
        <div class="alert alert-warning text-center">
            Your cart is empty. Start adding items to your cart.
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const sendToWhatsAppBtn = document.getElementById('sendToWhatsAppBtn');
    const numberPopup = document.getElementById('numberPopup');
    const popupOverlay = document.getElementById('popupOverlay');
    const sendNumberBtn = document.getElementById('sendNumberBtn');
    const closePopupBtn = document.getElementById('closePopupBtn');
    const phoneNumberInput = document.getElementById('phoneNumber');

    // Show popup
    sendToWhatsAppBtn.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default navigation
        numberPopup.style.display = 'block';
        popupOverlay.style.display = 'block';
    });

    // Close popup
    closePopupBtn.addEventListener('click', function () {
        numberPopup.style.display = 'none';
        popupOverlay.style.display = 'none';
    });

    // Validate and send number
    sendNumberBtn.addEventListener('click', function () {
        const phoneNumber = phoneNumberInput.value.trim();

        // Simple number validation (adjust as needed)
        const phoneRegex = /^[0-9]{10}$/;
        if (!phoneRegex.test(phoneNumber)) {
            alert('Please enter a valid 10-digit phone number.');
            return;
        }

        // Send the phone number to the server
        fetch("{{ route('set.phone.number') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ phone: phoneNumber })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Redirect to the provided URL
                window.location.href = data.redirect_url;
            } else {
                alert(data.message || 'Failed to set phone number.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
});
</script>
@endsection
