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
<div class="container mt-5">
    <div class="card shadow-lg p-4">
<div class="tab-content" id="bannerTabContent">
    <!-- Homepage Banner Tab -->
    <div class="tab-pane fade show active" id="homebanner" role="tabpanel" aria-labelledby="homebanner-tab">
    <div class="d-flex justify-content-center mt-4">
    <div class="card shadow-lg p-4 border-0" style="width: 450px; background: #f9f9f9; border-radius: 12px;">
        <h5 class="text-center fw-bold mb-3">Upload Homepage Banners</h5>
        
        <form action="{{ route('homepagebanners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Image Upload Field --}}
            <div class="mb-3">
                <label for="bannerImage" class="form-label fw-bold">Select Banner Image</label>
                <input type="file" class="form-control border-primary shadow-sm" id="bannerImage" name="image" 
                       accept="image/*" required>
            </div>

            {{-- Note --}}
            <small>Note: Banner size should be <strong>1116x150 </strong> pixels.</small>

            {{-- Submit Button --}}
            <div class="text-center mt-3">
    <button type="submit"class="btn btn-default w-50 fw-bold">
        <i class="fas fa-upload me-2"></i> Upload Banner
    </button>
</div>

        </form>
    </div>
</div>


        <div class="col-12 mt-3">
            <h5 class="text-center"><b>Manage Homepage Banners</b></h5>
            <div class="table-responsive">
                <table id="bannerTable" class="table table-striped table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">S.No</th>
                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Banner</th>
                        <th scope="col" style="color:white;font-size:medium;text-align:center;text-transform:capitalize;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
    <img src="{{ asset('storage/app/public/' . $banner->image_path) }}" 
         class="img-fluid banner-img" 
         alt="Banner" 
         style="height: 50px; object-fit: cover; border-radius: 5px;">
</td>

                            <td class="text-center">
                               
                                <form action="{{ route('homepagebanners.destroy', $banner->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
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


<!-- DataTable Dependencies -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable for categories
        $('#bannerTable').DataTable({
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