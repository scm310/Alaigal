<form id="serviceForm" action="{{ route('services.save') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div id="serviceFields">
        @php
            $services = auth()->user()->services ?? collect();
        @endphp

        @if($services->isNotEmpty())
            @foreach($services as $index => $service)
            <div class="row service-row align-items-center mb-2">
                <div class="col-md-4">
                    <label>Service Name</label>
                    <input type="text" name="service_name[]" class="form-control"
                           value="{{ old('service_name.'.$index, $service->service_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label>Service Image</label>
                    <input type="file" name="service_image[]" class="form-control">

                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">
                    @if ($service->service_image)
                    <img src="{{ asset('storage/app/public/' . $service->service_image) }}"
                        alt="{{ $service->service_image }}" class="img-thumbnail mt-2 zoom-image" width="100">
                @endif
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">
                    <button type="button" class="btn btn-danger removeServiceBtn"
                            style="border: none; background: none; padding: 2px;">
                        <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
                    </button>
                </div>
            </div>
            @endforeach


@else
    <!-- Default Empty Row -->
    <div class="row service-row align-items-center mb-2">
        <div class="col-md-4">
            <label>Service Name</label>
            <input type="text" name="service_name[]" class="form-control" placeholder="Service Name" required>
        </div>
        <div class="col-md-4">
            <label>Service Image</label>
            <input type="file" name="service_image[]" class="form-control">
        </div>

    </div>
@endif

</div>
    <!-- Add More Button -->
    <button type="button" id="addServiceBtn" class="btn btn-secondary mt-3">
        <i class="fa fa-plus"></i> Add More
    </button>

    <!-- Save and Next Button -->
    <button type="submit" class="btn btn-primary mt-3" id="nextTab">Save and Next</button>
</form>

<!-- JavaScript for Adding & Removing Services & Tab Navigation -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const maxServices = 3;
    const serviceContainer = document.getElementById("serviceFields");
    const addServiceBtn = document.getElementById("addServiceBtn");



    addServiceBtn.addEventListener("click", function () {
        const totalServices = document.querySelectorAll(".service-row").length;


            const newServiceRow = document.createElement("div");
            newServiceRow.classList.add("row", "service-row", "align-items-center", "mb-2");
            newServiceRow.innerHTML = `
                <div class="col-md-4">
                    <label>Service Name</label>
                    <input type="text" name="service_name[]" class="form-control" placeholder="Service Name" required>
                </div>
                <div class="col-md-4">
                    <label>Service Image</label>
                    <input type="file" name="service_image[]" class="form-control">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">
                    <button type="button" class="btn btn-danger removeServiceBtn"
                            style="border: none; background: none; padding: 2px;">
                        <i class="fa fa-trash-alt" style="font-size: 19px; color: rgb(248, 49, 49);"></i>
                    </button>
                </div>
            `;
            serviceContainer.appendChild(newServiceRow);
            updateButtonState();

    });

    serviceContainer.addEventListener("click", function (event) {
        if (event.target.closest(".removeServiceBtn")) {
            event.target.closest(".service-row").remove();
            updateButtonState();
        }
    });

    updateButtonState();

    // Save and Navigate to Clients Tab
    document.getElementById("saveAndNextService").addEventListener("click", function (event) {
        event.preventDefault(); // Prevent default form submission

        let form = document.getElementById("serviceForm");
        let formData = new FormData(form);

        fetch("{{ route('services.save') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector("#clients-tab").click(); // Move to the Clients tab
            } else {
                alert("Error saving service. Please try again.");
            }
        })
        .catch(error => console.error("Error:", error));
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Check if there's a nextTab in session
    let nextTab = "{{ session('nextTab') }}";
    if (nextTab) {
        document.querySelector(nextTab + "-tab").click(); // Move to the next tab
    }
});
</script>

