document.addEventListener('DOMContentLoaded', () => {
    // Ensure Chart.js and Canvas elements are available
    if (document.getElementById('orderGraph')) {
        const orderCtx = document.getElementById('orderGraph').getContext('2d');
        new Chart(orderCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Orders',
                    data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120],
                    borderColor: 'rgba(255, 255, 255, 0.8)',
                    backgroundColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#fff' }
                    },
                    y: {
                        ticks: { color: '#fff' }
                    }
                }
            }
        });
    }

    if (document.getElementById('salesGraph')) {
        const salesCtx = document.getElementById('salesGraph').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [{
                    label: 'Sales Growth',
                    data: [500, 1000, 1500, 2000],
                    backgroundColor: 'rgba(255, 255, 255, 0.7)',
                    borderColor: 'rgba(255, 255, 255, 0.8)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#fff' }
                    },
                    y: {
                        ticks: { color: '#fff' }
                    }
                }
            }
        });
    }
});

// Edit Product Modal Script
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-product-btn');
    const editForm = document.getElementById('editProductForm');
    const mainFocusElement = document.querySelector('.btn-primary');
    const modal = document.getElementById('editProductModal');

    modal.addEventListener('hidden.bs.modal', function () {
        if (mainFocusElement) {
            mainFocusElement.focus(); // Move focus to a safe element
        }
    });
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');

            // Fetch product data via AJAX
            fetch(`/admin/products/${productId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate modal fields
                    document.getElementById('editProductId').value = data.id;
                    document.getElementById('editProductName').value = data.name;
                    document.getElementById('editProductDescription').value = data.description;
                    document.getElementById('editProductPrice').value = data.price;
                    document.getElementById('editProductStock').value = data.stock;
                    document.getElementById('currentProductImage').src = `/products/${data.img}`;

                    // Set form action
                    editForm.action = `/admin/products/${productId}`;

                    // Show modal (Bootstrap)
                    $(modal).modal('show');
                });
        });
    });
});
