@extends('admin_layouts.app')

@section('content')
<style>
    
    .invalid-feedback {
    display: none;
    color: red;
}


.position-absolute {
    position: absolute;
}

.top-0 {
    top: 0;
}

.end-0 {
    right: 0;
}

.p-2 {
    padding: 0.5rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}
</style>


<div class="col-xl">
    <div class="card mb-4">
    <div class="card-header">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

         

            <div class="d-flex justify-content-between align-items-center position-relative">
            <h5 class="header-margin">Manage Users</h5>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="ti-plus"></i> Create New User
                </button>
                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                    <i class="ti-plus"></i> Create New Role
                </button> -->
            </div>
            <div id="userCardsContainer">
    <div class="row">
        @foreach($users as $user)
        <div class="col-md-4 mb-4" id="user-card-{{ $user->id }}">
            <div class="card h-100 position-relative">
                <div class="position-absolute top-0 end-0 p-2">
                    <button class="btn btn-danger btn-delete btn-sm" data-user-id="{{ $user->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">User Details</h5>
                    @if($user->profile_pic)
                    <img src="{{ asset('storage/app/public/' . $user->profile_pic) }}" alt="{{ $user->username }}" style="width: 100px; height: 100px; border-radius: 50%;">
                    @else
                    <img src="/admin_assets/assets/img/faces/profile/profile-pic.png" alt="Profile_pic" style="width: 100px; height: 100px; border-radius: 50%;">
                    @endif
                    <p class="card-text">Name: {{ $user->name }}</p>
                    <p class="card-text">Email: {{ $user->email }}</p>
                    <p class="card-text">Role: {{ $user->role->role }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>



 

        </div>
    </div>
</div>

<!-- Create New User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg class for larger modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="username" class="form-label">Name</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="row">
                    <div class="mb-3 col-md-6">
    <label for="password" class="form-label">Password</label>
    <div class="input-group">
        <input type="password" class="form-control" id="password" name="password" minlength="6" required>
        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
            <i class="fa fa-eye"></i>
        </button>
        <div class="invalid-feedback" id="passwordError">Password must be at least 6 characters long.</div>
    </div>
</div>

                       <div class="mb-3 col-md-6">
    <label for="profile_picture" class="form-label">Profile Picture</label>
    <small class="form-text text-muted">Accepted formats: jpeg, png, jpg</small>
    <input type="file" class="form-control" id="profile_pic" name="profile_picture">
    <div class="invalid-feedback" id="fileError" style="display: none;">Please upload a file in jpeg, jpg, or png format.</div>
</div>

                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" onchange="setRoleId()" required>
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="role_id" name="role_id">
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Create New Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('role.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="role_name" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="role_name" name="role_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Role ID setting function
    function setRoleId() {
        var selectedOption = document.getElementById('role').options[document.getElementById('role').selectedIndex];
        var roleId = selectedOption.value;
        document.getElementById('role_id').value = roleId;
    }

    // Add change event listener to role select element
    document.getElementById('role').addEventListener('change', setRoleId);

    // File validation function
    const profilePicInput = document.getElementById("profile_pic");
    const fileError = document.getElementById("fileError");

    profilePicInput.addEventListener("change", function() {
        const allowedExtensions = ["jpeg", "jpg", "png"];
        const fileExtension = profilePicInput.value.split('.').pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            fileError.style.display = "block";
            fileError.textContent = "Please upload a file in jpeg, jpg, or png format.";
            profilePicInput.value = ""; // Clear the input
        } else {
            fileError.style.display = "none";
        }
    });

    // Prevent form submission if file format is invalid
    const form = document.querySelector("form");
    form.addEventListener("submit", function(event) {
        if (profilePicInput.value && fileError.style.display === "block") {
            event.preventDefault();
            
        } else {
            // Show SweetAlert loading message
            Swal.fire({
                title: 'Sending Email',
                text: 'Please wait...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
    });
});

    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passwordInput = document.getElementById('password');
        const passwordIcon = e.target;

        // Toggle the type attribute
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle the eye / eye-slash icon
        passwordIcon.classList.toggle('fa-eye');
        passwordIcon.classList.toggle('fa-eye-slash');
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.btn-delete').click(function() {
        if (confirm('Are you sure you want to delete this user?')) {
            var userId = $(this).data('user-id');
            var card = $('#user-card-' + userId);
            
            $.ajax({
                url: '/users/' + userId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        card.remove();
                        alert('User deleted successfully.');
                    } else {
                        alert('Error deleting user.');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });
});
</script>



@endsection