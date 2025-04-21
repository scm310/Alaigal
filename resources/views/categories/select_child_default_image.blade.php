@extends('admin_layouts.app')
<style>
    .container {
        background: #fff;
    }
</style>


@section('content')

<div class="container">
    <h3 class="my-3">Select Default Image for Child Categories(Only For Mobile View)</h3>

    <form action="{{ route('categories.storeChildDefaultImage') }}" method="POST">
        @csrf
        <input type="hidden" name="main_category_id" value="{{ $mainCategory->Category_id }}">
        <input type="hidden" name="sub_category_id" value="{{ $subCategory->id }}">

        <div class="row">
        <div class="col-md-3">
    <label style="display: flex; align-items: center;">
        <input type="radio" name="default_child_image" value="/images/default5.png" required>
        <img src="{{ asset('images/default5.png') }}" class="img-fluid img-thumbnail" style="margin-left: 10px;">
    </label>
</div>

            <div class="col-md-3">
            <label style="display: flex; align-items: center;">
                    <input type="radio" name="default_child_image" value="/images/default6.png">
                    <img src="{{ asset('images/default6.png') }}" class="img-fluid img-thumbnail">
                </label>
            </div>
            <div class="col-md-3">
            <label style="display: flex; align-items: center;">
                    <input type="radio" name="default_child_image" value="/images/default7.png">
                    <img src="{{ asset('images/default7.png') }}" class="img-fluid img-thumbnail">
                </label>
            </div>
            <div class="col-md-3">
            <label style="display: flex; align-items: center;">
                    <input type="radio" name="default_child_image" value="/images/default8.png">
                    <img src="{{ asset('images/default8.png') }}" class="img-fluid img-thumbnail">
                </label>
            </div>
        </div>

        <div class="mt-3"> <!-- Added text-center to center the button -->
            <button type="submit" class="btn btn-primary">Set Default Image</button>
        </div>
    </form>
</div>
@endsection
