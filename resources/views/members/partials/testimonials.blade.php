
<style>
    .mt-4n, .my-4n {
    margin-top: 1.9rem !important;
}
.mt-5n,.my-5n{
    margin-top: 4rem !important;
}
</style>

<form id="testimonialForm" action="{{ route('testimonials.save') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div id="testimonialFields">
        @php
            $testimonials = auth()->user()->testimonials ?? [];
        @endphp


        @if ($testimonials->isNotEmpty())

            @foreach ($testimonials as $index => $testimonial)
                <div  class="row testimonial-row  ">
                    <div class="col-md-3">
                        <label>Client Name</label>
                        <input type="text" name="client_name[]" class="form-control"
                            value="{{ old('client_name.' . $index, $testimonial->client_name) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label>Company Name</label>
                        <input type="text" name="company_name[]" class="form-control"
                            value="{{ old('company_name.' . $index, $testimonial->company_name) }}">
                    </div>

                    <div class="col-md-3">
                        <label>Image</label>
                        <input type="file" name="testimonial_image[]" class="form-control">

                    </div>
                    <div class="col-md-3">
                        <label>Designation</label>
                        <input type="text" name="designation[]" class="form-control"
                            value="{{ old('designation.' . $index, $testimonial->designation) }}">

                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Content</label>
                        <textarea name="content[]" class="form-control" rows="4" maxlength="250">{{ old('content.' . $index, $testimonial->content) }}</textarea>
                    </div>

                <div class="col-md-2 mt-4n text-center ">
                    @if ($testimonial->testimonial_image)
                    <img src="{{ asset('storage/app/public/' . $testimonial->testimonial_image) }}"
                        alt="{{ $testimonial->client_name }}" class="img-thumbnail mt-2" width="80">
                @endif
            </div>
                    <div class="col-md-1 mt-5n text-center ">
                        <button type="button" class="btn btn-danger removeTestimonialBtn"
                            style="border: none; background: none; padding: 2px;">
                            <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
                        </button>
                    </div>
                    <div class="col-md-3 mt-5 text-center "></div>
                </div>
            @endforeach
        @else
            <!-- Default Empty Row -->
            <div class="row testimonial-row align-items-center mb-2">
                <div class="col-md-3">
                    <label>Client Name</label>
                    <input type="text" name="client_name[]" class="form-control" placeholder="Client Name" required>
                </div>
                <div class="col-md-3">
                    <label>Company Name</label>
                    <input type="text" name="company_name[]" class="form-control" placeholder="Company Name">
                </div>

                <div class="col-md-3">
                    <label>Image</label>
                    <input type="file" name="testimonial_image[]" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Designation</label>
                    <input type="text" name="designation[]" class="form-control" placeholder="Designation">
                </div>
                <div class="col-md-6 mt-2">
                    <label>Content</label>
                    <textarea name="content[]" class="form-control"  placeholder="Write testimonial..." rows="4" maxlength="250"></textarea>
                </div>

            </div>
        @endif
    </div>
    <!-- Add More Button -->
    <button type="button" id="addTestimonialBtn" class="btn btn-secondary mt-3">
        <i class="fa fa-plus"></i> Add More
    </button>

    <!-- Save and Next Button -->
    <button type="submit" class="btn btn-primary mt-3" id="nextTab">Save and Next</button>
</form>

<!-- JavaScript for Adding & Removing Testimonials & Tab Navigation -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const maxTestimonials = 3;
        const testimonialContainer = document.getElementById("testimonialFields");
        const addTestimonialBtn = document.getElementById("addTestimonialBtn");



        addTestimonialBtn.addEventListener("click", function() {
            const totalTestimonials = document.querySelectorAll(".testimonial-row").length;


                const newTestimonialRow = document.createElement("div");
                newTestimonialRow.classList.add("row", "testimonial-row", "align-items-center", "mb-2");
                newTestimonialRow.innerHTML = `
                <div class="col-md-3">
                    <label>Client Name</label>
                    <input type="text" name="client_name[]" class="form-control" placeholder="Client Name" required>
                </div>
                <div class="col-md-3">
                    <label>Company Name</label>
                    <input type="text" name="company_name[]" class="form-control" placeholder="Company Name">
                </div>

                <div class="col-md-3">
                    <label>Image</label>
                    <input type="file" name="testimonial_image[]" class="form-control">
                </div>
                 <div class="col-md-3">
                    <label>Designation</label>
                    <input type="text" name="designation[]" class="form-control" placeholder="Designation">
                </div>
                <div class="col-md-6 mt-2">
                    <label>Content</label>
                    <textarea name="content[]" class="form-control" placeholder="Write testimonial..." rows="4" maxlength="250"></textarea>
                </div>
                <div class="col-md-2"></div>
                 <div class="col-md-1 mt-5n text-center ">
                        <button type="button" class="btn btn-danger removeTestimonialBtn"
                            style="border: none; background: none; padding: 2px;">
                            <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
                        </button>
                    </div>
                    <div class="col-md-3 mt-5 text-center "></div>
            `;
                testimonialContainer.appendChild(newTestimonialRow);
                updateButtonState();

        });

        testimonialContainer.addEventListener("click", function(event) {
            if (event.target.closest(".removeTestimonialBtn")) {
                event.target.closest(".testimonial-row").remove();
                updateButtonState();
            }
        });

        updateButtonState();

        // Save and Navigate to Projects Tab
        document.getElementById("saveAndNextTestimonial").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent default form submission

            let form = document.getElementById("testimonialForm");
            let formData = new FormData(form);

            fetch("{{ route('testimonials.save') }}", {
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
                        document.querySelector("#projects-tab").click(); // Move to the Projects tab
                    } else {
                        alert("Error saving testimonials. Please try again.");
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
