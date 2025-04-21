@extends('admin_layouts.app')

@section('content')

<style>
    .footer {
    background-color: #f8f9fa;
    padding: 1rem 0;
    margin-top:95px;
}
</style>

<div class="col-xl">
    <div class="card mb-2 m-3 p-3">
        <div class="card-header">
            <h4><b>Update Footer Settings</b>
            <a href="{{ url()->previous() }}" class="btn btn-secondary rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
        </h4>







            <!-- Reduced container width -->
            @if(session('success'))
            <div class="alert alert-success mx-auto" id="successMessage" style="max-width: 400px;">
                {{ session('success') }}
            </div>
            @endif



            <div class="card-body">
                <form action="{{ route('footer.update') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control form-control-sm" id="title" name="title" value="{{ old('title', $footerSetting->title) }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="address1">Address 1</label>
                            <input type="text" class="form-control form-control-sm" id="address1" name="address1" value="{{ old('address1', $footerSetting->address1) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="address2">Address 2</label>
                            <input type="text" class="form-control form-control-sm" id="address2" name="address2" value="{{ old('address2', $footerSetting->address2) }}">
                        </div>
                        <!--<div class="col-md-6 form-group">-->
                        <!--    <label for="privacy_policy">Privacy Policy</label>-->
                        <!--    <input type="text" class="form-control form-control-sm" id="privacy_policy" name="privacy_policy" value="{{ old('privacy_policy', $footerSetting->privacy_policy) }}">-->
                        <!--</div>-->
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="facebook_url">Facebook</label>
                            <input type="url" class="form-control form-control-sm" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $footerSetting->facebook_url) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="twitter_url">Twitter</label>
                            <input type="url" class="form-control form-control-sm" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $footerSetting->twitter_url) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="instagram_url">Instagram</label>
                            <input type="url" class="form-control form-control-sm" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $footerSetting->instagram_url) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="color_code">Color Code</label>
                            <div class="d-flex">
                                <input type="color" id="color_picker" name="color_code" class="form-control form-control-sm" value="{{ old('color_code', $footerSetting->color_code) }}">
                                <input type="text" id="color_code" name="color_code" class="form-control form-control-sm ms-2" value="{{ old('color_code', $footerSetting->color_code) }}" placeholder="Enter color code">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="copyright_text">Copyright Text</label>
                            <input type="text" class="form-control form-control-sm" id="copyright_text" name="copyright_text" value="{{ old('copyright_text', $footerSetting->copyright_text) }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="design_by">Design By</label>
                            <input type="text" class="form-control form-control-sm" id="design_by" name="design_by" value="{{ old('design_by', $footerSetting->design_by) }}">
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>












        </div>
    </div>
</div>

@if(session('success'))
<script>
    setTimeout(function() {
        document.getElementById('successMessage').style.display = 'none';
    }, 3000);
</script>
@endif

<script>
    document.getElementById('color_picker').addEventListener('input', function() {
        document.getElementById('color_code').value = this.value;
    });
    document.getElementById('color_code').addEventListener('input', function() {
        document.getElementById('color_picker').value = this.value;
    });
</script>

@endsection