<form id="productForm" action="{{ route('products.save') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div id="productFields">
        @php
            $products = auth()->user()->products ?? collect();
        @endphp

        @if ($products->isNotEmpty())
            @foreach ($products as $index => $product)
                <div class="row product-row align-items-center">
                    <!-- Product Name -->
                    <div class="col-md-4">
                        <label>Product Name</label>
                        <input type="text" name="product_name[]" class="form-control"
                            value="{{ old('product_name.' . $index, $product->product_name) }}" required>
                    </div>
                    <!-- Product Image -->
                    <div class="col-md-4">
                        <label>Product Image</label>
                        <input type="file" name="product_image[]" class="form-control">

                    </div>

                    <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">
                        @if ($product->product_image)
                            <img src="{{ asset('storage/app/public/' . $product->product_image) }}"
                                alt="{{ $product->product_name }}" class="img-thumbnail mt-2 zoom-image" width="100">
                        @endif


                    </div>
                    <!-- Delete Button -->
                    <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">
                        <button type="button" class="btn btn-danger removeProductBtn"
                            style="border: none; background: none; padding: 2px;">
                            <i class="fa fa-trash-alt"
                                style="font-size: 19px; color: rgb(248, 49, 49);
                               vertical-align: middle;"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Default Empty Row -->
            <div class="row product-row align-items-center">
                <div class="col-md-4">
                    <label>Product Name</label>
                    <input type="text" name="product_name[]" class="form-control" placeholder="Product Name"
                        required>
                </div>
                <div class="col-md-4">
                    <label>Product Image</label>
                    <input type="file" name="product_image[]" class="form-control">
                </div>

            </div>
        @endif
    </div>

    <!-- Add More Button -->
    <button type="button" id="addProductBtn" class="btn btn-secondary mt-3">
        <i class="fa fa-plus"></i> Add More
    </button>

    <button type="submit" class="btn btn-primary mt-3" id="nextTab">Save and Next</button>

</form>

<!-- JavaScript for Adding & Removing Products & Tab Navigation -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const maxProducts = 3;
        const productContainer = document.getElementById("productFields");
        const addProductBtn = document.getElementById("addProductBtn");

       

        addProductBtn.addEventListener("click", function() {
            const totalProducts = document.querySelectorAll(".product-row").length;


                const newProductRow = document.createElement("div");
                newProductRow.classList.add("row", "product-row", "align-items-center");
                newProductRow.innerHTML = `
                <div class="col-md-4">
                    <label>Product Name</label>
                    <input type="text" name="product_name[]" class="form-control" placeholder="Product Name" required>
                </div>
                <div class="col-md-4">
                    <label>Product Image</label>
                    <input type="file" name="product_image[]" class="form-control">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">
                    <button type="button" class="btn btn-danger removeProductBtn"
                            style="border: none; background: none; padding: 2px;">
                        <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);
                           vertical-align: middle;"></i>
                    </button>
                </div>
            `;
                productContainer.appendChild(newProductRow);
                updateButtonState();

        });

        productContainer.addEventListener("click", function(event) {
            if (event.target.closest(".removeProductBtn")) {
                event.target.closest(".product-row").remove();
                updateButtonState();
            }
        });

        updateButtonState();

        // Save and Navigate to Services Tab
        document.getElementById("saveAndNextProduct").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission

            let form = document.getElementById("productForm");
            let formData = new FormData(form);
console.log("mu");
            fetch("{{ route('products.save') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector("#services-tab").click(); // Move to the Services tab
                    } else {
                        alert("Error saving product. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let nextTab = "{{ session('nextTab') }}";

        if (nextTab) {
            let nextTabElement = document.querySelector(`a[href="${nextTab}"]`) || document.querySelector(
                `a[data-toggle="tab"][href="${nextTab}"]`);

            if (nextTabElement) {
                let bootstrapTab = new bootstrap.Tab(nextTabElement);
                bootstrapTab.show();
            }
        }
    });
</script>
