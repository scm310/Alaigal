@extends('admin_layouts.app')

@section('content')





<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    /* Apply border to the table */
    #vendoriteam {
        border-collapse: collapse;
      
        border: 1px solid #ddd;
    }

    /* Apply border to table header */
    #vendoriteam th {
        border: 2px solid #ddd;
        padding: 8px;
        background-color: #A87676;
        text-align: center;
    }

    /* Apply border to table cells */
    #vendoriteam td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    /* Apply border to input fields */
    .form-control {
        border: 1px solid #ddd;
    }

    /* Border for modal content */
    .modal-content {
        border: 1px solid #ddd;
    }

    /* Apply border to the table */
    #vendoriteam {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }

    /* Apply border to table header */
    #vendoriteam th {
        border: 2px solid #ddd;
        padding: 8px;
        background-color: #A87676;
        text-align: center;
    }

    /* Apply border to table cells */
    #vendoriteam td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    /* Apply border to dropdown button */
    .dropdown-menu {
        border: 1px solid #ddd;
    }

    /* Border for modal content */
    .modal-content {
        border: 1px solid #ddd;
    }

    /* Hide sorting icons in table headers */
    table#vendoriteam thead th {
        background-image: none !important;
        /* Remove the sort icons */
        cursor: default !important;
        /* Prevent pointer cursor */
    }

    /* Specifically target the DataTables sorting classes */
    table#vendoriteam thead .sorting:after,
    table#vendoriteam thead .sorting:before,
    table#vendoriteam thead .sorting_asc:after,
    table#vendoriteam thead .sorting_asc:before,
    table#vendoriteam thead .sorting_desc:after,
    table#vendoriteam thead .sorting_desc:before {
        display: none !important;
        /* Hide the sorting arrows */
    }


    #pagination button {
        margin: 5px;
        padding: 5px 10px;
        border: 1px solid transparent;
        background-color: white;
        cursor: pointer;
    }

    #pagination button.active {
        /* background-color: #007bff; */
        color: #666 !important
        /* border-color:rgb(255, 0, 30); */
    }

    #pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    #pagination {
        display: flex;
        justify-content: flex-end;
        /* Align pagination to the right */
        margin-top: 10px;
    }

    /* Center the search box and increase its size */
</style>
<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <h4><b>Vendor-Items</b></h4>








            <div class="card-body">
                <h2></h2>
                <!-- Add Vendor and Product Input Fields -->
                <div class="container">
                    <div class="row justify-content-start">
                        <!-- Vendor Search Input Field -->
                        <div class="col-md-5 mb-3">
                            <div class="input-group">
                                <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for Vendor, products...etc" class="form-control w-75 mx-auto">
                                <span class="input-group-text" 
    style="background-color: #853ede; transition: background-color 0.3s ease-in-out;" 
    onmouseover="this.style.backgroundColor='#853ede'" 
    onmouseout="this.style.backgroundColor='#853ede'">
    <i class="bi bi-search" style="color: white;"></i> <!-- Bootstrap icon for search -->
