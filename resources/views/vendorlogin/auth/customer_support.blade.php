@extends('vendor_layouts.app')

@section('content1')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert Library -->

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
        }
        .support-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 25px;
            background: linear-gradient(to top, #fff1eb 0%, #ace0f9 100%);
            border-radius: 10px;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            height:400px;
        }
        .support-container h3 {
            color: #333;
            margin-bottom: 20px;
            font-size:20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        input, textarea {
            width: 100%;
            padding:11px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

         .submit{
            width:30%;
            padding:8px;
            background-color:rgb(177, 96, 248);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }
       
    </style>

<div class="support-container">
    <h3>Contact Customer Support</h3>
    <form id="supportForm" method="POST" action="{{ route('support.store') }}">
        @csrf  <!-- Laravel CSRF Token -->

        <div class="form-group">
            <input type="text" name="name" value="{{ Auth::guard('vendor')->user()->name }}" readonly>
        </div>

        <div class="form-group">
            <input type="email" name="email" value="{{ Auth::guard('vendor')->user()->email }}" readonly>
        </div>

        <div class="form-group">
            <textarea name="message" placeholder="Your Message" rows="4" maxlength="250" required></textarea>
        </div>

        <button type="submit" class="submit">Submit</button>
    </form>
</div>


    <script>
    @if(session('success'))
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK",
            customClass: {
                confirmButton: 'custom-swal-button'
            }
        });
    @endif
</script>

<style>
    .custom-swal-button {
    background-color:rgb(177, 96, 248) !important; /* Green success color */
    color: white !important;
    font-weight: bold;
    border-radius: 5px;
    padding: 10px 20px;
    border: none;
    transition: 0.3s;
   width: auto;
}

</style>
@endsection
