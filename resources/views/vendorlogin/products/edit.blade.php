@extends('vendor_layouts.app')

@section('content1')

<!-- Error Messages -->
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:340px;margin-left:300px;">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- Add this inside your <head> section or your external CSS file -->
<style>
    /* Hide increment and decrement arrows for number inputs */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }




    .custom-btn:hover {
        background-color: rgb(145, 81, 229);
        color: white !important;
    }
</style>

<style>
    .btn {
        background-color: rgb(145, 81, 229);
        color: white !important;
    }

    /* .btn:hover {
        background-color: rgb(145, 81, 229);
        color: white !important;
    } */

    #close:hover {

        background-color: grey;
    }

    .footer {
        margin-top: 100px;
    }

    .container{
        margin-left:-15px;
        margin-bottom:50px;
        margin-top:-50px;
    }

    .btn-secondary{
            height:35px;
        }

    /* Responsive Design */
    @media (max-width: 768px) {

        .container {
            padding: 15px;
            margin-top: -80px;
        }

        .row {
            display: flex;
            flex-direction: column;
        }

        .col-md-4 {
            width: 100%;
        }

        /*
    .d-flex {
        flex-direction: column;
    } */

        .d-flex input {
            width: 100% !important;
            margin-bottom: 10px;
        }

        .btn1 {
            margin-top: 10px;
        }

        #add-more-specifications {
            width:70%;
        }

        .container{
        margin-left:0px;
        margin-bottom:30px;
    }

    }

    @media (max-width: 480px) {
        h2 {
            font-size: 20px;
        }

        .card {
            padding: 10px;
        }

        .btn1 {
            font-size: 14px;
            padding: 8px;
        }

        .btn-secondary{
            height:38px;
        }

        .form-group{
    font-size:13px;
}

.form-control{
    font-size:13px;
}

#add-more-specifications{
    margin-left:18px;
    width: max-content;
}


.specification-row {
            display: flex;
            flex-direction: column;
        }

        .specification-row input {
            width: 100% !important;
            margin-bottom: 5px;
        }

        .specification-row .remove {
            width:45%;
            margin-top:1px;
        }

        .remove-specification {
    border: none;
    padding: 5px 15px;
    font-size:12px;
    border-radius: 5px;
    cursor: pointer;
}
    }

    h2{
        font-size: 24px;
        margin-top:-10px;
    }
    .header {
    background: linear-gradient(to right, #5a6c8e, #b180c7);
    color: white;
    padding: 15px;
    font-size: 24px;
    font-weight: bold;
    border-radius: 8px;
    margin-bottom: 15px;
}

.card-header{
    height:40px;
}

.form-group{
    font-size:13px;
}

.form-control{
    font-size:13px;
}

.remove-specification {
    border: none;
    padding: 5px 15px;
    font-size:12px;
    border-radius: 5px;
    cursor: pointer;
}


</style>


<div class="container">
    <div class="card mt-3">
        <div class="card-header header">
            <h2 class="text-center">Edit Product</h2>
        </div>
        <div class="card-body">

            <!-- Success Message -->

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonColor: 'rgb(145, 81, 229)',
            confirmButtonText: 'OK'
        });
    @endif
