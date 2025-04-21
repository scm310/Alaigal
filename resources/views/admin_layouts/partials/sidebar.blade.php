@php
$isActiveDropdown = function(array $patterns) {
foreach ($patterns as $pattern) {
if (request()->is($pattern)) {
return true;
}
}
return false;
};
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="menu-inner-shadow"></div>
    <div class="mb-3">
    @if(!empty($gl->admin_logo))
        <img src="{{ asset('storage/app/public/' . $gl->admin_logo) }}" alt="Admin Logo" class="img-thumbnail" style="width:40px;height:43px;margin-left:70px; border-radius:5%;">
    @else
        <img src="{{ asset('assets/images/default.jpg') }}" alt="Admin Logo" class="img-thumbnail" style="width:40px;height:43px;margin-left:70px; border-radius:50%;">
    @endif
</div>

    <small class="text-muted text-center">Welcome, {{ Auth::user()->name }}</small>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <center><i class="menu-icons fas fa-tachometer-alt"></i></center> &nbsp;
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- <li class="menu-item dropdown {{ request()->is('approval*') || request()->is('vendors*') ? 'active open' : '' }}">
            <span class="menu-link menu-toggle">
                <center><i class="menu-icons fas fa-check-circle"></i></center> &nbsp;
                <div data-i18n="Approval">Approval Requests</div>
            </span>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('approval/vendor') ? 'active' : '' }}">
                    <a href="{{ route('approval.vendor') }}" class="menu-link">
                        <div data-i18n="Vendor Approval">Vendor Approval</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('approval/approved-vendors') ? 'active' : '' }}">
                    <a href="{{ route('approval.approved') }}" class="menu-link">
                        <div data-i18n="Approved Vendors">Approved Vendors</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('approval/rejected-vendors') ? 'active' : '' }}">
                    <a href="{{ route('approval.rejected') }}" class="menu-link">
                        <div data-i18n="Rejected Vendors">Rejected Vendors</div>
                    </a>
                </li>
             
            </ul>
        </li> -->


        <li class="menu-item dropdown {{ request()->is('settings', 'homepage-settings/*', 'logos', 'highlight-product', 'units','highlight','client-testimonials','bottom-banners','bottom-banners1','homepage-banners','homepage-settings/categorybanner','listingbanner') ? 'active open' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <center><i class="menu-icons fas fa-cog"></i></center> &nbsp;
                <div data-i18n="Settings">Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('units') ? 'active' : '' }}">
                    <a href="{{ route('units.index') }}" class="menu-link">Create UOM</a>
                </li>

                {{-- Keep "Home Settings" open when any of its submenus are active --}}
                <li class="menu-item dropdown {{ request()->is('homepage-settings/*', 'logos', 'highlight-product','highlight','client-testimonials','bottom-banners','bottom-banners1','homepage-banners','homepage-settings/categorybanner','listingbanner') ? 'active open' : '' }}">
                    <a href="#" class="menu-link menu-toggle">Home Settings</a>
                    <ul class="menu-sub">
                       
                        <li class="menu-item {{ request()->is('homepage-settings/banner') ? 'active' : '' }}">
                            <a href="{{ url('/homepage-settings/banner') }}" class="menu-link">• Banners</a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('logos.index') ? 'active' : '' }}">
                            <a href="{{ route('logos.index') }}" class="menu-link">• Header Settings</a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('highlightproduct') ? 'active' : '' }}">
                            <a href="{{ route('highlightproduct') }}" class="menu-link">• Highlight Product</a>
                        </li>

                        <li class="menu-item {{ request()->is('highlight') ? 'active' : '' }}">
                            <a href="{{ route('highlight.index') }}" class="menu-link">

                                <div data-i18n="Highlight">• Highlight</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->is('homepage-settings/categorybanner') ? 'active' : '' }}">
                            <a href="{{ url('/homepage-settings/categorybanner') }}" class="menu-link">• Category Banner</a>
                        </li>

                        <li class="menu-item {{ request()->is('listingbanner') ? 'active' : '' }}">
                        <a href="{{ route('listingbanners.index') }}" class="menu-link">• Listing Banner</a>

</li>

<li class="menu-item {{ request()->is('homepage-banners') ? 'active' : '' }}">
    <a href="{{ route('homepage.banners') }}" class="menu-link">• Homepage Banner</a>
</li>

<li class="menu-item {{ request()->is('bottom-banners') ? 'active' : '' }}">
    <a href="{{ route('bottom_banners.index') }}" class="menu-link">• Bottom Banner1</a>
</li>

<li class="menu-item {{ request()->is('bottom-banners1') ? 'active' : '' }}">
    <a href="{{ route('bottom_banners1.show') }}" class="menu-link">• Bottom Banner2</a>
</li>


<li class="menu-item {{ request()->is('client-testimonials') ? 'active' : '' }}">
    <a href="{{ route('client_testimonials.index') }}" class="menu-link">• Testimonial</a>
</li>

                    </ul>
                </li>
            </ul>
        </li>



        <li class="menu-item {{ request()->is('categories*') ? 'active' : '' }}">
            <a href="{{ route('categories.index') }}" class="menu-link">
                <center><i class="menu-icons fas fa-list"></i></center> &nbsp;
                <div data-i18n="Manage Category">Manage Category</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('manage-products') ? 'active' : '' }}">
            <a href="{{ route('items.index') }}" class="menu-link">
                <center><i class="menu-icons fas fa-box"></i></center> &nbsp;
                <div data-i18n="Manage Product">Manage Product</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('vendor-items') ? 'active' : '' }}">
            <a href="{{ route('vendor-items.index') }}" class="menu-link">
                <center><i class="menu-icons fas fa-users"></i></center> &nbsp;
                <div data-i18n="Vendor Items">Vendor Items</div>
            </a>
        </li>

        <li class="menu-item {{ request()->is('notifications/new-vendor-products') ? 'active' : '' }}">
            <a href="{{ route('notifications.newVendorProducts') }}" class="menu-link">
                <center><i class="menu-icons fas fa-bell"></i></center> &nbsp;
                <div data-i18n="Notification">Notification</div>
            </a>
        </li>


        <!-- Enquiry Management -->
        <li class="menu-item dropdown {{ $isActiveDropdown(['schedule-call*']) ? 'active open' : '' }}">
            <a href="#" class="menu-link menu-toggle">
                <center><i class="fa fa-question-circle"></i></center> &nbsp;
                <div data-i18n="Enquiry Management" title="Enquiry Management">Enquiry Management</div>

            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('schedule-call') ? 'active' : '' }}">
                    <a href="{{ route('schedule-call') }}" class="menu-link">Schedule a call</a>
                </li>
            </ul>
            <ul class="menu-sub">

            <li class="menu-item {{ request()->is('vendors/request') ? 'active' : '' }}">
                    <a href="{{ route('vendors.request') }}" class="menu-link">
                        <div data-i18n="Vendors Request">Vendors Request</div>
                    </a>
                </li>  </ul>
        </li>

        @if (Auth::check())
        <li class="menu-item {{ request()->is('logout') ? 'active' : '' }}">
            <a href="{{ route('logout') }}" class="menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <center><i class="menu-icons fas fa-power-off"></i></center>
                &nbsp; <div data-i18n="Log Out">Log Out</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        @endif
    </ul>
</aside>