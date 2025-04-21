@extends('admin_layouts.app')

@section('content')
<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <div class="row">
                <div class="col-7"> <h4><b>Create Product</b> &nbsp;<a href="{{ url()->previous() }}" class="btn btn-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
   <i class="fas fa-arrow-left"></i>
</a></h4>   </div>
                <div class="col-5 mb-2">
                     <!-- Import Button & Form -->

                </div>
            </div>



                <div class="card">

                    <div class="card-body">

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Row 1: Name, Brand/Group, U.O.M -->
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Main Category*</label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="">Select Main Category</option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->Category_id }}">{{ $category->Category_name }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subcategory">Subcategory</label>
                                        <select name="subcategory_id" id="subcategory" class="form-control">
                                            <option value="">Select Subcategory</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="child_category">Child Category</label>
                                        <select name="child_category_id" id="child_category" class="form-control">
                                            <option value="">Select Child Category</option>
                                        </select>
                                    </div>
                                </div>




                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Product Name*</label>
                                        <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="form-control"
                                            required
                                            oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '').replace(/\b\w/g, (char) => char.toUpperCase());"
                                            pattern="[A-Za-z0-9 ]+"
                                            title="Product Name can only contain letters and spaces.">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="brand">Brand / Group</label>
                                        <input type="text" name="brand" id="brand" class="form-control"
                                            oninput="this.value = this.value.replace(/\b\w/g, (char) => char.toUpperCase());">

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="uom">U.O.M *</label>
                                        <select name="uom" id="uom" class="form-control" required>
                                            <!-- Placeholder Option -->
                                            <option value="" disabled selected>Select U.O.M</option>
                                            @foreach($units as $unit)
                                            <option value="{{ $unit->abbreviation }}">{{ $unit->unit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                            </div>

                            <!-- Row 2: Sales Price, Purchase Price, Tax -->
                            <div class="row">
                                <!-- Purchase Price -->




                                <!-- Sales Price -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sales_price">Sales Price*</label>
                                        <input type="number" name="sales_price" id="sales_price" class="form-control" required oninput="calculateMargin();" placeholder="Enter Sales Price">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tax">GST (%)</label>
                                        <input type="text" name="tax" id="tax" class="form-control" maxlength="2" pattern="\d{1,2}" title="Please enter a 2-digit number" />
                                    </div>
                                </div>




                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="expiration_date">Expiry Date</label>
                                        <input type="date" name="expiration_date" id="expiration_date" class="form-control">
                                    </div>
                                </div>
                            </div>


                            <!-- Checkbox to show additional inputs -->
                            <!-- <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="showAdditionalInputs" onclick="toggleAdditionalInputs()">
                                <label class="form-check-label" for="showAdditionalInputs">Add Price for Wholesale Quotation</label>
                            </div> -->

                            <!-- Additional Inputs Container (hidden by default) -->
                            <!-- <div id="additionalInputs" style="display:none;" class="mt-3">
                                <div class="row" id="additionalInputFields">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="purchase_prices">Purchase Price</label>
                                            <input type="number" name="purchase_prices[]" class="form-control" placeholder="Enter price">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" name="quantity[]" class="form-control" placeholder="Enter quantity">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sales_prices">Sales Price</label>
                                            <input type="number" name="sales_prices[]" class="form-control" placeholder="Enter sales price">
                                        </div>
                                    </div>
                                </div>


                                <button type="button" class="btn btn-primary" onclick="addMoreInputs()">Add More</button>
                            </div> -->




                            <!-- Row 3: Vendor, Expiration Date, Product Image -->
                            <div class="row">



                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter product description"></textarea>
                                    </div>
                                </div>


<br><br>
                                <!-- Row 2: Category, Subcategory, Child Category -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="product_image">
    Product Image * (Upload size: 800x800)
</label>


                                        <div class="input-wrapper" style="position: relative;">
                                            <input type="file" name="product_image" id="product_image" accept="image/*" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Gallery Images (New) -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="gallery_images">Gallery Images (Max 5, Upload Size: 800x800)</label>

                                        <div class="input-wrapper" style="position: relative;">
                                            <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Gallery Video (New) -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gallery_video">Gallery Video(Upload Size: 10mb)</label>
                                        <div class="input-wrapper" style="position: relative;">
                                            <input
                                                type="file"
                                                name="gallery_video"
                                                id="gallery_video"
                                                accept="video/*"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Specifications Section -->

                                <div id="specifications-container">
                                    <!-- <div class="row specification-row mb-2">
                                        <label for="Specification">Specification*</label>

                                        <div class="col-md-4">

                                            <input type="text" name="specifications[0][name]" class="form-control" placeholder="Specification Name" required>
                                        </div>

                                        <div class="col-md-4">

                                            <input type="text" name="specifications[0][value]" class="form-control" placeholder="Specification Value" required>
                                        </div>

                                    </div> -->

                                    <div class="row specification-row mb-2">
                                        <label for="Specification">Specification</label>

                                        <div class="col-md-4">

                                            <input type="text" name="specifications[0][name]" class="form-control" placeholder="Specification Name" maxlength="70">
                                        </div>

                                        <div class="col-md-4">

                                            <input type="text" name="specifications[0][value]" class="form-control" placeholder="Specification Value" maxlength="70">
                                        </div>
                                        <div class="col-md-4">
                                        <button type="button"
            class="btn btn-primary remove-specification"
            style="background-color: #A87676; width: 200px;"
            onmouseover="this.style.setProperty('background-color', '#8a8d93', 'important');"
            onmouseout="this.style.setProperty('background-color', '#A87676', 'important');">
        Remove
    </button>
                                        </div>
                                    </div>
                                </div>
                            <button
    type="button"
    id="add-specification"
    class="btn btn-secondary mt-2"
    style="background-color: #A87676; width: 210px; margin-left: 14px;"
    onmouseover="this.style.background = 'linear-gradient(270deg,rgb(100, 29, 231) 0%,rgb(146, 126, 184) 100%)';"
    onmouseout="this.style.background = '#A87676';">
    Add Specification
</button>


                            </div>





                            <!-- Submit and Cancel Buttons (Centered) -->
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary me-2">Save Product</button>
                              <a href="{{ route('items.index') }}"
   class="btn btn-primary"
   style="background-color: #A87676;"
   onmouseover="this.style.setProperty('background-color', '#8a8d93', 'important');"
   onmouseout="this.style.setProperty('background-color', '#A87676', 'important');">
    Cancel
</a>
                            </div>

                        </form>
                    </div>
                </div>



        </div>
    </div>
</div>

<!-- script section -->


<script>
    let specificationIndex = 1;

    document.getElementById('add-specification').addEventListener('click', () => {
        const container = document.getElementById('specifications-container');
        const newRow = document.createElement('div');
        newRow.className = 'row specification-row mb-2';
        newRow.innerHTML = `
            <div class="col-md-4">
                <input type="text" name="specifications[${specificationIndex}][name]" class="form-control" placeholder="Specification Name" maxlength="70" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="specifications[${specificationIndex}][value]" class="form-control" placeholder="Specification Value" maxlength="70" required>
            </div>
          <div class="col-md-4">
    <button type="button"
            class="btn btn-primary remove-specification"
            style="background-color: #A87676; width: 200px;"
            onmouseover="this.style.setProperty('background-color', '#8a8d93', 'important');"
            onmouseout="this.style.setProperty('background-color', '#A87676', 'important');">
        Remove
    </button>
</div>
        `;
        container.appendChild(newRow);
        specificationIndex++;

        // Attach event listener to remove button
        newRow.querySelector('.remove-specification').addEventListener('click', () => {
            newRow.remove();
        });
    });

    // Remove specification row
    document.addEventListener('click', (e) => {
        if (e.target && e.target.classList.contains('remove-specification')) {
            e.target.closest('.specification-row').remove();
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryDropdown = document.getElementById('category');
        const subcategoryDropdown = document.getElementById('subcategory');
        const childCategoryDropdown = document.getElementById('child_category');

        // Load subcategories based on selected category
        categoryDropdown.addEventListener('change', function() {
            const categoryId = this.value;
            subcategoryDropdown.innerHTML = '<option value="">Loading...</option>'; // Show loading
            childCategoryDropdown.innerHTML = '<option value="">Select Child Category</option>'; // Reset child category

            if (categoryId) {
                fetch(`/get-subcategories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            subcategoryDropdown.innerHTML = '<option value="">Select Subcategory</option>';
                            data.forEach(subcategory => {
                                subcategoryDropdown.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                            });
                        } else {
                            subcategoryDropdown.innerHTML = '<option value="">No Subcategory</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading subcategories:', error);
                        subcategoryDropdown.innerHTML = '<option value="">Error loading subcategories</option>';
                    });
            } else {
                subcategoryDropdown.innerHTML = '<option value="">Select Subcategory</option>';
            }
        });

        // Load child categories based on selected subcategory
        subcategoryDropdown.addEventListener('change', function() {
            const subcategoryId = this.value;
            console.log('Selected Subcategory ID:', subcategoryId); // Log selected subcategory ID

            if (subcategoryId) {
                fetch(`/getchildcategories/${subcategoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            childCategoryDropdown.innerHTML = '<option value="">Select Child Category</option>';
                            data.forEach(childCategory => {
                                childCategoryDropdown.innerHTML += `<option value="${childCategory.id}">${childCategory.name}</option>`;
                            });
                        } else {
                            childCategoryDropdown.innerHTML = '<option value="">No Child Category</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching child categories:', error);
                        childCategoryDropdown.innerHTML = '<option value="">Error loading child categories</option>';
                    });
            } else {
                childCategoryDropdown.innerHTML = '<option value="">Select Child Category</option>';
            }
        });
    });
</script>


<script>
    // Function to calculate sales price based on purchase price and margin
    function calculateSalesPrice() {
        const purchasePrice = parseFloat(document.getElementById('purchase_price').value);
        let margin = parseFloat(document.getElementById('fixing_of_margin').value);

        // Ensure margin is within 0-100% range
        if (margin < 0) margin = 0; // Reset to 0 if less than 0
        if (margin > 999) margin = 999; // Reset to 100 if more than 100

        // If both purchase price and margin are provided, calculate sales price
        if (!isNaN(purchasePrice) && !isNaN(margin)) {
            // Calculate sales price (Purchase Price + (Purchase Price * Margin %))
            const salesPrice = purchasePrice + (purchasePrice * (margin / 100));
            document.getElementById('sales_price').value = Math.round(salesPrice);; // Update Sales Price with calculated value
        }
    }

    // Function to calculate fixing of margin based on sales price and purchase price
    function calculateMargin() {
        const purchasePrice = parseFloat(document.getElementById('purchase_price').value);
        const salesPrice = parseFloat(document.getElementById('sales_price').value);

        // If both purchase price and sales price are provided, calculate margin
        if (!isNaN(purchasePrice) && !isNaN(salesPrice) && purchasePrice > 0) {
            // Calculate margin percentage: ((Sales Price - Purchase Price) / Purchase Price) * 100
            let margin = ((salesPrice - purchasePrice) / purchasePrice) * 100;

            // Ensure margin is within 0-100% range
            if (margin < 0) margin = 0; // Reset to 0 if less than 0
            if (margin > 999) margin = 999; // Reset to 100 if more than 100

            document.getElementById('fixing_of_margin').value = Math.round(margin);; // Update Fixing of Margin with calculated value
        }
    }
</script>


<script>
    // Function to toggle visibility of additional inputs container
    function toggleAdditionalInputs() {
        var container = document.getElementById('additionalInputs');
        var checkbox = document.getElementById('showAdditionalInputs');

        if (checkbox.checked) {
            container.style.display = 'block';
            addMoreInputs(); // Add the initial set of input fields when the checkbox is checked
        } else {
            container.style.display = 'none';
        }
    }

    // Function to add more input fields inside the container
    function addMoreInputs() {
        var container = document.getElementById('additionalInputFields');

        // Create new row with three input fields
        var newRow = document.createElement('div');
        newRow.classList.add('row');

        // Input 1: Purchase Price
        var input1Col = document.createElement('div');
        input1Col.classList.add('col-md-4');
        input1Col.innerHTML = `<div class="form-group">
                                <label for="purchase_prices">Purchase Price</label>
                                <input type="number" name="purchase_prices[]" class="form-control" placeholder="Enter price">
                               </div>`;

        // Input 2: Quantity
        var input2Col = document.createElement('div');
        input2Col.classList.add('col-md-4');
        input2Col.innerHTML = `<div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity[]" class="form-control" placeholder="Enter quantity">
                               </div>`;

        // Input 3: Sales Price
        var input3Col = document.createElement('div');
        input3Col.classList.add('col-md-4');
        input3Col.innerHTML = `<div class="form-group">
                                <label for="sales_prices">Sales Price</label>
                                <input type="number" name="sales_prices[]" class="form-control" placeholder="Enter sales price">
                               </div>`;

        // Create Remove button
        var removeButton = document.createElement('button');
        removeButton.classList.add('btn', 'btn-danger', 'mt-2');
        removeButton.innerText = 'Remove';
        removeButton.onclick = function() {
            container.removeChild(newRow);
        };

        // Add the Remove button to the row
        var removeCol = document.createElement('div');
        removeCol.classList.add('col-md-12');
        removeCol.appendChild(removeButton);
        newRow.appendChild(removeCol);

        // Append columns to the row
        newRow.appendChild(input1Col);
        newRow.appendChild(input2Col);
        newRow.appendChild(input3Col);

        // Append the row to the container
        container.appendChild(newRow);
    }
</script>




@endsection
