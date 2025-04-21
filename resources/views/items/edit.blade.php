@extends('admin_layouts.app')
<style>
    .wholesale-container {
        border: 1px solid lightgray !important;
        /* Border for input fields */
        border-radius: 8px;
        /* Rounded corners */
        padding: 15px;
        /* Spacing inside */
        margin-top: 10px;
        /* Space above */

    }

    /* Button background color */
    .btn-danger.removeSpecification {
        background-color: #A87676;
        /* Set the background color */
        border-color: #A87676;
        /* Set the border color */
    }

    /* Button hover effect */
    .btn-danger.removeSpecification:hover {
        background-color: #6c757d !important;
        /* Gray color on hover */
        border-color: #6c757d !important;
        /* Gray border on hover */
    }
</style>
<style>
    .remove:hover {
        background-color: gray !important;
    }

    .cancel:hover {
        background-color: gray !important;
    }

    #remove:hover {
        background-color: gray !important;
    }

    /* Ensure all image and video containers have the same dimensions */
.image-container img,
.video-container video {
    width: 100%; /* Ensure all images and videos are initially 100% width */
    height: auto;
    transition: transform 0.3s ease; /* Smooth transition */
}

/* Apply hover effect for images */
.image-container img:hover,
.video-container video:hover {
    transform: scale(2.5); /* Increase size on hover */
    z-index: 10; /* Ensure the scaled element stays on top */
    cursor: pointer; /* Add pointer cursor to indicate interactivity */
}

/* Optional: To ensure consistent display and spacing */
.image-container,
.video-container {
    display: inline-block;
    overflow: hidden;
    width: 100px; /* Adjust width to match your design */
    height: 100px; /* Set height so images/videos stay within bounds */
    border: 2px solid #ccc;
    margin: 10px;
}