</script>



            <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Categories Section -->
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="categoryid">Category</label>
                        <select id="categoryid" name="categoryid" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->Category_id }}" {{ $product->categoryid == $category->Category_id ? 'selected' : '' }}>
                                {{ $category->Category_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('categoryid')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="subcategoryid">Subcategory</label>
                        <select id="subcategoryid" name="subcategoryid" class="form-control">
                            <option value="">Select Subcategory</option>
                            @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" {{ $product->subcategoryid == $subcategory->id ? 'selected' : '' }}>
                                {{ $subcategory->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('subcategoryid')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="childcategoryid">Child Category</label>
                        <select id="childcategoryid" name="childcategoryid" class="form-control">
                            <option value="">Select Child Category</option>
                            @foreach($childcategories as $childcategory)
                            <option value="{{ $childcategory->id }}" {{ $product->childcategoryid == $childcategory->id ? 'selected' : '' }}>
                                {{ $childcategory->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('childcategoryid')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" id="product_name" name="product_name" class="form-control" value="{{ old('product_name', $product->name) }}">
                        @error('product_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="brand">Brand</label>
                        <input type="text" id="brand" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
                        @error('brand')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="uom">U.O.M</label>
                        <select id="uom" name="uom" class="form-control">
                            <option value="">Select Unit</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}"
                                {{ old('uom', $product->uom) == $unit->id ? 'selected' : '' }}>
                                {{ $unit->unit }}
                            </option>
                            @endforeach
                        </select>
                        @error('uom')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>



                </div>


                <!-- Pricing Section -->
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="tax">GST (%)</label>
                        <input type="number" id="tax" name="tax" class="form-control" value="{{ intval($product->tax) }}">
                    </div>
                    <div class="col-md-4 form-group">
    <label for="sales_price">Sales Price</label>
    <input type="number" id="sales_price" name="sales_price" class="form-control"
           value="{{ intval($product->purchase_price) }}" 
           max="100000000" oninput="restrictSalesPrice(this)">
</div>

<script>
    function restrictSalesPrice(input) {
        if (input.value > 100000000) {
            input.value = 100000000; // Set max limit silently
        }
    }
</script>

                    <div class="col-md-4 form-group">
                        <label for="expiration_date">Expiry Date</label>
                        <input type="date" id="expiration_date" name="expiration_date" class="form-control" value="{{ $product->expiration_date }}">
                    </div>


                </div>

                <!-- Additional Information Section -->
                <div class="row">

                    <div class="col-md-4 form-group">
                        <label for="product_image">Product Image <small class="text-muted">Note: (800 X 800) size </small> </label>
                        <input type="file" id="product_image" name="product_image" class="form-control">
                        @if($product->product_image)
                        <img src="{{ asset('storage/app/public/' . $product->product_image) }}" alt="Product Image" class="img-thumbnail mt-2" width="50">
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="gallery_images">Gallery Images (Max: 5)  <small class="text-muted">Note: (800 X 800)  </small> </label>
                        <input type="file" id="gallery_images" name="gallery_images[]" class="form-control" multiple accept="image/*" onchange="validateGalleryImages()">
                       
                        <span id="gallery_images_error" class="text-danger"></span>

                        @if($product->gallery_images)
                        <div class="mt-2">
                            @foreach(json_decode($product->gallery_images, true) as $image)
                            
                            <img src="{{ asset('storage/app/public/' . $image)  }}" alt="Gallery Image" class="img-thumbnail m-1" width="50">
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
    <div class="form-group">
        <label>Gallery Video</label>

        <input type="file" name="gallery_video" accept="video/*" style="border: 1px solid #ccc; padding: 5px; width: 100%; border-radius: 4px;">

        @if($product->gallery_video)
        <div style="margin-top: 10px; border: 1x solid #ccc; padding: 5px; border-radius: 5px; display: inline-block;">
            <video width="150" height="80px" controls>
                <source src="{{ asset('storage/app/public/' . $product->gallery_video) }}" type="video/mp4">
            </video>
        </div>
        @endif
    </div>
</div>

                </div>


                <!-- Gallery Images Section -->
                <div class="row">


                    <!-- Gallery Videos Section -->
                    <!-- Gallery Videos Section -->


                </div>

                <div class="col-md-12">
    <label for="description"> Product Description* 
        <span style="font-size:11px;">(Note: Exceeding more than 1000 characters is not allowed.)</span>
    </label>

    <textarea id="description" name="description" class="form-control" placeholder="Enter product description" required maxlength="1000"
        oninput="document.getElementById('charCount').textContent = this.value.length + ' / 1000 characters';"
        style="width: 100%; height: 200px; font-size: 16px; padding: 10px;">{{ old('description', $product->description) }}</textarea>

    <small id="charCount" class="text-muted">0 / 1000 characters</small>

    @if ($errors->has('description'))
        <div class="text-danger">{{ $errors->first('description') }}</div>
    @endif
</div>


                <!-- Specifications Section -->
                <div id="specifications-list">
                    <label for="specifications">Specifications</label>
                    @foreach($specifications as $index => $specification)
                    <div class="d-flex mb-2">
                        <input type="text" name="specification_name[]" class="form-control mr-2" placeholder="Specification Name" value="{{ $specification }}" maxlength="70" style="width: 45%;">
                        <input type="text" name="specification_value[]" class="form-control" placeholder="Specification Value" value="{{ $specification_values[$index] ?? '' }}" maxlength="70" style="width: 45%;">
                    </div>
                    @endforeach
                </div>

                <button type="button" id="add-more-specifications" class="btn btn1">Add More Specifications</button>

                <!-- Product Details and other fields -->




                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn mr-2 btn1">Update Product</button>

                    <a href="{{ route('vendordashboard') }}" class="btn btn1" id="close">Close</a>
                </div>

            </form>
        </div>
    </div>
</div>


<script>
    document.getElementById('add-subcategory').addEventListener('click', function() {
        let subcategoryList = document.getElementById('subcategory-list');
        let newSubcategory = document.createElement('div');
        newSubcategory.classList.add('d-flex', 'mb-2');
        newSubcategory.innerHTML = `
        <input type="text" name="subcategory_name[]" class="form-control mr-2" placeholder="Subcategory" style="width: 90%;">
        <button type="button" class="btn btn-danger remove-subcategory">Remove</button>
    `;
        subcategoryList.appendChild(newSubcategory);
    });

    document.getElementById('add-childcategory').addEventListener('click', function() {
        let childCategoryList = document.getElementById('childcategory-list');
        let newChildCategory = document.createElement('div');
        newChildCategory.classList.add('d-flex', 'mb-2');
        newChildCategory.innerHTML = `
        <input type="text" name="childcategory_name[]" class="form-control mr-2" placeholder="Child Category" style="width: 90%;">
        <button type="button" class="btn btn-danger remove-childcategory">Remove</button>
    `;
        childCategoryList.appendChild(newChildCategory);
    });

    // Remove subcategory
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-subcategory')) {
            event.target.parentElement.remove();
        }
    });

    // Remove child category
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-childcategory')) {
            event.target.parentElement.remove();
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
    document.getElementById('add-more-specifications').addEventListener('click', function() {
        let specificationsList = document.getElementById('specifications-list');
        let newSpecificationIndex = specificationsList.children.length;
        let newSpecification = document.createElement('div');

        newSpecification.classList.add('d-flex', 'mb-2', 'specification-row');
        newSpecification.id = 'specification-row-' + newSpecificationIndex;

        newSpecification.innerHTML = `
            <input type="text" name="specification_name[]" class="form-control mr-2" placeholder="Specification Name" maxlength="30" style="width: 45%;">
            <input type="text" name="specification_value[]" class="form-control" placeholder="Specification Value" maxlength="30" style="width: 45%;">
            <button type="button" class="btn btn-secondary ml-2 remove-specification remove" data-index="${newSpecificationIndex}">Remove</button>
        `;

        specificationsList.appendChild(newSpecification);
    });

    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-specification')) {
            let index = event.target.getAttribute('data-index');
            let row = document.getElementById('specification-row-' + index);
            if (row) {
                row.remove();
            }
        }
    });
