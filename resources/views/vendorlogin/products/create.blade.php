@extends('vendor_layouts.app')

@section('content1')
<style>
    /* Hide number input spinner buttons */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    .custom-btn {
        background-color: #A87676;
        /* Set background color to #A87676 */
        border-color: #A87676;
        /* Set border color to match */
    }

    .custom-btn:hover {
        background-color: blue;
        /* Change background to blue on hover */
        border-color: blue;
        /* Change border to blue on hover */
    }

    #close:hover {
        background-color: grey;

    }
</style>


<style>
    .btn {
        background-color: rgb(145, 81, 229);
        color: white !important;
    }


    .card-header {
        height: 40px;
    }

    h4 {
        margin-top:1px;
       margin-left:368px;
    }
    .header {
    background: linear-gradient(to right, #5a6c8e, #b180c7);
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    border-radius: 8px;
    margin-bottom: 15px;
}

.container{
   margin-left:-16px; 
   margin-bottom:50px;
}

.product{
    display: flex; 
    justify-content: center; 
    align-items: center;
}
.specification:hover{
    background-color: gray !important;
}
.w-50 {
    width: 11% !important;
    margin-left:820px;
}

.form-group{
    font-size:13px;
}

.form-control{
    font-size:13px;
}

@media (max-width: 767px) {
    .container{
   margin-left:-0px; 
   margin-bottom:100px;
}

.product{
    display: flex; 
    justify-content: center; 
    align-items: center;
    margin-top: 20px;
}

.form-group{
    font-size:13px;
}

.form-control{
    font-size:13px;
}

h4 {
        margin-top:1px;
       margin-left:65px;
    }

}

.card {
    margin-bottom: 20px; /* Adjust as needed */
}

@media (max-width: 768px) {
    .header h4 {
        font-size: 16px !important; /* Adjust as needed */
    }
}


</style>


<div class="container">
    <div class="card mt-3">



    <div class="card-header d-flex justify-content-between align-items-center header text-center">
    <h4 class="fs-5 fs-md-4">Create Product / Service</h4>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">
<div class="w-75">
    @if ($subscriptionLimitExceeded)
        <div class="p-2 text-center fw-bold text-danger fs-6 fs-md-5">
            <strong>Warning!</strong> You have reached your product creation limit.
        </div>
    @endif
</div>





    <div class="w-25 text-end">
        <a href="{{ route('customer.support.view') }}" class="btn btn-sm btn-primary" title="For any query, reach us">Enquiry</a>
    </div>
</div>



        
        <div class="card-body">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
    // Success Alert
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    @endif

    // Error Alert
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Try Again'
        });
    @endif

    // Warning Alert for product limit
    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Limit Reached!',
            text: '{{ session('warning') }}',
            confirmButtonColor: '#f39c12',
            confirmButtonText: 'OK'
        });
    @endif
