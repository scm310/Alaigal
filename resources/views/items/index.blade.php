@extends('admin_layouts.app')

@section('content')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<style>

    /* Change cancel button hover color */
    .custom-cancel-button:hover {
        background-color: gray !important;
        color: white !important;
    }

    #productTable_filter>label>input[type=search] {
        margin-bottom: 10px;
        margin-top: 3px;
    }

    /* Optional customization for Bootstrap tooltips */
    .tooltip-inner {
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
    }

    .tooltip-arrow {
        border-top-color: rgba(0, 0, 0, 0.7);
    }

    /* Apply border to the table */
    #vendorTable {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }

    /* Apply border to table header */
    #vendorTable th {
        border: 1px solid #ddd;
        padding: 8px;
        background-color: #f8f9fa;
        text-align: center;
    }

    /* Apply border to table cells */
    #vendorTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    /* Apply border to dropdown button */
    .dropdown-menu {
        border: 1px solid #ddd;

        right: auto !important;
        left: 117px !important;
    }

    /* Optional: Adjust positioning */
    .dropdown-toggle::after {
        margin-left: 0.5rem;
    }

    /* Border for modal content */
    .modal-content {
        border: 1px solid #ddd;
    }

    /* Hide sorting icons in table headers */
    table#productTable thead th {
        background-image: none !important;
        /* Remove the sort icons */
        cursor: default !important;
        /* Prevent pointer cursor */
    }

    /* Specifically target the DataTables sorting classes */
    table#productTable thead .sorting:after,
    table#productTable thead .sorting:before,
    table#productTable thead .sorting_asc:after,
    table#productTable thead .sorting_asc:before,
    table#productTable thead .sorting_desc:after,
    table#productTable thead .sorting_desc:before {
        display: none !important;
        /* Hide the sorting arrows */
    }

    .comparison-header {
        display: flex;
        align-items: center;
        /* Vertically align items */
        justify-content: space-between;
        /* Distribute space between title and tabs */
        margin-bottom: 20px;
    }

    .comparison-title {
        border: 2px solid #ddd;
        padding: 10px 15px;
        border-radius: 5px;
        background-color: #f9f9f9;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .tabs {
        display: flex;
        gap: 10px;
        /* Space between tabs */
    }

    .tab {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        cursor: pointer;
        font-weight: bold;
        font-size: 1rem;
        text-align: center;
        min-width: 100px;
        /* Ensure consistent size for tabs */
        text-overflow: ellipsis;
    }

    .tab.active {
        background-color: #804be0;
        color: white;
        border-color: #804be0;
    }


    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th,
    table td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }

    table th {
        background-color: #f1f1f1;
    }


    .comparison-title {
        border: 2px solid #ddd;
        /* Border around the title */
        padding: 10px 15px;
        /* Add spacing inside the border */
        border-radius: 5px;
        /* Rounded corners */
        background-color: #f9f9f9;
        /* Light background color */
        text-align: center;
        /* Center-align the title */
        margin-bottom: 20px;
        /* Space below the title */
        /* font-weight: bold; Make the title bold */
        font-size: 1.2rem;
        /* Adjust font size */
    }

    .comparison-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .comparison-card .card-title {
        font-weight: bold;
        margin-bottom: 1rem;
    }


    #suggestions {
        top: calc(100% + 5px);
        /* Place the suggestion box just below the search bar */
        left: 0;
        /* Align to the left of the search field */
        max-width: 70%;
        /* Ensure it aligns with the search bar width */
        background-color: #fff;
        /* Background for better visibility */
        border: 1px solid #ddd;
        /* Add border for distinction */
        border-radius: 5px;
        /* Rounded corners */
    }

    .modal-backdrop {
        width: 2000vw !important;
        /* Increase width (120% of viewport width) */
        height: 200vh !important;
        /* Increase height (120% of viewport height) */
        background-color: rgba(0, 0, 0, 0.5) !important;
        /* Optional: Adjust opacity */
        position: absolute !important;
        /* Ensure proper positioning */
        top: 150% !important;
        /* Center vertically */
        left: 200% !important;
        /* Center horizontally */
        transform: translate(-100%, -100%) !important;
        /* Ensure it's centered */

    }

    .dropdown-menu.show {
        background: linear-gradient(90deg, rgba(252, 252, 254, 1) 0%, rgba(244, 233, 249, 1) 35%, rgba(225, 205, 240, 1) 100%);
        transform: translateX(870px) !important;
        margin-top: 73px;
    }

    .edit {
        color: blue !important;
    }

    .view {
        color: lightsalmon;
    }

    .highlight {
        color: green;
    }

    .close:hover {
        background-color: grey !important;
    }

    th {
        background-color: #A87676;
        /* Set background color */
        color: white;
        /* Set text color to white */
        text-transform: capitalize !important;
        /* Apply Pascal case formatting */
    }

    .btn {
        text-transform: capitalize !important;
    }