</style>
@section('content')
<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <h4><b>Edit Product </b><a href="{{ url()->previous() }}" class="btn btn-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a></h4>

            <div class="card-body">
                <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                    <h6 class="mt-4" style="font-weight:800; color:black;">Category</h6>

                    <div class="row">
                        <!-- Category -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="category_id">Main Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->Category_id }}" {{ $item->categoryid == $category->Category_id ? 'selected' : '' }}>
                                        {{ $category->Category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Subcategory -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subcategory_id">Subcategory</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control">
                                    <option value="">Select Subcategory</option> <!-- Default option added -->
                                    @foreach($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ $item->subcategoryid == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Child Category -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="childcategory_id">Child Category</label>
                                <select name="childcategory_id" id="childcategory_id" class="form-control">
                                    <option value="">Select Child Category</option> <!-- Default option added -->
                                    @foreach($childCategories as $childCategory)
                                    <option value="{{ $childCategory->id }}" {{ $item->childcategoryid == $childCategory->id ? 'selected' : '' }}>
                                        {{ $childCategory->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                            </div>
                        </div>

                        <!-- Brand / Group -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="brand">Brand / Group</label>
                                <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $item->brand) }}">
                            </div>
                        </div>

                        <!-- U.O.M -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="uom">U.O.M</label>
                                <select name="uom" id="uom" class="form-control">
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->abbreviation }}" {{ $item->uom == $unit->abbreviation ? 'selected' : '' }}>
                                        {{ $unit->unit }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <!-- Sales Price -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sales_price">Sales Price</label>
                                <input type="text" name="sales_price" id="sales_price" class="form-control"
                                    value="{{ old('sales_price', number_format($item->sales_price, 0, '.', '')) }}"
                                    required
                                    oninput="roundSalesPrice(this); calculateMargin();"
                                    placeholder="Enter Sales Price">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tax">GST (%)</label>
                                <input type="number" name="tax" id="tax" class="form-control" value="{{ old('tax', $item->tax) }}">
                            </div>
                        </div>

                        <!-- Expiration Date -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="expiration_date">Expiry Date</label>
                                <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ old('expiration_date', $item->expiration_date) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group" style=" margin-top:15px;">
                                    <label for="description">Description* <span style="font-size:11px;">(*Note: Exceeding more than 1000 characters is not allowed.)</span></label>
                                    <textarea id="description" name="description" class="form-control" rows="5" style="width:1350px;"
                                        placeholder="Enter product description" required maxlength="1000"
                                        oninput="document.getElementById('charCount').textContent = this.value.length + ' / 1000 characters';">
                                    {{ old('description', $item->description) }}
                                    </textarea>

                                    <small id="charCount" class="text-muted">0 / 1000 characters</small>

                                    @if ($errors->has('description'))
                                    <div class="text-danger">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="mt-4" style="font-weight:800; color:black;">Specifications</h6>
                    <div class="row">
                        <div class="product custom-shadow">
                            <table class="table table-bordered" id="specificationsTable">
                                <thead>
                                    <tr>
                                        <th style="text-transform: none;">Specification Name</th>
                                        <th style="text-transform: none;">Specification Value</th>
                                        <th>
                                            <button type="button" class="btn btn-primary btn-sm" id="addSpecification">
                                                Add
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $specNames = json_decode($item->specification_name, true) ?? [];
                                    $specValues = json_decode($item->specification_value, true) ?? [];
                                    @endphp
                                    @if(count($specNames) > 0)
                                    @foreach($specNames as $index => $specName)
                                    <tr>
                                        <td>
                                            <input type="text" name="specification_name[]" class="form-control" value="{{ $specName }}" maxlength="70">
                                        </td>
                                        <td>
                                            <input type="text" name="specification_value[]" class="form-control" value="{{ $specValues[$index] ?? '' }}" maxlength="70">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm removeSpecification remove" id="remove">Remove</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>
                                            <input type="text" name="specification_name[]" class="form-control" placeholder="Specification Name">
                                        </td>
                                        <td>
                                            <input type="text" name="specification_value[]" class="form-control" placeholder="Specification Value">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm removeSpecification remove" id="remove">Remove</button>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>


                    </div>
                    <h6 class="mt-4" style="font-weight:800; color:black;">Product Image</h6>
                    <div class="row">
                        <!-- Product Image -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="product_image">Product Image</label>
                                <input type="file" name="product_image" id="product_image" accept="image/*" class="form-control">
                                @if($item->product_image)
                                <p><strong>Current Image:</strong></p>
                                <img src="{{ asset('storage/app/public/' . $item->product_image) }}" alt="Product Image" class="img-fluid" style="width: 120px; height:150px">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gallery Images <span style="font-size:11px;"> (Max: 5)</span></label>
                                <input type="file" name="gallery_images[]" multiple accept="image/*" style="border: 2px solid #ccc; padding: 5px; border-radius: 4px;">

                                @if(!empty($item->gallery_images))
                                @foreach(json_decode($item->gallery_images, true) as $image)
                                <div style="display:inline-block; margin:10px;">
                                    <img src="{{ asset('storage/app/public/' . $image) }}" width="40"
                                        onerror="this.onerror=null; this.src='{{ asset('images/no-image.png') }}';" style="width: 120px; height:150px">
                                </div>
                                @endforeach
                                @else
                                <p>No gallery images uploaded.</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
    <div class="form-group">
        <label>Gallery Video</label>
        <input type="file" name="gallery_video" accept="video/*" style="border: 2px solid #ccc; padding: 5px; border-radius: 4px;">

        @if($item->gallery_video)
        <video width="500" height="250" controls>
            <source src="{{ asset('storage/app/public/' . $item->gallery_video) }}" type="video/mp4">
        </video>
        @endif

    </div>
</div>

                   </div>
            </div>


            <br>
            <!-- Submit Button -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="{{ route('items.index') }}" class="btn btn-primary cancel">Cancel</a>
                </div>
            </div>
            </form>
        </div>

    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('addSpecification');
        const tableBody = document.querySelector('#specificationsTable tbody');

        addBtn.addEventListener('click', function() {
            const newRow = `
                <tr>
                    <td>
                        <input type="text" name="specification_name[]" class="form-control" placeholder="Specification Name" maxlength="70">
                    </td>
                    <td>
                        <input type="text" name="specification_value[]" class="form-control" placeholder="Specification Value" maxlength="70">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeSpecification" id="remove">Remove</button>
                    </td>
                </tr>`;
            tableBody.insertAdjacentHTML('beforeend', newRow);
        });

        tableBody.addEventListener('click', function(event) {
            if (event.target.classList.contains('removeSpecification')) {
                event.target.closest('tr').remove();
            }
        });
    });
