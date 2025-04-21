<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="#" class="app-brand-link">
      <span class="app-brand-logo demo me-1">
        <span style="color: var(--bs-primary)">
          <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- SVG Paths for Logo -->
          </svg>
        </span>
      </span>
      <span class="app-brand-text demo menu-text fw-semibold ms-2">Auto forge</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">
      <!-- Income / Invoice Delivery -->
      <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons mdi mdi-cash"></i>
        <div data-i18n="Dasboard">Dashboard</div>
      </a>
    </li>
    <!-- Quotation Comparison -->
    <li class="menu-item">
      <a href="{{ route('quotation.index') }}" class="menu-link">
        <i class="menu-icon tf-icons mdi mdi-file-document"></i>
        <div data-i18n="Quotation Comparison">Quotation Comparison</div>
      </a>
    </li>
    <!-- Vehicle Analysis -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons mdi mdi-car"></i>
        <div data-i18n="Vehicle Analysis">Vehicle Analysis</div>
      </a>
      <ul class="menu-sub">
        <!-- Create -->
        <li class="menu-item">
          <a href="/vehicle_create" class="menu-link">
            <div data-i18n="Create">Create</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/vehicle_edit" class="menu-link">
            <div data-i18n="Create">Edit</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons mdi mdi-account"></i>
        <div data-i18n="Vehicle Analysis">Staff</div>
      </a>
      <ul class="menu-sub">
        <!-- Create -->
        <li class="menu-item">
          <a href="/users" class="menu-link">
            <div data-i18n="Create">User</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="/manage-permissions" class="menu-link">
            <div data-i18n="Create">Manage</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- Material Allocation -->
    <li class="menu-item">
      <a href="" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons mdi mdi-package-variant-closed"></i>
        <div data-i18n="Material Allocation">Material Allocation</div>
      </a>
      <ul class="menu-sub">
        <!-- Add -->
        <li class="menu-item">
          <a href="/add-material" class="menu-link">
            <div data-i18n="Add">Add</div>
          </a>
        </li>
        <!-- Edit -->
        <li class="menu-item">
          <a href="/admin/editmaterial" class="menu-link">
            <div data-i18n="Edit">Edit</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- Expenses -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons mdi mdi-currency-usd"></i>
        <div data-i18n="Expenses">Expenses</div>
      </a>
      <ul class="menu-sub">
        <!-- Purchase Order Create -->
        <li class="menu-item">
          <a href="admin/purchaseorder" class="menu-link">
            <div data-i18n="Purchase Order Create">Purchase Order Create</div>
          </a>
        </li>
        <!-- Expenses Input Form -->
        <li class="menu-item">
          <a href="admin/expenseinput" class="menu-link">
            <div data-i18n="Expenses Input Form">Expenses Input Form</div>
          </a>
        </li>
        <!-- Expenses View -->
        <li class="menu-item">
          <a href="admin/expenseview" class="menu-link">
            <div data-i18n="Expenses View">Expenses View</div>
          </a>
        </li>
        <!-- Vehicle Delivery -->
        <li class="menu-item">
          <a href="/vehicle_delivery" class="menu-link">
            <div data-i18n="Vehicle Delivery">Vehicle Delivery</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- Income / Invoice Delivery -->
    <li class="menu-item">
      <a href="#" class="menu-link">
        <i class="menu-icon tf-icons mdi mdi-cash"></i>
        <div data-i18n="Income / Invoice Delivery">Income / Invoice Delivery</div>
      </a>
    </li>
    <!-- Add supplier -->
   <li class="menu-item">
  <a href="/vendors" class="menu-link">
    <i class="menu-icon tf-icons mdi mdi-warehouse"></i>
    <div data-i18n="Income / Invoice Delivery">Add Supplier</div>
  </a>
</li>

    <!-- Store -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons mdi mdi-store"></i>
        <div data-i18n="Store">Store</div>
      </a>
      <ul class="menu-sub">
        <!-- Add Product -->
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Add Product">Add Product</div>
          </a>
        </li>
        <!-- Returns -->
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Returns">Returns</div>
          </a>
        </li>
        <!-- Return View -->
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Return View">Return View</div>
          </a>
        </li>
        <!-- Labor -->
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Labor">Labour</div>
          </a>
        </li>
      </ul>
    </li>
  </ul>
</aside>