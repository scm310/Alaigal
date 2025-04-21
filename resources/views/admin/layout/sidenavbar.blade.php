<!doctype html>
<html lang="en">

<head>

    <title>{{ isset($gf) ? $gf->title : 'Admin' }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ isset($gf) ? asset('storage/app/public/favicon/' . $gf->logo) : '' }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/memberlayout/css/style.css') }}">

    <style>
        /* Sidebar styling */

    
        #sidebar {
            background: linear-gradient(-225deg, #7DE2FC 0%, #B9B6E5 100%);
        }

        ul li a {
            color: #fff;
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 10px;
            transition: color 0.3s;
        }

        ul li a i {
            margin-right: 10px;
        }

        /* Submenu (dropdown) styling */
        .submenu {
            display: none;
            padding-left: 20px;
        }

        .submenu-active {
            display: block !important;
        }

        /* Active link styling: Only text highlight */
        a.active {
            color: #ffd700;
            /* Highlight text with a golden color */
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="wrapper d-flex align-items-stretch" style="min-height: 100vh; height: auto;">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary d-block d-sm-none">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>

            <div class="p-4 pt-5">
                <h3><a href="#" class="logo">Admin</a></h3>

                <ul class="list-unstyled components mb-5">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <!-- Members Dropdown -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle">
                            <i class="fa fa-users"></i> Members
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('admin.users') }}">
                                    <i class="fa fa-users-cog"></i> Manage Member
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.approveMember') }}">
                                    <i class="fa fa-check"></i> Approve Member
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.rejectedMember') }}">
                                    <i class="fa fa-times-circle"></i> Rejected Member
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Member Lounge -->
                    <li>
                        <a href="{{ route('admin.member.lounge') }}">
                            <i class="fa fa-users"></i> Member Lounge
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle">
                            <i class="fas fa-file-alt"></i> Reports
                        </a>

                        <ul class="submenu">
                            <li>
                                <a href="{{ route('admin.members.data') }}">
                                    <i class="fas fa-chart-line"></i> Prime Report
                                </a>
                            </li>
                            <!-- <li>
                                <a href="{{ route('admin.references') }}">
                                    <i class="fas fa-share-alt"></i> Reference Given Report
                                </a>
                            </li> -->
                            <li>
                                <a href="{{ route('admin.thanksnotes') }}">
                                    <i class="fas fa-hands-helping"></i> Thanksnote Report
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
    <a href="{{ route('admin.thanksnotes') }}">
        <i class="fas fa-hands-helping"></i> Thanksnote Report
    </a>
</li>

                    <li class="dropdown">
    <a href="javascript:void(0);" class="dropdown-toggle">
        <i class="fas fa-link"></i> Reference
    </a>
    <ul class="submenu">
    <li>
    <a href="{{ route('admin.references') }}">
        <i class="fas fa-link"></i> Reference Report
    </a>
</li>
        <li>
            <a href="{{ route('admin.references.thisweek') }}">
                <i class="fas fa-link"></i> This Week's Reference Report
            </a>
        </li>
    </ul>
</li>




                    <!-- MyAsk -->
                    <li>
                        <a href="{{ route('admin.ask.list') }}">
                            <i class="fa fa-question-circle"></i> MyAsk
                        </a>
                    </li>
                    <!-- Subscription History Dropdown -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle">
                            <i class="fas fa-sign-in-alt"></i> Subscription History
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('admin.viewpayments') }}">
                                    <i class="fas fa-money-check-alt"></i> View Payment
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.expiringSubscriptions') }}">
                                    <i class="fas fa-redo-alt"></i> Renew Payment
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Login Settings Dropdown -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle">
                            <i class="fa fa-cog"></i> Login Settings
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('admin.headersetting.addbanner') }}">
                                    <i class="fa fa-image"></i> Add Banner
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.headersetting.addlogo') }}">
                                    <i class="fa fa-camera"></i> Add Logo
                                </a>
                            </li>



                            <li>
                                <a href="{{ route('header-setting.customerBanner') }}">
                                    <i class="fa fa-camera"></i> Customer Banner
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.favicon.create') }}">
                                    <i class="fas fa-image"></i> Add Favicon
                                </a>
                            </li>


                        </ul>
                    </li>
                    <!-- Logout -->
                    <li>
                        <a href="{{ route('admin.logout') }}">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="{{ asset('assets/memberlayout/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/memberlayout/js/popper.js') }}"></script>
    <script src="{{ asset('assets/memberlayout/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/memberlayout/js/main.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var currentUrl = window.location.href;

            // Loop through all sidebar links and mark the active one
            document.querySelectorAll('.list-unstyled a').forEach(function(link) {
                if (link.href === currentUrl) {
                    link.classList.add('active');

                    // If the active link is inside a dropdown, open the submenu and mark the dropdown toggle as active
                    var parentDropdown = link.closest('.dropdown');
                    if (parentDropdown) {
                        var submenu = parentDropdown.querySelector('.submenu');
                        var dropdownToggle = parentDropdown.querySelector('.dropdown-toggle');

                        if (submenu) submenu.classList.add('submenu-active');
                        if (dropdownToggle) dropdownToggle.classList.add('active');
                    }
                }
            });

            // Toggle dropdown click handling
            document.querySelectorAll(".dropdown-toggle").forEach(function(item) {
                item.addEventListener("click", function(event) {
                    event.preventDefault(); // Prevent default anchor action

                    let submenu = this.nextElementSibling;
                    if (!submenu) return; // Ensure submenu exists

                    // Close all other open submenus before opening the clicked one
                    document.querySelectorAll(".submenu-active").forEach(function(openMenu) {
                        if (openMenu !== submenu) {
                            openMenu.classList.remove("submenu-active");
                            openMenu.previousElementSibling.classList.remove("active");
                        }
                    });

                    // Toggle the clicked submenu
                    submenu.classList.toggle("submenu-active");
                    this.classList.toggle("active");
                });
            });
        });
    </script>

</body>

</html>