</script>


<script>
    // Function to calculate sales price based on purchase price and margin
    function calculateSalesPrice() {
        const purchasePrice = parseFloat(document.getElementById('purchase_price').value);
        let margin = parseFloat(document.getElementById('fixing_of_margin').value);

        // Ensure margin is within the valid 0-100% range
        if (margin < 0) margin = 0; // Reset to 0 if less than 0
        if (margin > 100) margin = 100; // Reset to 100 if more than 100

        // If both purchase price and margin are provided, calculate sales price
        if (!isNaN(purchasePrice) && !isNaN(margin)) {
            // Calculate sales price (Purchase Price + (Purchase Price * Margin %))
            const salesPrice = purchasePrice + (purchasePrice * (margin / 100));
            document.getElementById('sales_price').value = salesPrice.toFixed(2); // Update Sales Price with calculated value
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

            // Ensure margin is within the valid 0-100% range
            if (margin < 0) margin = 0; // Reset to 0 if less than 0
            if (margin > 100) margin = 100; // Reset to 100 if more than 100

            document.getElementById('fixing_of_margin').value = margin.toFixed(2); // Update Fixing of Margin with calculated value
        }
    }
</script>



<script>
    function roundSalesPrice(input) {
        let value = parseFloat(input.value);
        if (!isNaN(value)) {
            input.value = Math.round(value);
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryDropdown = document.getElementById('category_id');
        const subcategoryDropdown = document.getElementById('subcategory_id');
        const childCategoryDropdown = document.getElementById('childcategory_id');

        // Load subcategories based on selected category
        categoryDropdown.addEventListener('change', function() {
            const categoryId = this.value;
            subcategoryDropdown.innerHTML = '<option value="">Loading...</option>'; // Show loading message
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
                            subcategoryDropdown.innerHTML = '<option value="">No Subcategory</option>'; // Display No Subcategory message
                        }
                    })
                    .catch(error => {
                        subcategoryDropdown.innerHTML = '<option value="">Error loading subcategories</option>';
                    });
            } else {
                subcategoryDropdown.innerHTML = '<option value="">Select Subcategory</option>';
            }
        });

        // Load child categories based on selected subcategory
        subcategoryDropdown.addEventListener('change', function() {
            const subcategoryId = this.value;
            childCategoryDropdown.innerHTML = '<option value="">Loading...</option>'; // Show loading message

            if (subcategoryId) {
                fetch(`/get-child-categories/${subcategoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            childCategoryDropdown.innerHTML = '<option value="">Select Child Category</option>';
                            data.forEach(childCategory => {
                                childCategoryDropdown.innerHTML += `<option value="${childCategory.id}">${childCategory.name}</option>`;
                            });
                        } else {
                            childCategoryDropdown.innerHTML = '<option value="">No Child Category</option>'; // Display No Child Category message
                        }
                    })
                    .catch(error => {
                        childCategoryDropdown.innerHTML = '<option value="">Error loading child categories</option>';
                    });
            } else {
                childCategoryDropdown.innerHTML = '<option value="">Select Child Category</option>';
            }
        });
    });
</script>



@endsection