</script>


            <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-md-12">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Category Selection</h5>
            <div class="row">
                <!-- Category Dropdown -->
                <div class="col-md-4 form-group">
                    <label for="categoryid" class="form-label">Main Category*</label>
                    <select id="categoryid" name="categoryid" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->Category_id }}" {{ old('categoryid') == $category->Category_id ? 'selected' : '' }}>
                            {{ $category->Category_name }}
                        </option>
                        @endforeach
                    </select>
                    @if ($errors->has('categoryid'))
                    <div class="text-danger">{{ $errors->first('categoryid') }}</div>
                    @endif
                </div>

                <!-- Subcategory Dropdown -->
                <div class="col-md-4 form-group">
                    <label for="subcategoryid" class="form-label">Sub Category*</label>
                    <select id="subcategory_id" name="subcategoryid" class="form-control" required>
                        <option value="">Select Subcategory</option>
                    </select>
                    @if ($errors->has('subcategoryid'))
                    <div class="text-danger">{{ $errors->first('subcategoryid') }}</div>
                    @endif
                </div>

                <!-- Child Category Dropdown -->
                <div class="col-md-4 form-group">
                    <label for="childcategoryid" class="form-label">Child Category*</label>
                    <select id="childcategoryid" name="childcategoryid" class="form-control" required>
                        <option value="">Select Child Category</option>
                    </select>
                    @if ($errors->has('childcategoryid'))
                    <div class="text-danger">{{ $errors->first('childcategoryid') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


                <!-- End of Row for Category and Subcategory -->

                <!-- Start of Row for Product Details -->
                <div class="col-md-12">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Product / Service Details</h5>
            
            <!-- Start of Row for Type, Product Name, Brand, and GST -->
            <div class="row">
                <!-- Type Dropdown -->
                <div class="col-md-3 form-group">
                    <label for="type">Type</label>
                    <select id="type" name="type" class="form-control" required>
                        <option value="" selected>Select type</option>
                        <option value="product">Product</option>
                        <option value="service">Service</option>
                    </select>
                </div>

                <!-- Product Name -->
                <div class="col-md-3 form-group">
                    <label for="product_name">Product / Service Name*</label>
                    <input type="text" id="product_name" name="product_name" class="form-control" 
                        value="{{ old('product_name') }}" required>
                    @if ($errors->has('product_name'))
                    <div class="text-danger">{{ $errors->first('product_name') }}</div>
                    @endif
                </div>

                <!-- Brand -->
                <div class="col-md-3 form-group">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" class="form-control" value="{{ old('brand') }}">
                    @if ($errors->has('brand'))
                    <div class="text-danger">{{ $errors->first('brand') }}</div>
                    @endif
                </div>

                <!-- GST Field -->
                <div class="col-md-3 form-group">
                    <label for="tax">GST (%)</label>
                    <input type="text" id="tax" name="tax" class="form-control form-control-sm"
                        value="{{ old('tax') }}" placeholder="GST %" pattern="\d{1,2}"
                        title="Please enter a 2-digit number">
                    @if ($errors->has('tax'))
                    <div class="text-danger">{{ $errors->first('tax') }}</div>
                    @endif
                </div>
            </div>
            <!-- End of Row for Type, Product Name, Brand, and GST -->

           

            <!-- Start of Row for Sales Price, Unit, and Expiry Date -->
            <div class="row">
                <!-- Sales Price -->
                <div class="col-md-3 form-group">
                    <label for="sales_price">Sales Price*</label>
                    <input type="number" id="sales_price" name="sales_price" class="form-control form-control-sm"
                        value="{{ old('sales_price') }}" required max="100000000"
                        oninput="limitSalesPrice(this)">
                    @if ($errors->has('sales_price'))
                    <div class="text-danger">{{ $errors->first('sales_price') }}</div>
                    @endif
                </div>

                <!-- Unit of Measurement -->
                <div class="col-md-3 form-group">
                    <label for="uom">Unit*</label>
                    <select id="uom" name="uom" class="form-control" required>
                        <option value="">Select Unit</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('uom') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->unit }}
                        </option>
                        @endforeach
                    </select>
                    @if ($errors->has('uom'))
                    <div class="text-danger">{{ $errors->first('uom') }}</div>
                    @endif
                </div>

                <!-- Expiry Date -->
                <div class="col-md-3 form-group">
                    <label for="expiration_date">Expiry Date</label>
                    <input type="date" id="expiration_date" name="expiration_date" class="form-control" value="{{ old('expiration_date') }}">
                    @if ($errors->has('expiration_date'))
                    <div class="text-danger">{{ $errors->first('expiration_date') }}</div>
                    @endif
                </div>
            </div>
            <!-- End of Row for Sales Price, Unit, and Expiry Date -->
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Product Description</h5>
            
            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="description">Product Description* 
                        <span style="font-size:11px;">(*Note: Exceeding more than 1000 characters is not allowed.)</span>
                    </label>
                    
                    <textarea id="description" name="description" class="form-control" rows="4" 
    placeholder="Enter product description" required maxlength="1000"
    oninput="updateCharCount()">
