@extends('admin_layouts.app')
<style>

#success-alert {
    margin: 10px auto;  /* Centers the alert horizontally */
    white-space: nowrap;  /* Ensures that the text does not wrap, if needed */
}

.alert-dismissible .close {
    font-size: 1.5rem;
    color: #000;
}



.swal2-cancel:hover {
        background-color: gray !important;
        border-color: gray !important;
    }

    .testimonial-image {
    width: 50px;
    transition: transform 0.3s ease;  /* Smooth transition for the scaling effect */
}

.testimonial-image:hover {
    transform: scale(2.1);  /* Scale the image to 2.1 times its original size */
    z-index: 10;  /* Ensures the image appears above other elements when scaled */
}


.btn-default {
  background-color: #853ede !important;
  color: white !important;
  border-color: #853ede !important;
}





</style>
@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
    <h2>Add Client Testimonial</h2>

    <!-- @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif


    <div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%;">
        <h2 class="text-center mb-4">Add Client Testimonial</h2>
        
        <form action="{{ route('client_testimonials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name:</label>
                <input type="text" name="name" class="form-control rounded-3 border-1" required placeholder="Enter client name">
            </div>

            <div class="mb-3">
                <label for="message" class="form-label fw-bold">Message:</label>
                <textarea name="message" maxlength="250" class="form-control rounded-3 border-1" rows="4" required placeholder="Enter testimonial..." oninput="updateCharCount()"></textarea>
                <small class="text-muted" id="charCount">250 characters remaining</small>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label fw-bold">Upload Image:</label>
                <input type="file" name="image" class="form-control rounded-3 border-1">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-default px-4 py-2 fw-bold rounded-pill shadow-sm">Submit</button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateCharCount() {
        let textarea = document.querySelector("textarea[name='message']");
        let charCount = document.getElementById("charCount");
        charCount.textContent = (250 - textarea.value.length) + " characters remaining";
    }
</script>

    <div class="container">
    <h2 class="mt-5">Client Testimonials</h2>


<table  id="categoriesTable"  class="table table-hover table-bordered text-center align-middle">
            <thead class="bg-primary">
            <tr>
                  <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                  <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Name</th>
                  <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Message</th>
                  <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Image</th>
                  <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testimonials as $index => $testimonial)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $testimonial->name }}</td>
                    <td>{{ $testimonial->message }}</td>
                    <td>
                    @if($testimonial->image)
                        <img src="{{ asset('storage/app/public/'.$testimonial->image) }}" alt="Client Image" class="testimonial-image" width="50">
                    @else
                        No Image
                    @endif
                </td>
                    <td>
                    <form action="{{ route('client_testimonials.destroy', $testimonial->id) }}" method="POST" style="display:inline;" id="deleteForm-{{ $testimonial->id }}">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $testimonial->id }})">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>


<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(testimonialId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "rgb(144, 49, 212)", // Purple color for Confirm button
            cancelButtonColor: "rgb(144, 49, 212)",  // Default Purple color for Cancel button
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if user confirms
                document.getElementById('deleteForm-' + testimonialId).submit();
            }
        });
    }
</script>

<!-- DataTable Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable for categories
        $('#categoriesTable').DataTable({
            "responsive": true,  // Responsive for mobile
            "pageLength": 10,    // Default rows per page
            "lengthMenu": [10, 25, 50, 100], // Options for rows per page
            "ordering": false,    // Enable sorting
            "searching": true,   // Enable search
            "info": true         // Show table info
        });

        // Checkbox validation: Max 7 categories
        $('.update-category-checkbox').on('change', function() {
            var selectedCount = $('.update-category-checkbox:checked').length;

            if (selectedCount > 7) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'You should not select more than 7 categories!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                this.checked = false; // Uncheck last selected checkbox
            }
        });
    });
</script>

@endsection
