<!-- Add this CSS to enable tooltip visibility on hover -->
<style>
    .tooltip-container:hover .tooltip-text {
        visibility: visible;
        display: block;
    }
</style>

<style>


/* Adjust container position to move it slightly left */
.content {
  width: 100%; /* Ensuring full width of sidebar */
  max-width: 1100px; /* Slightly reducing max width */
  height: auto;
  margin-left: -40px; /* Move content slightly left */
  padding: 20px;
}
/* Adjust nav pills to display 3 tabs on first row, 2 on the second row */
.nav-pills {
  width: 534px;
  display: grid;
  grid-template-columns: repeat(5, 1fr); /* 3 columns on first row */
  background: linear-gradient(to right, #1d2b64, #f8cdda);
  border-radius: 5px 5px 0px 0px;
  padding: 10px;

}



.nav-pills .nav-link {
  font-weight: normal;
  font-size:11px;
  padding: 10px 0; /* Reduced padding for smaller screens */
  text-align: left;
  background: linear-gradient(to right, #bdc3c7, #2c3e50);
  color: #fff;
  border-radius: 0px 5px 0px 5px;
  transition: all 0.3s ease-in-out;
  width: 70px;
}

.nav-pills .nav-link.active {
  background: linear-gradient(to right, #1d2b64, #f8cdda);
  color: #fff;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
}

/* Tab content full width to fit the sidebar */
.tab-content {
  width: 515px;
  height: auto;
  background: linear-gradient(to right, #1d2b64, #f8cdda);
  border-radius: 0px 0px 30px 30px;
  box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.4);
  padding: 20px;
  margin-bottom: 10px;

}

.tab-content button {
  border-radius: 15px;
  width: 100px;
  margin: 0 auto;
  float: right;
}

/* Tab Pane Animation */
.tab-pane {
  display: none;
  opacity: 0;
  transform: translateX(50px);
  transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
}

.tab-pane.active {
  display: block;
  opacity: 1;
  transform: translateX(0);
}

/* Grid Layout for Cards */
.card-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* 2 columns */
  gap: 20px; /* Spacing between cards */
  margin-top: 20px;
}

/* Card Styling */
.info-card {
    display: flex;
    flex-direction: column;
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    width: 100%;
    max-width:230px;
}

.member-details {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    margin-left:20px;
}

.member-text {
    text-align: left;
}

.member-text h4 {
    margin: 0;
    font-size: 18px;
}

.member-text p {
    margin: 0;
    font-size: 14px;
    font-weight: bold;
    color: #555;
}

.member-photo img {
    width: 70px; /* Adjust size */
    height: 70px;
    border-radius: 25%;
    object-fit: cover;
}

.member-info p {
    margin: 3px 0;
    font-size: 10px;
}

.info-card:hover {
  transform: scale(1.05); /* Hover effect */
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
}

.info-card p {
  margin: 10px 0;
  font-size: 12px;
  color: black;
  word-wrap: break-word; /* Breaks long words */
  overflow-wrap: break-word; /* Ensures text wraps within the container */
  white-space: normal; /* Allows text wrapping */
  max-width: 100%; /* Prevents text from overflowing */
}
/* Ensure Testimonial text wraps and does not expand the card */
.testimonial-content {
  word-wrap: break-word; /* Allows long words to break */
  overflow-wrap: break-word; /* Ensures proper text wrapping */
  white-space: normal; /* Allows normal text wrapping */
  max-height: 80px; /* Set a maximum height to prevent card expansion */
  overflow: hidden; /* Hides extra text */
  text-overflow: ellipsis; /* Adds "..." for overflow text */
  display: -webkit-box;
  -webkit-line-clamp: 3; /* Limit text to 3 lines */
  -webkit-box-orient: vertical;
}

/* Tooltip container */
.tooltip-container {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

/* Tooltip text */
.tooltip-container .tooltip-text {
  visibility: hidden;
  width: 200px;
  font-size:11px;
  border: 2px solid #c7c4c4;
  text-align: center;
  border-radius: 5px;
  padding: 8px;
  position: absolute;
  z-index: 1;
  bottom: 125%; /* Position above the text */
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  word-wrap: break-word;
}

/* Show tooltip when hovering */
.tooltip-container:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}



/* Ensure only images are centered */
.info-card img {
  display: block; /* Ensures correct rendering */
  margin: 0 auto; /* Centers the image horizontally */
  width: 100px; /* Fixed width */
  height: 140px; /* Fixed height */
  object-fit: cover; /* Maintain aspect ratio */
  border-radius: 10px;
}



/* Back Button */
.back-btn {
  display: block;
  width: fit-content;
  margin: 20px auto;
  background: #b993d6;
  color: #fff;
  padding: 8px 15px;
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease-in-out;
}

.back-btn:hover {
  background: #000;
  color: #fff;
}

#tab-menu {
  display: flex;
  justify-content: space-evenly; /* Distributes space evenly */
  padding: 0; /* Removes extra padding */
  margin: 0; /* Removes unwanted margins */
  gap: 0; /* Eliminates gaps between tabs */
}

#tab-menu {
  display: flex;
  justify-content: space-between; /* Evenly distribute tabs */
  padding: 0;
  margin: 0;
  gap: 2px; /* Minimal gap for better spacing */
  flex-wrap: nowrap; /* Prevents wrapping */
}

