@extends('admin_layouts.app')
<style>

.banner-img {
    transition: transform 0.3s ease-in-out;
}

.banner-img:hover {
    transform: scale(2.1); /* Slight zoom on hover */
}

.btn-default {
  background-color: #853ede !important;
  color: white !important;
  border-color: #853ede !important;
}


</style>

@section('content')
<div class="container">
    <h2>Manage Listing Banners</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Banner Form (Create & Edit) --}}
    <div class="card mb-4">
        <div class="card-header">
            <h4>{{ isset($editBanner) ? 'Edit Banner' : 'Add New Banner' }}</h4>
        </div>
        <div class="card-body">
        <form action="{{ isset($editBanner) ? route('listingbanners.update', $editBanner->id) : route('listingbanners.store') }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($editBanner))
        @method('PUT')
    @endif

                <div class="mb-3">
                    <label class="form-label">Banner Image:</label>
                    <input type="file" class="form-control" name="banner_image" {{ isset($editBanner) ? '' : 'required' }}>
                    @if(isset($editBanner) && $editBanner->banner_image)
                        <img src="{{ asset('storage/' . $editBanner->banner_image) }}" width="100" class="mt-2">
                    @endif
                </div>
                <div class="mb-3  text-muted">
            <small>Note: Banner size should be <strong> 831x120</strong> pixels.</small>
        </div>

                <div class="mb-3">
                    <label class="form-label">Category:</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->Category_id }}">{{ $category->Category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"  class="btn btn-default">
                    {{ isset($editBanner) ? 'Update Banner' : 'Create Banner' }}
                </button>

                @if(isset($editBanner))
                    <a href="{{ route('listingbanners.index') }}" class="btn btn-secondary">Cancel</a>
                @endif
            </form>
        </div>
    </div>

    {{-- Listing Table --}}
    <div class="card">
        <div class="card-header">
            <h4>Listing Banners</h4>
        </div>
        <div class="card-body">
        <table id="categoriesTable" class="table table-striped table-bordered mt-4 pt-4" style="width: 100%;">
            <thead class="bg-primary">
                    <tr>
                       <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                       <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Banner Image</th>
                       <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Category</th>
                       <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $index => $banner)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
    <img src="{{ asset('storage/app/public/' . $banner->banner_image) }}" 
         alt="Banner" 
         width="100" 
         class="banner-img">
</td>

                            <td>{{ $banner->category ? $banner->category->Category_name : 'N/A' }}</td>


                            <td>
                                <!-- <a href="{{ route('listingbanners.index', ['edit_id' => $banner->id]) }}" 
                                    class="btn btn-warning btn-sm">Edit</a> -->

                                <form action="{{ route('listingbanners.destroy', $banner->id) }}" 
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Are you sure you want to delete this banner?');">
                                        <i class="fas fa-trash me-2"></i> 
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