</script>


<script>
    document.getElementById('categoryid').addEventListener('change', function() {
        let categoryId = this.value;
        let subcategorySelect = document.getElementById('subcategoryid');
        let childCategorySelect = document.getElementById('childcategoryid');

        if (categoryId) {
            fetch(`/api/subcategories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                    if (data.length > 0) {
                        data.forEach(subcategory => {
                            subcategorySelect.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                        });
                    } else {
                        subcategorySelect.innerHTML = '<option value="" disabled>No subcategories available</option>';
                    }

                    // Reset child category dropdown
                    childCategorySelect.innerHTML = '<option value="0">No Child Category</option>';
                })
                .catch(error => console.error('Error fetching subcategories:', error));
        } else {
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            childCategorySelect.innerHTML = '<option value="0">No Child Category</option>';
        }
    });

    document.getElementById('subcategoryid').addEventListener('change', function() {
        let subcategoryId = this.value;
        let childCategorySelect = document.getElementById('childcategoryid');

        if (subcategoryId) {
            fetch(`/api/childcategories/${subcategoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        childCategorySelect.innerHTML = '<option value="">Select Child Category</option>';
                        data.forEach(childcategory => {
                            childCategorySelect.innerHTML += `<option value="${childcategory.id}">${childcategory.name}</option>`;
                        });
                    } else {
                        childCategorySelect.innerHTML = '<option value="0">No Child Category</option>';
                    }
                })
                .catch(error => console.error('Error fetching child categories:', error));
        } else {
            childCategorySelect.innerHTML = '<option value="0">No Child Category</option>';
        }
    });
</script>



<script>
    function validateGalleryImages() {
        let input = document.getElementById("gallery_images");
        let errorDiv = document.getElementById("gallery_images_error");

        if (input.files.length > 5) {
            errorDiv.innerText = "You can only upload a maximum of 5 images.";
            input.value = ""; // Reset the input field
        } else {
            errorDiv.innerText = ""; // Clear error if within limit
        }
    }
</script>



@endsection