</style>
<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            
                <div class="col-4">
                    <h4><b>Manage Products</b></h4>
                </div>
              

            
            


            <div class="card-header d-flex justify-content-end align-items-center">

                @if(session('success'))
                <div class="alert alert-success text-center mx-auto w-50" id="success-message">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger text-center mx-auto w-50">
                    {{ session('error') }}
                </div>
                @endif



            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="container ">
                     
                      
                        <div class="row">

                            <div class="table-responsive">
                                <!-- Products Table -->
                                <table id="productTable" style="width:100%" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Product Name</th>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Brand / Group</th>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Company</th>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Expiry Date</th>
            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>
                <a href="{{ route('items.show', $item->id) }}">
                    {{ $item->item_name }}
                </a>
            </td>
            <td>{{ $item->brand ?? 'N/A' }}</td>
            <td>{{ $item->company_name ?? 'N/A' }}</td>
            <td>{{ $item->expiration_date ? \Carbon\Carbon::parse($item->expiration_date)->format('d-m-Y') : 'N/A' }}</td>
            <td>
    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }})">
    <i class="fas fa-trash-alt"></i>
    </button>

    <form id="delete-form-{{ $item->id }}" action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</td>
        </tr>
        @endforeach
    </tbody>
</table>



                            </div>
                        </div>

                    </div>
                </div>
            </div>







            <!-- Modal for Product Details -->
            @foreach ($items as $item)
            <div class="modal fade" id="productModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="productModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel{{ $item->id }}">{{ $item->name }} - Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Product Details Section -->
                            <h6 style="font-weight:800; color:black;">Primary Product Details</h6>
                            <div class="product custom-shadow">
                                <div class="row mb-2">
                                    <div class="col-md-3 d-flex align-items-center">
                                        @if ($item->product_image)
                                        <img src="{{ asset('storage/app/public/' . $item->product_image) }}" alt="Product Image" class="img-fluid" style="max-height: 90px;">
                                        @else
                                        <img src="{{ asset('default-image.jpg') }}" alt="Default Product Image" class="img-fluid" style="max-height: 90px;">
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-12 d-flex">
                                                <strong>Product Name:</strong>
                                                <div class="ms-2">{{ $item->name }}</div>
                                            </div>
                                            <div class="col-12 d-flex">
                                                <strong>Product ID:</strong>
                                                <div class="ms-2">{{ $item->product_id }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Price and Tax Section -->
                            <h6 class="mt-4" style="font-weight:800; color:black;">Price and Tax Details</h6>
                            <div class="product custom-shadow">
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Sales Price:</strong>
                                        <div class="ms-2">â‚¹{{ number_format($item->sales_price) }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>Purchase Price:</strong>
                                        <div class="ms-2">â‚¹{{ number_format($item->purchase_price) }}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Tax:</strong>
                                        <div class="ms-2">{{ $item->tax ? $item->tax . '%' : 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>Expiration Date:</strong>
                                        <div class="ms-2">
                                            {{ $item->expiration_date ? \Carbon\Carbon::parse($item->expiration_date)->format('d-m-Y') : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>CGST:</strong>
                                        <div class="ms-2">{{ $item->tax ? $item->tax/2 . '%' : 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>SGST:</strong>
                                        <div class="ms-2">{{ $item->tax ? $item->tax/2 . '%' : 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vendor Information -->
                            <h6 class="mt-4" style="font-weight:800; color:black;">Vendor Information</h6>
                            <div class="product custom-shadow">
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Vendor Name:</strong>
                                        <div class="ms-2">{{ $item->vendor_name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>Email:</strong>
                                        <div class="ms-2">{{ $item->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Contact:</strong>
                                        <div class="ms-2">{{ $item->phone_number ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Specifications Section -->
                            <h6 class="mt-4" style="font-weight:800; color:black;">Specifications</h6>
                            <div class="product custom-shadow">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="font-weight:900; color:#89868d; text-transform: capitalize; font-size:small">Specification Name</th>
                                            <th style="font-weight:900; color:#89868d; text-transform: capitalize; font-size:small">Specification Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($item->specification_name && $item->specification_value)
                                        @php
                                        $specValue1 = json_decode($item->specification_name, true);
                                        $specValue = json_decode($item->specification_value, true);
                                        @endphp
                                        @if(is_array($specValue1))
                                        @foreach ($specValue1 as $i => $specName)
                                        <tr>
                                            <td><b>{{ $specName ?? 'Unknown' }}</b></td>
                                            <td>{{ $specValue[$i] ?? 'N/A' }}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        @else
                                        <tr>
                                            <td colspan="2">No specifications available.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Categories Section -->
                            <h6 class="mt-4" style="font-weight:800; color:black;">Categories</h6>
                            <div class="product custom-shadow">
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Main Category:</strong>
                                        <div class="ms-2">{{ $item->category_name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <strong>Subcategory:</strong>
                                        <div class="ms-2">{{ $item->subcategory_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-6 d-flex">
                                        <strong>Child Category:</strong>
                                        <div class="ms-2">{{ $item->child_category_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</div>


<!-- script section -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // Fade after 3 seconds
        }
    });

    $('button[data-toggle="modal"]').on('click', function() {
        console.log('Modal button clicked!');
    });
</script>


<script>
    $(document).ready(function() {
        // Initialize the DataTable
        $('#productTable').DataTable({
            "responsive": true, // Makes the table responsive for mobile screens
            "pageLength": 10, // Set the default number of rows per page
            "lengthMenu": [10, 25, 50, 100], // Options for rows per page
            "ordering": true, // Enable column ordering
            "searching": true, // Enable search functionality
            "info": true, // Display information about the table (e.g., showing entries 1 to 10 of 50)
        });
    });
</script>

<!-- JavaScript -->
<script>
    // Get references to DOM elements
    const compareBtn = document.getElementById('compareBtn');
    const comparisonContainer = document.querySelector('.comparison-container');

    // Enable the button (you can add logic to enable based on certain conditions)
    compareBtn.disabled = false;

    // Add event listener to the Compare button
    compareBtn.addEventListener('click', function() {
        // Show the comparison container when the button is clicked
        comparisonContainer.style.display = 'block';
    });


    document.addEventListener("DOMContentLoaded", function() {
        let currentSection = 0;
        const sections = document.querySelectorAll(".card-section");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");


    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchBar = document.getElementById('search-bar');
        const suggestions = document.getElementById('suggestions');
        const compareBtn = document.getElementById('compareBtn');
        const compareContainer = document.getElementById('compareContainer');

        const products = @json($items); // Fetch all products from the backend
        const selectedProducts = new Map(); // To store selected products

        // Handle search input
        searchBar.addEventListener('input', function() {
            const query = searchBar.value.split(',').pop().trim().toLowerCase();
            if (!query) {
                suggestions.style.display = 'none';
                return;
            }

            // Filter products by query
            const filteredProducts = products.filter(product =>
                product.name.toLowerCase().includes(query) && !selectedProducts.has(product.name)
            );

            displaySuggestions(filteredProducts);
        });

        // Display suggestions
        function displaySuggestions(filteredProducts) {
            suggestions.innerHTML = ''; // Clear suggestions
            if (filteredProducts.length > 0) {
                const groupedProducts = groupBy(filteredProducts, 'name');
                Object.keys(groupedProducts).forEach(productName => {
                    const suggestionItem = document.createElement('li');
                    suggestionItem.className = 'list-group-item list-group-item-action';
                    suggestionItem.textContent = productName;
                    suggestionItem.addEventListener('click', function() {
                        addProduct(productName, groupedProducts[productName]);
                        suggestions.style.display = 'none';
                        searchBar.value = Array.from(selectedProducts.keys()).join(', '); // Update search field
                    });
                    suggestions.appendChild(suggestionItem);
                });
                suggestions.style.display = 'block';
            } else {
                suggestions.innerHTML = '<li class="list-group-item">No products found.</li>';
                suggestions.style.display = 'block';
            }
        }

        // Add product to the selection
        function addProduct(name, products) {
            if (!selectedProducts.has(name)) {
                selectedProducts.set(name, products);
                updateCompareButton();
                displayComparisonResults(); // Recalculate results after addition
            }
        }

        // Enable or disable the Compare button
        function updateCompareButton() {
            compareBtn.disabled = selectedProducts.size === 0;
        }

        // Remove a product when user edits the search field
        searchBar.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && searchBar.value.endsWith(',')) {
                const lastProduct = Array.from(selectedProducts.keys()).pop();
                selectedProducts.delete(lastProduct);
                searchBar.value = Array.from(selectedProducts.keys()).join(', ');
                updateCompareButton();
                displayComparisonResults(); // Recalculate results after removal
            }
        });

        // Display comparison results (reuse your existing logic)
        function displayComparisonResults() {
            compareContainer.innerHTML = ''; // Clear previous results

            if (selectedProducts.size === 1) {
                // Single product logic
                const [name, products] = Array.from(selectedProducts.entries())[0];
                const title = document.createElement('h4');
                compareContainer.appendChild(title);

                const table = createComparisonTable(products, name);
                compareContainer.appendChild(table);
            } else if (selectedProducts.size > 1) {
                // Multiple product logic
                const title = document.createElement('h4');
                title.textContent = 'Vendor Comparison';
                compareContainer.appendChild(title);

                const tabs = document.createElement('div');
                tabs.className = 'tabs';
                const tabContent = document.createElement('div');
                tabContent.className = 'tab-content';

                let firstTab = true;

                selectedProducts.forEach((products, name) => {
                    const tab = document.createElement('div');
                    tab.className = `tab ${firstTab ? 'active' : ''}`;

                    // Truncate name if it exceeds 8 characters
                    const truncatedName = name.length > 8 ? `${name.substring(0, 8)}...` : name;
                    tab.textContent = truncatedName;

                    // Add full name as a title tooltip
                    tab.setAttribute('title', name); // The full name of the product is added as a tooltip

                    tab.addEventListener('click', () => {
                        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                        tab.classList.add('active');

                        tabContent.innerHTML = ''; // Clear content
                        const table = createComparisonTable(products, name);
                        tabContent.appendChild(table);
                    });

                    tabs.appendChild(tab);

                    if (firstTab) {
                        const table = createComparisonTable(products, name);
                        tabContent.appendChild(table);
                        firstTab = false;
                    }
                });


                compareContainer.appendChild(tabs);
                compareContainer.appendChild(tabContent);

                // Initialize tooltips (Bootstrap-specific)
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }


        // Group products by a key (e.g., name)
        function groupBy(array, key) {
            return array.reduce((result, currentValue) => {
                const groupKey = currentValue[key];
                if (!result[groupKey]) {
                    result[groupKey] = [];
                }
                result[groupKey].push(currentValue);
                return result;
            }, {});
        }


        // Create the comparison table (reuse your existing logic)
        function createComparisonTable(products, productName) {
            const card = document.createElement('div');
            card.className = 'card comparison-card';
            card.style.marginTop = '1rem';

            const cardBody = document.createElement('div');
            cardBody.className = 'card-body';

            if (productName) {
                const cardTitle = document.createElement('h5');
                cardTitle.textContent = `Comparison for: ${productName}`;
                cardBody.appendChild(cardTitle);
            }

            const table = document.createElement('table');
            table.className = 'table table-bordered';

            const thead = document.createElement('thead');
            const headerRow = document.createElement('tr');

            // Define column headings
            const headings = ['S.No', 'Product Name', 'Vendor Name', 'Price', 'Brand', 'Updated On'];
            headings.forEach(heading => {
                const th = document.createElement('th');
                th.textContent = heading;
                th.style.backgroundColor = '#A87676';
                th.style.color = 'white'; // Set the text color to white // Add this line to set the background color
                headerRow.appendChild(th);
            });

            // Add sort icon for Price column
            const priceHeader = headerRow.querySelectorAll('th')[3]; // Price column header
            const sortIcon = document.createElement('span');
            sortIcon.classList.add('sort-icon', 'ascending');
            priceHeader.appendChild(sortIcon);

            // Variable to keep track of the sorting direction
            let isAscending = true; // Initially set sorting to ascending

            // Toggle sorting state when the Price header is clicked
            sortIcon.addEventListener('click', () => {
                isAscending = !isAscending;
                sortIcon.innerHTML = isAscending ? '' : ''; // Change the icon based on sort direction
                sortProductsByPrice(isAscending);
                updateTable(); // Recalculate and display the sorted table
            });


            thead.appendChild(headerRow);
            table.appendChild(thead);

            const tbody = document.createElement('tbody');

            // Function to sort products by price
            function sortProductsByPrice(ascending) {
                products.sort((a, b) => {
                    const priceA = parseFloat(a.sales_price || 0);
                    const priceB = parseFloat(b.sales_price || 0);
                    return ascending ? priceA - priceB : priceB - priceA;
                });
            }

            // Function to update the table body after sorting
            // Inside the updateTable function, modify the table rows:
            function updateTable() {
                tbody.innerHTML = ''; // Clear the existing rows
                let serialNumber = 1; // Start the serial number from 1
                products.forEach(product => {
                    const row = document.createElement('tr');

                    const serialCell = document.createElement('td');
                    serialCell.textContent = serialNumber++; // Increment the serial number for each row
                    row.appendChild(serialCell);

                    const productCell = document.createElement('td');
                    productCell.textContent = product.name || 'N/A';
                    row.appendChild(productCell);

                    const vendorCell = document.createElement('td');
                    vendorCell.textContent = product.vendor_name || 'N/A';
                    row.appendChild(vendorCell);

                    const priceCell = document.createElement('td');
                    priceCell.textContent = `₹${parseFloat(product.sales_price || 0).toLocaleString('en-IN')}`;
                    row.appendChild(priceCell);

                    const brandCell = document.createElement('td');
                    brandCell.textContent = product.brand || 'N/A';
                    row.appendChild(brandCell);

                    const updatedCell = document.createElement('td');
                    updatedCell.textContent = product.Date ?
                        new Date(product.Date).toLocaleDateString('en-GB') // DD-MM-YYYY format
                        :
                        new Date(product.created_at).toLocaleDateString('en-GB');
                    row.appendChild(updatedCell);


                    tbody.appendChild(row);
                });
            }

            // Initial sort when the table is rendered
            sortProductsByPrice(isAscending);
            updateTable(); // Display the sorted products initially

            table.appendChild(tbody);
            cardBody.appendChild(table);
            card.appendChild(cardBody);

            // Initialize DataTable
            $(table).DataTable(); // This will enable DataTable functionality

            return card;
        }
    });
</script>


<script>
    function updateFileName() {
        var input = document.getElementById('fileInput');
        var fileNameDisplay = document.getElementById('fileName');

        if (input.files.length > 0) {
            fileNameDisplay.textContent = "Selected File: " + input.files[0].name;
            fileNameDisplay.style.display = "inline";
        } else {
            fileNameDisplay.style.display = "none";
        }
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(itemId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + itemId).submit();
            }
        });
    }

    // Show success message after deletion
    @if(session('delete_success'))
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: "Product Deleted Successfully!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK"
        });
    });
    @endif
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(itemId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#804be0",
            cancelButtonColor: "#804be0",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            customClass: {
                cancelButton: 'custom-cancel-button'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + itemId).submit();
            }
        });
    }
</script>

@endsection