// Define loadProduct function first
function loadProduct(id) {
    fetch(`/admin/products/${id}`)
        .then(response => response.json())
        .then(product => {
            document.getElementById("editProductId").value = product.id;
            document.getElementById("editProductName").value = product.name;
            document.getElementById("editProductDescription").value = product.description;
            document.getElementById("editProductPrice").value = product.price;

            // Set main product image
            document.getElementById("currentProductImage").src = `/products/${product.img}`;

            let imagesContainer = document.getElementById("imagesContainer");
            imagesContainer.innerHTML = "";
            product.images.forEach(img => {
                imagesContainer.innerHTML +=`
                    <div class="image-box">
                        <img src="/${img.image_path}" class="additional-img">
                        <button class="btn btn-danger delete-image" data-id="${img.id}">✖</button>
                    </div>`;
            });
        })
        .catch(error => console.error("Error loading product:", error));
}


// Wait until the page is fully loaded
document.addEventListener("DOMContentLoaded", function () {
    let editForm = document.getElementById("editProductForm");
    let uploadForm = document.getElementById("uploadImagesForm");
    if (!editForm && !uploadForm) return; 
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("edit-product-btn")) {
            let productId = e.target.dataset.id;
            loadProduct(productId); // ✅ Now loadProduct is defined before being called

            // Open the modal using Bootstrap
            let editModal = new bootstrap.Modal(document.getElementById("editProductModal"));
            editModal.show();
        }
    });

    if (editForm) {
        editForm.addEventListener("submit", function (e) {
            e.preventDefault();
            let productId = document.getElementById("editProductId").value;
            let formData = new FormData(this);
            formData.append("_method", "PUT");

            fetch(`/admin/products/${productId}`, {
                method: "POST",
                body: formData,
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(response => response.json())
            .then(() => { alert("Product updated!"); location.reload(); });
        });
    } else {
        console.error("Edit product form not found.");
    }

    if (uploadForm) {
        uploadForm.addEventListener("submit", function (e) {
            e.preventDefault();
            let productId = document.getElementById("editProductId").value;
            let formData = new FormData(uploadForm);
            
            fetch(`/admin/products/${productId}/upload-images`, {
                method: "POST",
                body: formData,
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(response => response.json())
            .then(() => { alert("Images uploaded!"); location.reload(); });
        });
    } else {
        console.error("Upload images form not found.");
    }

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("delete-image")) {
            let imageId = e.target.dataset.id;
            alert(imageId);
            if (confirm("Are you sure you want to delete this image?")) {
                fetch(`/admin/products/delete-image/${imageId}`, {
                    method: "DELETE",
                    headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
                })
                .then(response => response.json())
                .then(() => {
                    alert("Image deleted!");
                    loadProduct(document.getElementById("editProductId").value);
                })
                .catch(error => console.error("Error deleting image:", error));
            }
        }
    });
});
