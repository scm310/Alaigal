       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
       <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
         <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
           <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
             <i class="mdi mdi-menu mdi-24px"></i>
           </a>
         </div>
         <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
           <ul class="navbar-nav flex-row align-items-center ms-auto">
             <!-- Place this tag where you want the button to render. -->
             <li class="nav-item lh-1 me-3">
               <a class="#" href="#" data-icon="#" data-size="#" data-show-count="true" aria-label="#"></a>
             </li>
             <!-- User -->
             <li class="nav-item navbar-dropdown dropdown-user dropdown">
               <a class="nav-link dropdown-toggle hide-arrow p-3 avatar-container" href="javascript:void(0);" data-bs-toggle="dropdown">
               <!-- <div class="avatar ">

<a class="navbar-brand" href="{{route('home')}}">
  <img src="{{ asset('storage/app/public/' . $gl->logo_path) }}" alt="Logo" class="mb-3" style="width:50px; height:50px; border-radius:50%;"/>
</a>

</div> -->
               </a>
               <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                 <li>
                  
                  
                   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                   <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                     <i class="mdi mdi-power me-1 mdi-20px"></i>
                     <span class="align-middle">Logout</span>
                   </button>
                 </li>
                 <!--/ User -->
               </ul>
         </div>
       </nav>