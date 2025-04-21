@extends('admin_layouts.app')
<style>
    .container {
        background: #fff;
    }
</style>
@section('content')
<div class="container">
    <h2>Select Default Image for Subcategories(Only For Mobile View)</h2>

    <form action="{{ route('categories.storeDefaultImage') }}" method="POST">
        @csrf
        <div class="row">
            <input type="hidden" name="main_category_id" value="{{ $mainCategory->Category_id }}">

            <div class="col-md-3">
            <label style="display: flex; align-items: center;">
                    <input type="radio" name="default_image" value="/images/default1.png" required>
                    <img src="{{ asset('images/default1.png') }}" class="img-fluid img-thumbnail">
                </label>
            </div>

            <div class="col-md-3">
            <label style="display: flex; align-items: center;">
                    <input type="radio" name="default_image" value="/images/default2.png">
                    <img src="{{ asset('images/default2.png') }}" class="img-fluid img-thumbnail">
                </label>
            </div>

            <div class="col-md-3">
            <label style="display: flex; align-items: center;">
                    <input type="radio" name="default_image" value="/images/default3.png">
                    <img src="{{ asset('images/default3.png') }}" class="img-fluid img-thumbnail">
                </label>
            </div>

            <div class="col-md-3">
            <label style="display: flex; align-items: center;">
                    <input type="radio" name="default_image" value="/images/default4.png">
                    <img src="{{ asset('images/default4.png') }}" class="img-fluid img-thumbnail">
                </label>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Set Default Image</button>
        </div>
    </form>
</div>
@endsection