#tab-menu .nav-item {
  flex-grow: 1; /* Ensures equal width */
  text-align: center;
  margin: 0;
}

#tab-menu .nav-link {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px 5px; /* Reduces padding to fit text */
  font-size: 12px; /* Adjust font size to prevent overlap */
  white-space: nowrap; /* Prevents text wrapping */
  width: 100%; /* Makes sure each tab takes full width */
  border-radius: 5px;
  gap: 3px; /* Reduces spacing between icon and text */
}

#tab-menu .nav-link i {
  font-size: 12px; /* Adjust icon size */
}

.card1{
  background-color: #e7cfcf;
            padding: 10px;
            margin: 5px;
            width: calc(50% - 20px);
            box-sizing: border-box;
            border-radius: 8px;

}
.project-image{
  display: block;
   max-width: 100%;
    height: auto;
     margin: 5px auto;
     border-radius: 5px;
}

.testimonial{
display: grid !important;
flex-wrap: wrap !important;
gap: 40px;
z-index:-1;
}

.testcard{
 background-color: #e7cfcf;
  padding: 8px;
  margin-top:-27px;
  width:100%;
}


/* Mobile Responsiveness */
@media (max-width: 768px) {
  .content {
    width: 100%;
    padding: 10px;
  }



  .nav-pills {
    flex-wrap: wrap; /* Allow tabs to wrap on smaller screens */
  }

  .nav-item {
    flex: 1 1 100%; /* Full width for tabs on mobile */
    margin: 5px 0;
  }

  .card-grid {
    grid-template-columns: 1fr; /* 1 column on mobile */
  }

  .info-card img {
    height: 120px; /* Smaller images on mobile */
  }

  .member-text h4 {
    margin: 0;
    font-size:12px;
}

}
  /* Ensure full responsiveness */
@media (max-width: 768px) {
  .content {
    width: 100%;
    margin-left: 0; /* Reset margin for mobile */
    padding: 10px;
  }

  /* Adjust nav pills to stack tabs properly */
  .nav-pills {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* 2 columns for smaller screens */
    gap: 5px;
    padding: 5px;
  }

  .nav-item {
    min-width: auto; /* Allow flexible width */
    flex: 1 1 48%; /* Each tab takes 48% width */
  }

  .nav-pills .nav-link {
    font-size: 14px; /* Slightly bigger text for better readability */
    padding: 8px;
    text-align: center;
  }

  /* Adjust tab content width */
  .tab-content {
    width: 100%;
    padding: 10px;
  }

  /* Change card grid to a single-column layout on small screens */
  .card-grid {
    grid-template-columns: 1fr; /* One column */
  }

  /* Reduce image size for smaller screens */
  .info-card img {
    width: 100px; /* Smaller width */
  }



  .info-card p{
    font-size: 12px;
    text-align: center !important;
  }

  .table thead {
        font-size:13px; /* Slightly reduce header font size */
    }

    .table td, .table th {
        padding: 8px; /* Reduce padding for better fit */
        font-size:13px; /* Adjust text size */
        white-space: nowrap; /* Prevent text wrapping */
    }

    .table-responsive {
        overflow-x: auto; /* Allow horizontal scroll */
        -webkit-overflow-scrolling: touch; /* Smooth scrolling */
    }
}




</style>
<div class="content">
  <!-- Sticky Nav pills with Icons -->
 <style>
