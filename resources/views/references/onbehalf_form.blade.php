<!-- Author:Divya
Description:Reference creation
Date:20/03/2025-->


@extends('memberlayout.navbar')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<style>
    .container-wrapper {
        width: 95%;
        max-width: 1500px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: margin-right 0.3s ease-in-out, width 0.3s ease-in-out;
    }

    /* Header */
    .header {
        background: linear-gradient(to right, #1d2b64, #f8cdda);
        color: white;
        padding: 15px;
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        border-radius: 8px;
        margin-bottom: 15px;
    }



    .form-control:focus {
        border-color: #f8cdda;
        box-shadow: 0px 0px 5px rgba(248, 205, 218, 0.7);
    }

    /* Button Styling */
    .btn-primary {
        background-color: #1d2b64;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        transition: 0.3s;
    }

   




/* Hide number input spinners (Chrome, Safari, Edge, Opera) */
input[type="number"]::-webkit-inner-spin-button, 
input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Hide number input spinners (Firefox) */
input[type="number"] {
    -moz-appearance: textfield;
}



.white-background-select {
    background-color: white !important;
    border: 1px solid #ccc  !important;
    padding: 8px  !important;
}


  /* Ensure form fields stack properly on smaller screens */
  @media (max-width: 576px) {
    .container-wrapper {
        padding: 15px;
        margin-top: 40px !important; /* Adjust this value to push the form down */
    }
}


</style>

<div class="container-wrapper mt-5">
    <!-- Header -->
    <div class="header text-center">On Behalf of Reference</div>

    <div class="card shadow-lg">
 

    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-auto text-center" role="alert" style="max-width: 400px;">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

        <!-- Inner Card -->
        <div class="card shadow-sm">
            <div class="card-body" style="background-color: white; border-radius: 10px; padding: 20px;">

           <!-- Form Container -->
<div style="background-color: #d3cce3; border-radius: 10px; padding: 20px;">
    <form action="{{ route('references.storeOnBehalf') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
<!-- Reference Given By -->
<div class="col-md-6">
    <div class="form-group">
        <label for="reference_by">Reference Given By*</label>
        <select name="reference_by" id="reference_by" class="form-control select2-member white-background-select" required>
            <option value="">Select Member</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}"
                        data-photo="{{ asset('storage/profile_photos/' . $member->photo) }}">
                    {{ $member->first_name }} {{ $member->last_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>




            <!-- Reference Given To -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reference_to">Reference Given To*</label>
                    <select name="reference_to" id="reference_to" class="form-control" required>
                        <option value="">Select Member</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Reference Title -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Reference Title*</label>
                    <input type="text" name="title" id="title" class="form-control" required maxlength="25">
                </div>
            </div>

            <!-- Reference Amount -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="amount">Reference Amount*</label>
                    <input type="number" name="amount" id="amount" class="form-control" required min="1" max="999999999999999">
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Date (System Date) -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Date</label>
                    <input type="text" class="form-control" value="{{ now()->format('d/m/Y') }}" readonly>
                </div>
            </div>

            <!-- Reference Image -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Reference Image (Max: 1MB)</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Reference Details -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="details">Reference Details</label>
                    <textarea name="details" id="details" class="form-control" rows="3" maxlength="250" oninput="updateCharCount()"></textarea>
                    <small id="charCount" class="text-muted">You can enter up to 250 characters.</small>    
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit Reference</button>
        </div>
    </form>
</div> <!-- Form container ends -->

            </div>
        </div> <!-- Inner card ends -->

    </div>
</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.getElementById('amount').addEventListener('input', function (e) {
    if (this.value.length > 15) {
        this.value = this.value.slice(0, 15); // Restrict to 15 digits
    }
});
</script>

<script>
document.getElementById("details").addEventListener("input", function () {
    let remaining = 250 - this.value.length;
    document.getElementById("charCount").textContent = "You can enter up to " + remaining + " characters.";
});

</script>

<script>
$(document).ready(function () {
    function formatMember(member) {
        if (!member.id) return member.text;
        const img = $(member.element).data('photo');
        return $(
            `<div style="display: flex; justify-content: space-between; align-items: center;">
                <span>${member.text}</span>
                <img src="${img}" style="width: 30px; height: 30px; border-radius: 50%; margin-left: 10px;">
            </div>`
        );
    }

    $('.select2-member').select2({
        templateResult: formatMember,
        templateSelection: formatMember,
        theme: 'bootstrap4',
        width: '100%'
    });
});
</script>



@endsection
