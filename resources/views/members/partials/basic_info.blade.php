<form id="basicInfoForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Basic Information Section -->
    <div class="row">
        <div class="col-md-4">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', auth()->user()->first_name) }}" required>
        </div>

        <div class="col-md-4">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', auth()->user()->last_name) }}" required>
        </div>

        <div class="col-md-4">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required readonly>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}" required>
        </div>

        <div class="col-md-4">
            <label>Mobile Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', auth()->user()->phone_number) }}" required maxlength="10"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <div class="col-md-4">
            <label>Pincode</label>
            <input type="text" name="pincode" class="form-control" value="{{ old('pincode', auth()->user()->pincode) }}" required maxlength="6"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>State</label>
            <input type="text" name="state" class="form-control" value="{{ old('state', auth()->user()->state) }}" required>
        </div>

        <div class="col-md-4">
            <label>City</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', auth()->user()->city) }}" required>
        </div>

        <div class="col-md-4">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', auth()->user()->company_name) }}">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>Industry</label>
            <input type="text" name="industry" class="form-control" value="{{ old('industry', auth()->user()->industry) }}" required>
        </div>

        <div class="col-md-4">
            <label>Website</label>
            <input type="text" name="website" class="form-control" value="{{ old('website', auth()->user()->website) }}">
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>Profile Photo</label>
            <input type="file" name="profile_photo"  class="form-control" {{ auth()->user()->profile_photo ? '' : 'required' }}>
        </div>

        <div class="col-md-4">
            <label>Designation</label>
            <input type="text" name="designation" class="form-control" value="{{ old('designation', auth()->user()->designation) }}" required>
        </div>
    </div>
    <br>


    <button type="submit" class="btn btn-primary">Save and Next</button>
</form>



<script>
document.addEventListener("DOMContentLoaded", function () {
    // Check if Laravel flash session has 'nextTab'
    let nextTab = "{{ session('nextTab') }}";

    if (nextTab) {
        let nextTabElement = document.querySelector(`a[href="${nextTab}"]`) || document.querySelector(`a[data-bs-target="${nextTab}"]`);

        if (nextTabElement) {
            let bootstrapTab = new bootstrap.Tab(nextTabElement);
            bootstrapTab.show();
        }
    }
});
</script>


<!-- JavaScript for Tab Navigation -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("saveAndNextBasic").addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default form submission

        let form = document.getElementById("basicInfoForm");
        let formData = new FormData(form);

        fetch("{{ route('profile.update') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(() => {
            // Read nextTab from Laravel session
            let nextTab = "{{ session('nextTab') }}";
            if (nextTab) {
                let nextTabElement = document.querySelector(`a[href="${nextTab}"]`) || document.querySelector(`a[data-bs-target="${nextTab}"]`);

                if (nextTabElement) {
                    let bootstrapTab = new bootstrap.Tab(nextTabElement);
                    bootstrapTab.show();
                }
            }
        })
        .catch(error => console.error("Error:", error));
    });
});
</script>