/* Enable horizontal scrolling only for mobile */
@media (max-width: 768px) {
    #tab-menu {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none; /* Hide scrollbar for Firefox */
        -ms-overflow-style: none; /* Hide scrollbar for IE/Edge */
        padding-bottom: 5px; /* Prevent cutting off items */
    }

    #tab-menu::-webkit-scrollbar {
        display: none; /* Hide scrollbar for Chrome/Safari */
    }

    #tab-menu .nav-item {
        flex: 0 0 auto;
        margin-right: 10px;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* 2 columns per row */
        gap: 10px; /* Space between cards */
    }

    .info-card {
        width: 100%; /* Ensure equal width */
    }

    .info-card img {
        width: 100%; /* Make images responsive */
    }

  .project{
    display: block !important;
  }

  .card1{
    width: 100% !important;
  }
  .project-image{
  display: block;
 width:120px !important;
    height: auto;
     margin: 5px auto;
     border-radius: 5px;
}

.testimonial{
display:block !important;
flex-wrap: wrap;
gap: 40px;
}

.testcard{
 background-color: #e7cfcf;
  padding: 8px;
  margin: 4px;
  width:100%;
}

}

 /* Add gap only on mobile screens */
 @media (max-width: 768px) {
    .info-card {
      margin-bottom: 20px; /* Add spacing between cards */
    }

    .tooltip-container {
      display: block; /* Ensure full-width alignment on mobile */
      text-align: center;
      margin-top: 10px;
    }

    .tooltip-text {
      width: 90%; /* Adjust width for smaller screens */
      bottom: -40px; /* Position below content on mobile */
      left: 5%;
      transform: translateX(0);
      font-size: 12px; /* Smaller font size for mobile */
    }
}




@media (max-width: 768px) {
    .container {
        padding: 10px; /* Reduce padding to bring content inside */
    }

    .info-card {
        margin: 40px auto 0; /* Moves the card further down */
        width: 90%;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    /* Move the tab menu slightly down */
    #tab-menu {
        transform: translateY(-10px); /* Adjust position */
    }

    /* Move Personal, Services, Products, Clients cards down */
    .tab-content .tab-pane {
        margin-top: - 20px; /* Adjust the spacing */
    }


    #clients {
        margin-top: 50px; /* Adjust this value as needed */
    }


    #services .info-card {
        margin-top: 0px !important;  /* Ensure only this tab has margin-top 0 on mobile */
    }
}
</style>

<ul class="nav nav-pills bg-white shadow-sm" id="tab-menu" role="tablist" style="position: sticky; top: 0; z-index: 1000; transform: translateY(-20px); width:118%; padding-left: 5px;">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="pill" href="#details">
      Personal
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="pill" href="#products">
      Products
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="pill" href="#services">
       Services
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="pill" href="#clients">
      Clients
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="pill" href="#testimonials">
       Testimonials
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="pill" href="#projects">
      Projects
    </a>
  </li>
</ul>

  <!-- Tab Content -->
  <div class="tab-content">
    <!-- Member Details Tab -->
    <div id="details" class="container tab-pane active">
    <div class="info-card" style="background-color: #e7cfcf; width: 95%; max-width: 800px; padding: 20px; margin-left:10px; margin-top:-20px;">

    <div class="member-details">
        <div class="member-text">
            <h4>{{ $member->first_name }} {{ $member->last_name }}</h4>
            <p><strong>{{ $member->designation }}</strong></p>
        </div>
        <div class="member-photo">
    <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.jpg') }}"
         alt="Member Photo">
</div>


    </div>

    <div class="member-info">
        <p><strong>Company:</strong> {{ $member->company_name }}</p>
        <p><strong>Phone:</strong> {{ $member->phone_number }}</p>
        <p><strong>Email:</strong> {{ $member->email }}</p>
        <p><strong>Location:</strong> {{ $member->state }}, {{ $member->city }}, {{ $member->pincode }}</p>
        <p><strong>Industry:</strong> {{ $member->industry }}</p>
        <p><strong>Website:</strong>
    @if($member->prime_member == 1)
        <a href="{{ $member->website }}" target="_blank">{{ $member->website }}</a>
    @else
        {{ $member->website }}
    @endif
</p>

    </div>
</div>
    </div>

<!-- Products Tab -->
<div id="products" class="container tab-pane fade" style="margin-top:-40px;">
    <div class="card-grid">
        @foreach($products as $product)
        <div class="info-card" style="background-color: #e7cfcf; padding: 10px; margin:px;">
            <p style="text-align: center;"><strong>{{ $product->product_name }}</strong></p>
            <img src="{{ $product->product_image ? asset('storage/app/public/' . $product->product_image) : asset('assets/images/default_tab.png') }}"
                 alt="{{ $product->product_name }}">
        </div>
        @endforeach
    </div>
