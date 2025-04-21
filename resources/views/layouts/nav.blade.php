<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sakthi Body Works</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets\css\adminstyle.css')}}">

<link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.lineicons.com/3.0/lineicons.css">

    <style>
 #sidebar {
    background-color: #ececec;
    width: 320px; /* Adjust the width as needed */
    color: #000000;
}

/* Add decoration styles */
.sidebar-logo {
    padding: 10px 20px; /* Adjusted padding */
    text-align: center;
}

.sidebar-logo a {
    color: white; /* Changed text color to black */
    font-size: 24px;
    text-decoration: none;
    font-weight: bold;
}

.sidebar-nav {
    padding-left: 0;
    margin-top: 10px; /* Adjusted margin */
}

.sidebar-item {
    list-style: none;
    padding: 10px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-item:last-child {
    border-bottom: none;
}

.sidebar-logo a {
    color: black;
}

.sidebar-link {
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: all 0.3s ease; /* Added transition for smooth effect */
    color: #000000;
}

.sidebar-link i {
    margin-right: 10px;
}

.sidebar-link:hover {
    background-color: #f8d5f0;
    border-radius: 5px;
    color: white; /* Changed text color to white on hover */
    transform: scale(1.05); /* Slightly pop up effect */
}

.sidebar-link:hover i {
    color: #f8d5f0; /* Change icon color to #ececec on hover */
}

/* Adjustments for dropdowns */
.sidebar-dropdown {
    margin-left: 20px;
}

.sidebar-dropdown .sidebar-item {
    padding-left: 40px;
}
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Bootstrap-select CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap-select JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>



    </style>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="expand">
            <div class="d-flex sidebar-logo">
                <a href="#">Sakthi Body Works</a>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="/views/admin.test" class="sidebar-link">
                        <i class="lni lni-dashboard"></i> <!-- Changed icon -->
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                        <i class="lni lni-car"></i> <!-- Changed icon -->
                        <span>Vehicle Analysis</span>
                    </a>
                    <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{route('admin.create')}}" class="sidebar-link">Create</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                 <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
    data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
    <i class="lni lni-layout"></i> <!-- Changed icon -->
    <span>Material Allocation</span>
</a>


                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{route('admin.materialallocation')}}" class="sidebar-link">Add Materials</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.edit')}}" class="sidebar-link">Edit Materials</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#expenses" aria-expanded="false" aria-controls="expenses">
                        <i class="lni lni-layout"></i>
                        <span>Expenses</span>
                    </a>
                    <ul id="expenses" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{route('admin.purchaseorder')}}" class="sidebar-link">Purchase Order Create</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.expenseinput')}}" class="sidebar-link">Expense Input Form</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.expensetable')}}" class="sidebar-link">Expense View</a>
                        </li>

                        <li class="sidebar-item">
                            <a href="{{route('admin.vehicledelivery')}}" class="sidebar-link">Vehicle delivery</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#income" aria-expanded="false" aria-controls="income">
                        <i class="lni lni-layout"></i>
                        <span>Income</span>
                    </a>
                    <ul id="income" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Invoice Create</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#store" aria-expanded="false" aria-controls="store">
                        <i class="lni lni-cart"></i>
                        <span>Store</span>
                    </a>
                    <ul id="store" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Add Product</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.productstock')}}" class="sidebar-link">Product Stock</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.return')}}" class="sidebar-link">Returns</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.returnview')}}" class="sidebar-link">Returns view</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#labour" aria-expanded="false" aria-controls="labour">
                        <i class="lni lni-users"></i>
                        <span>Labour</span>
                    </a>
                    <ul id="labour" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Internal Labour</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">External Labour</a>
                        </li>
                    </ul>
                </li>
<li class="sidebar-item">
                    <a href="" class="sidebar-link">
                        <i class="lni lni-exit"></i> <!-- Changed icon -->
                        <span>Logout</span>
                    </a>
                </li>
             
            </ul>
        </aside>
        
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
        <script>
    // Initialize Bootstrap-select plugin
    $('.selectpicker').selectpicker();
</script>
</body>
</html>