</span>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div >
                            <!-- Show Entries and Search Controls -->
                            <div id="controls" class="d-flex justify-content-end mb-1">
                                <label for="rowsPerPage" class="me-2">Show Entries:</label>
                                <select id="rowsPerPage" onchange="updateRowsPerPage()">
                                  
                                    <option value="100" selected>100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                            <table id="vendoriteam" class="table table-striped table-bordered">
    <thead class="bg-primary">
        <tr>
            <th style="color:white;font-size:medium;text-transform:capitalize;">S.No.</th>
            <th style="color:white;font-size:medium;text-transform:capitalize;">Vendor</th>
            <th style="color:white;font-size:medium;text-transform:capitalize;">Category</th>
            <th style="color:white;font-size:medium;text-transform:capitalize;">Mobile</th>
            <th style="color:white;font-size:medium;text-transform:capitalize;">Product</th>
            <th style="color:white;font-size:medium;text-transform:capitalize;">Brand</th>
            <th style="color:white;font-size:medium;text-transform:capitalize;">Sales Price</th>
            <th style="color:white;font-size:medium;text-transform:capitalize;">Date of Creation</th>
        </tr>
    </thead>
    <tbody>
        @if($vendorItems->isEmpty())
            <tr>
                <td colspan="8" class="text-center">No data available in table</td>
            </tr>
        @else
            @foreach($vendorItems as $index => $item)
                <tr>
                    <td style="color:black" title="{{ $index + 1 }}">{{ $index + 1 }}</td>
                    <td style="color:black" title="{{ $item->company_name }}">{{ $item->company_name }}</td>
                    <td style="color:black" title="{{ $item->Category_name }}">{{ $item->Category_name }}</td>
                    <td style="color:black" title="{{ $item->phone }}">{{ $item->phone }}</td>
                    <td style="color:black" title="{{ $item->name }}">{{ $item->name }}</td>
                    <td style="color:black" title="{{ $item->brand }}">{{ $item->brand }}</td>
                    <td style="color:black" title="{{ $item->sales_price }}">
                        {{ preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', substr($item->sales_price, 0, -3)) . (strlen($item->sales_price) > 3 ? ',' : '') . substr($item->sales_price, -3) }}
                    </td>
                    <td style="color:black" title="{{ $item->created_at }}">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

                            <div id="noResultsMessage" class="no-results text-center" style="display: none;">
                                No results found.
                            </div>

                            <div id="pagination"></div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            // Initialize the DataTable


            // Trigger form submission on Enter key press for vendor and product input fields
            $('#vendor_name, #product_name').on('keydown', function(event) {
                if (event.key === "Enter") {
                    $(this).closest('form').submit();
                    $(this).next('.autocomplete-suggestions').remove(); // Close the suggestions after pressing Enter
                }
            });

            // Autocomplete for Vendor Name
            $('#vendor_name').on('input', function() {
                var query = $(this).val();
                if (query.length > 0) { // Start showing suggestions after typing the first letter
                    $.ajax({
                        url: "{{ route('vendor_items.autocomplete.vendor') }}", // Autocomplete vendor route
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            showSuggestions('#vendor_name', response.suggestions, 'vendor');
                        }
                    });
                }
            });

            // Autocomplete for Product Name
            $('#product_name').on('input', function() {
                var query = $(this).val();
                if (query.length > 0) { // Start showing suggestions after typing the first letter
                    $.ajax({
                        url: "{{ route('vendor_items.autocomplete.product') }}", // Autocomplete product route
                        method: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            showSuggestions('#product_name', response.suggestions, 'product');
                        }
                    });
                }
            });

        });

        // Function to display suggestions
        function showSuggestions(inputSelector, suggestions, type) {
            var list = '<ul class="list-group">';
            suggestions.forEach(function(item) {
                var displayText = type === 'vendor' ? item.vendor_name : item.name;
                list += `<li class="list-group-item" onclick="selectItem('${type}', '${displayText}')">${displayText}</li>`;
            });
            list += '</ul>';
            $(inputSelector).next('.autocomplete-suggestions').remove(); // Remove old suggestions
            $(inputSelector).after('<div class="autocomplete-suggestions">' + list + '</div>'); // Display new suggestions
        }

        // Function to handle the selection of a suggestion
        function selectItem(type, value) {
            // Set the selected value to the input field
            if (type === 'vendor') {
                $('#vendor_name').val(value);
            } else {
                $('#product_name').val(value);
            }

            // Remove the suggestions
            $('.autocomplete-suggestions').remove();

            // Trigger filtering in the DataTable after selection
            filterData();
        }

        // Function to filter data in DataTable based on input fields
        function filterData() {
            var vendorName = $('#vendor_name').val(); // Get vendor name value
            var productName = $('#product_name').val(); // Get product name value

            // Apply filter to DataTable
            var table = $('#vendoriteam').DataTable();
            table.column(1).search(vendorName).column(3).search(productName).draw();
        }
    </script>


    <script>
        let currentPage = 1;
        let rowsPerPage = 100; // Default rows per page

        function searchTable() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("vendoriteam");
            const rows = table.getElementsByTagName("tr");
            let filteredRows = [];

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j] && cells[j].textContent.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }

                if (match) {
                    filteredRows.push(rows[i]);
                }
            }

            // If no results found, show the "No results found" message
            const noResultsMessage = document.getElementById("noResultsMessage");
            if (filteredRows.length === 0 && input.value !== "") {
                noResultsMessage.style.display = "block";
            } else {
                noResultsMessage.style.display = "none";
            }

            currentPage = 1; // Reset to first page on new search
            showPage(filteredRows);
        }

        function showPage(filteredRows) {
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const rowsToShow = filteredRows.slice(startIndex, endIndex);

            const table = document.getElementById("vendoriteam");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = "none";
            }

            rowsToShow.forEach(row => {
                row.style.display = "";
            });

            displayPagination(filteredRows);
        }

        function displayPagination(filteredRows) {
            const pageCount = Math.ceil(filteredRows.length / rowsPerPage);
            const pagination = document.getElementById("pagination");
            pagination.innerHTML = "";

            const prevButton = document.createElement("button");
            prevButton.innerText = "Previous";
            prevButton.disabled = currentPage === 1;
            prevButton.onclick = function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(filteredRows);
                }
            };
            pagination.appendChild(prevButton);

            for (let i = 1; i <= pageCount; i++) {
                const button = document.createElement("button");
                button.innerText = i;
                button.className = currentPage === i ? "active" : "";
                button.onclick = function() {
                    currentPage = i;
                    showPage(filteredRows);
                };
                pagination.appendChild(button);
            }

            const nextButton = document.createElement("button");
            nextButton.innerText = "Next";
            nextButton.disabled = currentPage === pageCount || pageCount === 0;
            nextButton.onclick = function() {
                if (currentPage < pageCount) {
                    currentPage++;
                    showPage(filteredRows);
                }
            };
            pagination.appendChild(nextButton);
        }

        function updateRowsPerPage() {
            rowsPerPage = parseInt(document.getElementById("rowsPerPage").value, 100);
            searchTable(); // Refresh table
        }

        document.addEventListener("DOMContentLoaded", function() {
            searchTable();
        });
    </script>


    @endsection