</textarea>

                    <small id="charCount" class="text-muted">0 / 1000 characters</small>

                    @if ($errors->has('description'))
                    <div class="text-danger">{{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

                <!-- End of Row for Tax and Pricing -->

                <div class="col-md-12">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Product Media</h5>

            <div class="row">
                <!-- Product Image -->
                <div class="col-md-4 form-group">
                    <label for="product_image">Product Image*</label>
                    <input type="file" id="product_image" name="product_image" class="form-control" required>
                    <small class="text-muted">Note: *(800 X 800) size</small> 
                    @if ($errors->has('product_image'))
                    <div class="text-danger">{{ $errors->first('product_image') }}</div>
                    @endif
                </div>

                <!-- Gallery Images (New) -->
                <div class="col-md-4 form-group">
                    <label for="gallery_images">Gallery Images (Max: 5)</label>
                    <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple class="form-control">
                    <small class="text-muted">Note: *(800 X 800) size</small> 
                    <div id="gallery_error" class="text-danger"></div> <!-- Error message container -->
                </div>

                <!-- Gallery Video (New) -->
                <div class="col-md-4 form-group">
                    <label for="gallery_video">Gallery Video</label>
                    <input type="file" name="gallery_video" id="gallery_video" accept="video/*" class="form-control">
                    @if ($errors->has('gallery_video'))
                    <div class="text-danger">{{ $errors->first('gallery_video') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Specifications</h5>
            
            <div id="specifications-container">
                <div class="row specification-row mb-2">
                    <div class="col-12 col-sm-6 col-md-4 mb-2 mb-sm-0">
                        <input type="text" name="specification_name[]" class="form-control" placeholder="Specification Name" maxlength="30" required>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 mb-2 mb-sm-0">
                        <input type="text" name="specification_value[]" class="form-control" placeholder="Specification Value" maxlength="30" required>
                    </div>
                </div>
            </div>

            <!-- Add Specification button -->
            <button type="button" id="add-specification" class="btn mt-2" style="width: 100%; max-width: 200px;">Add Specification</button>

        </div>
    </div>
</div>


               

                <div class="product">
                    <button type="submit" class="btn" style="margin-right:10px;">Create Product</button>
                    <a href="{{ route('vendordashboard') }}" class="btn btn-secondary" id="close">Close</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('categoryid').addEventListener('change', function() {
        fetch(`/api/subcategories/${this.value}`)
            .then(response => response.json())
            .then(data => {
                let subcategorySelect = document.getElementById('subcategory_id');
                subcategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
                data.forEach(subcategory => {
                    subcategorySelect.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                });

                // Reset child category dropdown when category changes
                let childCategorySelect = document.getElementById('childcategoryid');
                childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
            });
    });

    document.getElementById('subcategory_id').addEventListener('change', function() {
        fetch(`/api/childcategories/${this.value}`)
            .then(response => response.json())
            .then(data => {
                let childCategorySelect = document.getElementById('childcategoryid');

                // Check if child categories exist
                if (data.length === 0) {
                    childCategorySelect.innerHTML = '<option value="">No Child Category</option>';
                } else {
                    childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
                    data.forEach(childcategory => {
                        childCategorySelect.innerHTML += `<option value="${childcategory.id}">${childcategory.name}</option>`;
                    });
                }
            });
    });
</script>


<script>
    let specificationIndex = 1;

    // Add new specification row
    document.getElementById('add-specification').addEventListener('click', () => {
        const container = document.getElementById('specifications-container');
        const newRow = document.createElement('div');
        newRow.className = 'row specification-row mb-2';
        newRow.innerHTML = `
        <div class="col-12 col-sm-6 col-md-4 mb-2 mb-sm-0">
            <input type="text" name="specification_name[]" class="form-control" placeholder="Specification Name" maxlength="30" required>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-2 mb-sm-0">
            <input type="text" name="specification_value[]" class="form-control" placeholder="Specification Value" maxlength="30" required>
        </div>
        <div class="col-12 col-sm-6 col-md-4 mb-2 mb-sm-0">
    <button type="button" class="btn  remove-specification specification"
        style="background-color:rgb(158, 106, 222);color: white;font-weight: bold; height:35px;">
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

    // Event listener to remove specification row
    document.addEventListener('click', (e) => {
        if (e.target && e.target.classList.contains('remove-specification')) {
            e.target.closest('.specification-row').remove();
        }
    });
</script>


<script>
    // Automatically hide the alert after 4 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 150); // Allow fade-out animation
        }
    }, 3000);
</script>

<script>
    document.getElementById("gallery_images").addEventListener("change", function() {
        let files = this.files; // Get selected files
        let maxFiles = 5; // Maximum allowed files
        let errorContainer = document.getElementById("gallery_error");

        if (files.length > maxFiles) {
            errorContainer.textContent = "You can upload a maximum of 5 images.";
            this.value = ""; // Reset file input
        } else {
            errorContainer.textContent = ""; // Clear error message if valid
        }
    });
</script>

<script>
    function limitSalesPrice(input) {
        if (input.value > 100000000) {
            input.value = 100000000;
        }
    }
</script>

<script>
  function updateCharCount() {
    var charCount = document.getElementById('description').value.length + 1; // Start at 1
    document.getElementById('charCount').textContent = charCount + ' / 1000 characters';
  }
</script>

@endsection