</div>

<!-- Services Tab -->
<div id="services" class="container tab-pane fade">
    <div class="card-grid">
        @foreach($services as $service)
        <div class="info-card" style="background-color: #e7cfcf; padding: 10px; margin: 5px; margin-top:-40px;">
            <p style="text-align: center;"><strong>{{ $service->service_name }}</strong></p>
            <img src="{{ $service->service_image ? asset('storage/app/public/' . $service->service_image) : asset('assets/images/default_tab.png') }}"
                 alt="{{ $service->service_name }}">
        </div>
        @endforeach
    </div>
</div>


    <!-- Clients Tab -->
    <div id="clients" class="container tab-pane fade" style="margin-top:-20px;">
        <div class="table-responsive">
            <table class="table table-bordered" style="border-radius: 10px; overflow: hidden; background-color: #e7cfcf;">
                <thead class="thead">
                    <tr style="background-color: #212529; color: white; text-align: center;">
                        <th style="border-top-left-radius: 10px; padding: 10px; font-weight: normal;">Client Name</th>
                        <th style="border-top-right-radius: 10px; padding: 10px; font-weight: normal;">Company Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td>{{ $client->client_name }}</td>
                            <td>{{ $client->company_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center; padding: 15px; font-weight: bold; color: #555;">
                                No data available
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


<!-- Testimonials Tab -->
<div id="testimonials" class="container tab-pane fade">
  <div class="card-grid testimonial" style="margin-top:10px;">
    @foreach($testimonials as $testimonial)
    <div class="info-card testcard" >
      <img src="{{ $testimonial->testimonial_image ? asset('storage/app/public/' . $testimonial->testimonial_image) : asset('assets/images/default.jpg') }}"
           alt="{{ $testimonial->client_name }}"
           style="display: block; width: 109px; margin-bottom: 5px;">

      <p style="margin: 4px 0; font-size: 14px;"><strong>{{ $testimonial->client_name }}</strong> - {{ $testimonial->designation }}</p>
      <p style="margin: 4px 0; font-size: 14px;"><strong>{{ $testimonial->company_name }}</strong></p>

      <div class="tooltip-container">
          <p class="testimonial-content" style="margin: 4px 0; font-size: 14px;">
              "{{ Str::limit($testimonial->content, 80, '...') }}"
          </p>
          @if(strlen($testimonial->content) > 80)
              <span class="tooltip-text" style="background-color: #e7cfcf; color: black;">
                  "{{ $testimonial->content }}"
              </span>
          @endif
      </div>
    </div>
    @endforeach
  </div>
</div>

<!-- Projects Tab -->
<div id="projects" class="container tab-pane fade">

    <div class="card-grid project" style="
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        width: 100%;
        justify-content: center;margin-top:-20px;">

        @foreach($completed_projects as $project)
        <div class="info-card card1" >

            <p style="margin: 5px 0; font-size: 14px; text-align: center;">
                <strong>Project Name:</strong> {{ $project->project_name }}
            </p>

            <img src="{{ $project->project_image ? asset('storage/app/public/' . $project->project_image) : asset('assets/images/default_tab.png') }}"
                 alt="{{ $project->project_name }}" class="project-image">

            <p style="margin: 5px 0; font-size: 14px; text-align: center;">
                <strong>Client Name:</strong> {{ $project->client_name }}
            </p>
            <p style="margin: 5px 0; font-size: 14px; text-align: center;">
                <strong>Company Name:</strong> {{ $project->company_name }}
            </p>
        </div>
        @endforeach

    </div>
</div>


</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    if (window.innerWidth <= 768) { // Apply only on mobile
        const tabMenu = document.getElementById("tab-menu");

        let isDown = false;
        let startX;
        let scrollLeft;

        tabMenu.addEventListener("touchstart", (e) => {
            isDown = true;
            startX = e.touches[0].pageX - tabMenu.offsetLeft;
            scrollLeft = tabMenu.scrollLeft;
        });

        tabMenu.addEventListener("touchmove", (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.touches[0].pageX - tabMenu.offsetLeft;
            const walk = (x - startX) * 2; // Adjust scroll speed
            tabMenu.scrollLeft = scrollLeft - walk;
        });

        tabMenu.addEventListener("touchend", () => {
            isDown = false;
        });
    }
});
</script>

