<style>
    .mt-4n,
    .my-4n {
        margin-top: 1.9rem !important;
    }

    .mt-5n,
    .my-5n {
        margin-top: 4rem !important;
    }
</style>

<form id="projectsForm" action="{{ route('projects.save') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div id="projectFields">
        @php
            $projects = auth()->user()->completedProjects ?? [];

        @endphp

        @if ($projects->isNotEmpty())

            @foreach ($projects as $index => $project)
                <div class="row project-row  mb-2">
                    <div class="col-md-3">
                        <label>Project Name</label>
                        <input type="text" name="project_name[]" class="form-control"
                            value="{{ old('project_name.' . $index, $project->project_name) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label>Project Image</label>
                        <input type="file" name="project_image[]" class="form-control">

                    </div>

                    <div class="col-md-3">
                        <label>Location</label>
                        <input type="text" name="location[]" class="form-control"
                            value="{{ old('location.' . $index, $project->location) }}">
                    </div>
                    <div class="col-md-3">
                        <label>Client Name</label>
                        <input type="text" name="client_name[]" class="form-control"
                            value="{{ old('client_name.' . $index, $project->client_name) }}">



                    </div>
                    <div class="col-md-3">
                        <label>company Name</label>
                        <input type="text" name="company_name[]" class="form-control" placeholder="Company Name"
                            value="{{ old('company_name.' . $index, $project->company_name) }}">
                    </div>
                 
                    <div class="col-md-2 text-center">
                        @if ($project->project_image)
                            <img src="{{ asset('storage/app/public/' . $project->project_image) }}"
                                alt="{{ $project->project_image }}" class="img-thumbnail mt-2 " width="80">
                        @endif
                    </div>
                    <div class="col-md-1 mt-4n text-center">
                        <button type="button" class="btn btn-danger removeProjectBtn"
                            style="border: none; background: none; padding: 2px;">
                            <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
                        </button>
                    </div>

                    <div class="col-md-6 ">

                    </div>
                </div>
            @endforeach
        @else
            <!-- Default Empty Row -->
            <div class="row project-row  mb-2">
                <div class="col-md-3">
                    <label>Project Name</label>
                    <input type="text" name="project_name[]" class="form-control" placeholder="Project Name"
                        required>


                </div>
                <div class="col-md-3">
                    <label>Project Image</label>
                    <input type="file" name="project_image[]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Location</label>
                    <input type="text" name="location[]" class="form-control" placeholder="Location">
                </div>
                <div class="col-md-3">
                    <label>Client Name</label>
                    <input type="text" name="client_name[]" class="form-control" placeholder="Client Name">
                </div>
                <div class="col-md-3">
                    <label>company Name</label>
                    <input type="text" name="company_name[]" class="form-control" placeholder="Company Name">

                </div>


            </div>



        @endif
    </div>
    <!-- Add More Button -->
    <button type="button" id="addProjectBtn" class="btn btn-secondary mt-3">
        <i class="fa fa-plus"></i> Add More
    </button>

    <!-- Save and Update Profile Button -->
    <button type="submit" class="btn btn-primary mt-3" id="nextTab">Save and Update Profile</button>
</form>

<!-- JavaScript for Adding & Removing Projects & Profile Update -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const maxProjects = 3;
        const projectContainer = document.getElementById("projectFields");
        const addProjectBtn = document.getElementById("addProjectBtn");



        addProjectBtn.addEventListener("click", function() {
            const totalProjects = document.querySelectorAll(".project-row").length;


                const newProjectRow = document.createElement("div");
                newProjectRow.classList.add("row", "project-row", "mb-2");
                newProjectRow.innerHTML = `
                <div class="col-md-3">
                    <label>Project Name</label>
                    <input type="text" name="project_name[]" class="form-control" placeholder="Project Name" required>

                </div>
                    <div class="col-md-3">
                    <label>Project Image</label>
                    <input type="file" name="project_image[]" class="form-control">
                </div>

                <div class="col-md-3">
                    <label>Location</label>
                    <input type="text" name="location[]" class="form-control" placeholder="Location">
                </div>
                <div class="col-md-3">
                    <label>Client Name</label>
                    <input type="text" name="client_name[]" class="form-control " placeholder="Client Name">

                </div>

                <div class="col-md-3">
                    <label>company Name</label>
                    <input type="text" name="company_name[]" class="form-control" placeholder="Company Name">
                 </div>
              


                 <div class="col-md-2">

                    </div>
                    <div class="col-md-1 mt-4n text-center">
                       <button type="button" class="btn btn-danger removeProjectBtn mt-4 " style="border: none; background: none; padding: 2px;">
                        <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
                    </button>
                    </div>

                    <div class="col-md-6 ">

                    </div>

            `;
                projectContainer.appendChild(newProjectRow);
                updateButtonState();
         
        });

        projectContainer.addEventListener("click", function(event) {
            if (event.target.closest(".removeProjectBtn")) {
                event.target.closest(".project-row").remove();
                updateButtonState();
            }
        });

        updateButtonState();

        // Save and Update Profile
        document.getElementById("saveAndUpdateProfile").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission

            let form = document.getElementById("projectForm");
            let formData = new FormData(form);

            fetch("{{ route('projects.save') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update profile_update column in the database
                        fetch("{{ route('profile.update') }}", {
                                method: "PUT",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute("content"),
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({

                                })
                            })
                            .then(response => response.json())
                            .then(updateData => {
                                if (updateData.success) {
                                    Swal.fire({
                                        title: "Profile Updated!",
                                        text: "Your profile has been successfully updated.",
                                        icon: "success",
                                        confirmButtonText: "OK"
                                    }).then(() => {
                                        location.reload(); // Refresh the page
                                    });
                                } else {
                                    alert("Error updating profile. Please try again.");
                                }
                            });
                    } else {
                        alert("Error saving projects. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let nextTab = "{{ session('nextTab') }}";
        if (nextTab) {
            document.querySelector(`${nextTab}-tab`).click();
        }
    });
</script>
