<form id="clientForm" action="{{ route('clients.save') }}" method="POST">
    @csrf

    <div id="clientFields">
        @php
            $clients = auth()->user()->clients ?? collect();
        @endphp

        @if($clients->isNotEmpty())
            @foreach($clients as $index => $client)
                <div class="row client-row align-items-center mb-2">
                    <div class="col-md-2">
                        <label>Client Name</label>
                        <input type="text" name="client_name[]" class="form-control"
                               value="{{ old('client_name.'.$index, $client->client_name) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label>Company Name</label>
                        <input type="text" name="company_name[]" class="form-control"
                               value="{{ old('company_name.'.$index, $client->company_name) }}">
                    </div>
                    <div class="col-md-3">
                        <label>Company Full Form</label>
                        <input type="text" name="company_fullform[]" class="form-control"
                               value="{{ old('company_fullform.'.$index, $client->company_fullform) }}">
                    </div>
                    <div class="col-md-3">
                        <label>Client Designation</label>
                        <input type="text" name="designation[]" class="form-control"
                               value="{{ old('designation.'.$index, $client->designation) }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">
                        <button type="button" class="btn btn-danger removeClientBtn"
                        style="border: none; background: none; padding: 2px;">
                        <i class="fa fa-trash-alt"
                            style="font-size: 19px; color: rgb(248, 49, 49);
                           vertical-align: middle;"></i>
                    </button>
                    </div>

                </div>
            @endforeach
        @endif


    @if($clients->isEmpty())
    <div class="row client-row align-items-center mb-2">
        <div class="col-md-2">
            <label>Client Name</label>
            <input type="text" name="client_name[]" class="form-control" placeholder="Client Name" required>
        </div>
        <div class="col-md-3">
            <label>Company Name</label>
            <input type="text" name="company_name[]" class="form-control" placeholder="Company Name">
        </div>
        <div class="col-md-3">
            <label>Company Full Form</label>
            <input type="text" name="company_fullform[]" class="form-control" placeholder="Company Full Form">
        </div>
        <div class="col-md-3">
            <label>Client Designation</label>
            <input type="text" name="designation[]" class="form-control" placeholder="Designation">
        </div>

    </div>
    @endif
    </div>
    <button type="button" id="addClientBtn" class="btn btn-secondary mt-3">
        <i class="fa fa-plus"></i> Add More
    </button>
    <button type="submit" class="btn btn-primary mt-3" id="nextTab">Save and Next</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const maxClients = 10;
    const clientContainer = document.getElementById("clientFields");
    const addClientBtn = document.getElementById("addClientBtn");



    addClientBtn.addEventListener("click", function () {
        const totalClients = document.querySelectorAll(".client-row").length;


            const newClientRow = document.createElement("div");
            newClientRow.classList.add("row", "client-row", "align-items-center", "mb-2");
            newClientRow.innerHTML = `
                <div class="col-md-2">
                    <label>Client Name</label>
                    <input type="text" name="client_name[]" class="form-control" placeholder="Client Name" required>
                </div>
                <div class="col-md-3">
                    <label>Company Name</label>
                    <input type="text" name="company_name[]" class="form-control" placeholder="Company Name">
                </div>
                <div class="col-md-3">
                    <label>Company Full Form</label>
                    <input type="text" name="company_fullform[]" class="form-control" placeholder="Company Full Form">
                </div>
                <div class="col-md-3">
                    <label>Client Designation</label>
                    <input type="text" name="designation[]" class="form-control" placeholder="Designation">
                </div>
                <div class="col-md-1 d-flex align-items-center justify-content-center mt-4">

                    <button type="button" class="btn btn-danger removeClientBtn"
                            style="border: none; background: none; padding: 2px;">
                            <i class="fa fa-trash-alt"
                                style="font-size: 19px; color: rgb(248, 49, 49);
                               vertical-align: middle;"></i>
                        </button>
                </div>
            `;
            clientContainer.appendChild(newClientRow);
            updateButtonState();

    });

    // ✅ Fix: Use event delegation to handle dynamically added elements
    document.addEventListener("click", function (event) {
        if (event.target.closest(".removeClientBtn")) {
            event.target.closest(".client-row").remove();
            updateButtonState();
        }
    });

    updateButtonState();
});

</script>

<style>
    label {
        font-size: 12px;
    }
</style>
