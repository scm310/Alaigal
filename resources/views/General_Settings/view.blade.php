
@extends('admin_layouts.app')
<style>
    /* Example styles for footer */
footer {
    color: white;
    font-size: 14px;
}

.footer-container {
    display: flex;
    justify-content: space-between;
}

.footer-left, .footer-right {
    width: 45%;
}

.footer-right {
    text-align: right;
}

.social-media a {
    margin-right: 15px;
    color: white;
}

.social-media a:hover {
    text-decoration: underline;
}

.footer-bottom {
    margin-top: 20px;
    font-size: 12px;
}

</style>
@section('content')
<!-- footer.blade.php -->
<!-- footer.blade.php -->
<footer style="background-color: {{ $footerSetting->color_code }}; padding: 20px;">
    <div class="footer-container" style="display: flex; justify-content: space-between;">
        <!-- Left Section -->
        <div class="footer-left">
            <h3>{{ $footerSetting->title }}</h3>
            <p>{{ $footerSetting->address1 }}</p>
            <p>{{ $footerSetting->address2 }}</p>
        </div>

        <!-- Right Section -->
        <div class="footer-right">
            <div class="social-media">
                <a href="{{ $footerSetting->facebook_url }}" target="_blank">Facebook</a>
                <a href="{{ $footerSetting->twitter_url }}" target="_blank">Twitter</a>
                <a href="{{ $footerSetting->instagram_url }}" target="_blank">Instagram</a>
            </div>

            <div class="privacy-policy">
                <a href="{{ $footerSetting->privacy_policy }}" target="_blank">Privacy Policy</a>
            </div>
        </div>
    </div>

    <div class="footer-bottom" style="text-align: center; margin-top: 20px;">
        <p>{{ $footerSetting->copyright_text }}</p>
        <p>Design by {{ $footerSetting->design_by }}</p>
    </div>
</footer>

@endsection