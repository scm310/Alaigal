@extends('admin_layouts.app')

@section('content')


<style>

       body{
        overflow-x: hidden;
       }

        .content-wrapper{
        background-color: white;
    }


    /* Styling for the button */
    .btn-primary {
        background: linear-gradient(45deg, #007bff, #00c6ff); /* Gradient color */
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: 25px; /* Rounded corners */
        font-weight: bold;
        transition: background 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0px 4px 6px rgba(0, 123, 255, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #0056b3, #0095d9);
        transform: scale(1.05); /* Slight zoom on hover */
        box-shadow: 0px 6px 10px rgba(0, 123, 255, 0.4); /* Stronger shadow on hover */
    }

    /* Styling for form label */
    label {
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }

    /* Input field styling */
    .form-control {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 12px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }


    /* Note section */
    .note {
        font-size: 14px;
        color: #888;
        margin-top: 20px;
    }

    /* Form container styling */
    .form-container {
      width:365px;
        margin: 0 auto;
        background: #f8f9fa;
        padding:10px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        height:225px;
        transform: translateX(40px);
    }

    /* Flexbox layout for the form group */
    .form-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom:35px;
    }

    label {
        font-weight: bold;
        color: #333;
        margin-right: 10px;
    }

    .form-control {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        width:100%; /* Adjust width for file input */
        box-sizing: border-box;
    }
    /* Button styling */
    .btn-primary {
        background:rgb(144, 49, 212);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius:5px;
        cursor: pointer;
        width:35%;
        font-size: 16px;
        margin-left:10px;
    }

    .btn-primary:hover {
        background:rgb(144, 49, 212);
        transform: scale(1.05);
    }

    .btn{
  text-transform: capitalize !important;
}
</style>

<style>
            /* Custom Tooltip Styling */

            /* Optional customization for Bootstrap tooltips */
            .tooltip-inner {
                background-color: rgba(0, 0, 0, 0.7);
                color: white;
            }

            .tooltip-arrow {
                border-top-color: rgba(0, 0, 0, 0.7);
            }

            /* Apply border to the table */


            /* Apply border to dropdown button */
            .dropdown-menu {
                border: 1px solid #ddd;
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

            #productTable th:nth-child(1),
           #productTable td:nth-child(1) {
        width: 15px !important; /* Force width */
        max-width: 100px !important; /* Prevent expansion */

    }

    #productTable th:nth-child(3),
           #productTable td:nth-child(3) {
        width: 15px !important; /* Force width */
        max-width: 100px !important; /* Prevent expansion */

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
                background-color: #007bff;
                color: white;
                border-color: #007bff;
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

            .dataTables_wrapper{
                width:600px;
                margin-left:200px;

            }


        .delete-btn {
        background-color: transparent;
        border: none;

        padding: 0; /* Remove padding for a clean look */
    }

    .delete-btn:hover {
        background-color: transparent; /* Ensure no background appears on hover */
    }

    .edit-btn {
        background-color: transparent;
        border: none;
        padding: 0; /* Remove padding */
    }

    .edit-btn:hover {
        background-color: transparent; /* Ensure no background appears on hover */
    }

    .edit-btn, .delete-btn {
        font-size: 20px; /* Increase button font size */
    }
    .edit-btn svg, .delete-btn svg {
        width: 24px; /* Increase icon size */
        height: 24px;
    }

    td img {
    transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
}

td img:hover {
    transform: scale(2); /* Increase size by 100% (2x) */
}

.btn-default {
  background-color: #853ede !important;
  color: white !important;
  border-color: #853ede !important;
}

        </style>


<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<!-- Success Alert -->
@if (session('success'))
<script>
    Swal.fire({
        title: "Success!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonColor: "#007bff",
        confirmButtonText: "OK",
        allowOutsideClick: false,
    });
</script>
@endif

<!-- Error Alert -->
@if ($errors->any())
<script>
    Swal.fire({
        title: "Error!",
        html: "{!! implode('<br>', $errors->all()) !!}",
        icon: "error",
        confirmButtonColor: "#d33",
        confirmButtonText: "OK",
        allowOutsideClick: false,
    });
</script>
@endif


    <div class="row">
        <!-- Form Section -->
        <div class="col-3">
        <h5 style="margin-left:80px; margin-top:20px;"><b>Upload Banner Images</b> </h5>
        <br><br>
            <div class="form-container">
                <form action="{{ route('banner.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="bannerImage">Select Banner Images</label>
                    <div class="form-group">
                        <input type="file" class="form-control" id="bannerImage" name="images[]" accept="image/*" multiple required width="70">
                    </div>
                    <p style="margin-right:20px;margin-bottom:20px;margin-top:-28px;"><b>Note:</b> Banner Size-1250*250.</p>
                    <!-- Button below the form -->
                    <button type="submit" class="btn btn-default" style="width:180px;margin-left:80px;margin-top:40px;">Upload Banners</button>

                </form>
            </div>
        </div>

        <!-- DataTable Section -->
        <div class="col-9">
        <h5 style="margin-left:400px;margin-top:20px;"><b> Manage Banners</b></h5>
        <br>  <br>
            <div class="table-responsive" style=" margin-left:-50px;">
                <table id="productTable" style="width:125%" class="table table-striped table-bordered">
                    <thead class="bg-primary">
                        <tr>
                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Manage Banners</th>
                            <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <!-- Serial Number Column -->
                            <td>{{ $loop->iteration }}</td>

                            <!-- Image Column -->
                            <td style="text-align:center;">
                                <img src="{{ asset('storage/app/public/' . $banner->image_path) }}" class="img-fluid" alt="Banner" style="height: 50px; object-fit: cover; border-radius: 5px; margin-left:40px;">
                            </td>

                            <td>
                                <!-- Edit Button
  <a href="{{ route('banner.edit', $banner->id) }}" class="edit-btn btn-sm">
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="orange" class="bi bi-pencil-square" viewBox="0 0 16 16">
          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
      </svg>
  </a> -->

  <!-- Delete Button -->
  <form action="{{ route('banner.destroy', $banner->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm delete-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="red" class="bi bi-trash3" viewBox="0 0 16 16">
              <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
          </svg>
      </button>
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


@endsection
