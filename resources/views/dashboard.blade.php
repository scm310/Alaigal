@extends('admin_layouts.app')

@section('content')

<style>
.content-wrapper {
    background-color: white;
    overflow-y: hidden;
}

.footer {
    background-color: #f8f9fa;
    padding: 1rem 0;
    margin-top: 520px;
}

/* Card Styling */
.card {
    position: relative;
    height: 100px;
    background: linear-gradient(to bottom right, #E0BBE4, #957DAD);
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    color: #fff;
    cursor: pointer;
    transition: box-shadow 0.3s ease-in-out;
}

.card-body {
    padding: 20px;
    text-align: center;
   
}

.centeralign {
    text-align: center;
    color:white;
}

/* Hover Effect */
.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Tooltip Styling */
.tooltip-custom {
    position: absolute;
    background: rgba(25, 24, 24, 0.75);
    color: white;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 5px;
    display: none;
    white-space: nowrap;
    z-index: 10;
}

.card:hover .tooltip-custom {
    display: block;
}

/* Positioning for each tooltip */
#productCard .tooltip-custom {
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
}

#newVendorProductsCard .tooltip-custom {
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
}

#editedVendorProductsCard .tooltip-custom {
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
}

#vendorCard .tooltip-custom {
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
}

/* Remove default link styling */
a {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

     /* Notification Container */
 /* Notification Container */
.notification-container {
    position: fixed;
    top: 40px;
    right: 20px;
    width: 75px;
    cursor: pointer;
    z-index: 10000;
}

/* Bell Icon with Background */
.notification-icon {
    width:45px;
    height:45px;
    font-size:18px;
    color: black;
    background: #ffffff;
    border-radius: 50%;
    padding: 15px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}

.notification-icon:hover {
    background: #f0f0f0;
}

/* Notification Count Badge */
@keyframes pop {
    0% {
        transform: scale(0.5);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1);
    }
}

.notification-count {
    position: absolute;
    top: 5px;
    right: 18px;
    background: red;
    color: white;
    font-size: 14px;
    font-weight: bold;
    border-radius: 50%;
    min-width: 20px;
    height: 20px;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    animation: pop 0.3s ease-in-out;
}

/* Notification Messages Box */
.notification-box {
    position: absolute;
    top:100px;
    right:20px;
    width: 280px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}

/* Notification Box Header */
.notification-box h4 {
    background: #f4f4f4;
    margin: 0;
    padding: 12px;
    font-size: 16px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #333;
    font-weight: bold;
}

/* Close Button */
.notification-close {
    cursor: pointer;
    font-size: 18px;
    color: red;
    transition: 0.3s;
}

.notification-close:hover {
    color: darkred;
}

/* Notification Messages */
.notification-messages {
    padding: 10px;
    max-height: 250px;
    overflow-y: auto;
}

/* Individual Notification Item */
.notification-item {
    background: #f9f9f9;
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 4px solid #3498db;
    transition: 0.3s;
}

.notification-item:hover {
    background: #e6f7ff;
}

/* Notification Text */
.notification-item p {
    margin: 0;
    font-size: 14px;
    color: #333;
}

/* Close Button for Each Notification */
.notification-close-btn {
    background: none;
    border: none;
    color: #e74c3c;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.notification-close-btn:hover {
    color: #c0392b;
}

/* Scrollbar Styling */
.notification-messages::-webkit-scrollbar {
    width: 6px;
}

.notification-messages::-webkit-scrollbar-thumb {
    background: #bbb;
    border-radius: 10px;
}

.notification-messages::-webkit-scrollbar-track {
    background: #f4f4f4;
}

/* Fade-in Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


.notification-box {
    width: 350px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px;
    position: absolute;
    right: 20px;
    display: none;
}

h4 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 16px;
    margin-bottom: 10px;
}

.notification-messages {
    max-height: 300px;
    overflow-y: auto;
}

.notification-item {
    background: #f5f7fa;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.notification-item p {
    margin: 0;
    color: #333;
    flex: 1;
    cursor: pointer;
}

.notification-link {
    font-size: 12px;
    color: blue;
    text-decoration: underline;
}

.close-btn {
    color: red;
    font-size: 16px;
    cursor: pointer;
}

.counts{
    transform:translateX(70px);
}

@media (max-width: 768px) {
    .counts{
    transform:translateX(180px);
}

}
</style>
<br>

<span class="text-white">

<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-sm-6 col-lg-2 mt-2">
            <a href="{{ route('items.index') }}">
                <div class="card cardhead" id="productCard">
                    <div class="card-body">
                        <h4 class="mb-0 centeralign product-heading counts">{{ $totalProducts }}</h4>
                        <h6 class="mb-0 fw-normal centeralign"><strong>Total Number of Products</strong></h6>
                    </div>
                    <div class="tooltip-custom">Total Products Count</div>
                </div>
            </a>
        </div>

        <!-- New Vendor Products Card -->
        <div class="col-lg-2 mt-2">
            <a href="{{ route('notifications.newVendorProducts') }}" onclick="markAsSeen()">
                <div class="card cardhead" id="newVendorProductsCard"
                     style="animation: {{ session('new_vendor_product_seen') ? 'none' : 'pulse 1s infinite' }};">
                    <div class="card-body position-relative">
                        <h4 class="mb-0 centeralign delivery-headings counts">{{ $newVendorProductsCount }}</h4>
                        <h6 class="mb-0 fw-normal centeralign"><strong>Latest Notifications</strong></h6>
                    </div>
                    <div class="tooltip-custom">Check Latest Vendor Notifications</div>
                </div>
            </a>
        </div>

        <!-- Edited Vendor Products Card -->
        <div class="col-lg-2 mt-2">
            <a href="{{ route('notifications.newVendorProducts') }}" onclick="markAsSeen()">
                <div class="card cardhead" id="editedVendorProductsCard"
                     style="animation: {{ session('new_vendor_product_edit_seen') ? 'none' : 'pulse 1s infinite' }};">
                    <div class="card-body position-relative">
                        <h4 class="mb-0 centeralign delivery-headings counts">{{ $newVendorProductEditedCount }}</h4>
                        <h6 class="mb-0 fw-normal centeralign"><strong>Edited Vendor Products</strong></h6>
                    </div>
                    <div class="tooltip-custom">Check Edited Vendor Products</div>
                </div>
            </a>
        </div>

        <!-- Total Vendors Card -->
        <div class="col-sm-6 col-lg-2 mt-2">
    <a href="{{ route('approval.vendor') }}">
        <div class="card cardhead" id="vendorCard">
            <div class="card-body">
                <h4 class="mb-0 centeralign counts counts">{{ $totalVendors }}</h4>
                <h6 class="mb-0 fw-normal centeralign"><strong>Total Number of Vendors</strong></h6>
            </div>
            <div class="tooltip-custom">View Total Vendors</div>
        </div>
    </a>
</div>



<div class="col-sm-6 col-lg-2 mt-2">
    <a href="{{ route('vendors.request') }}">
        <div class="card cardhead" id="vendorCard">
            <div class="card-body">
                <h4 class="mb-0 centeralign counts">{{ $customerSupportCount }}</h4> <!-- Display total count -->
                <h6 class="mb-0 fw-normal centeralign"><strong>Total Number of Vendors Request</strong></h6>
                
                <!-- Difference Calculation with Color -->
                @if(isset($oldCustomerSupportCount))
                    @php
                        $difference = $customerSupportCount - $oldCustomerSupportCount;
                    @endphp

                    <h5 class="mb-0 centeralign 
                        @if($difference > 0) text-success
                        @elseif($difference < 0) text-danger
                        @else text-secondary
                        @endif">
                        Difference: {{ $difference }}
                    </h5>
                @endif
            </div>
            <div class="tooltip-custom">View Total Requests</div>
        </div>
    </a>
</div>









    </div>
</div>

  <!-- Notification Bell Button -->
  <div class="notification-container" id="notification-button">
        <div class="notification-icon">
        <i class="fas fa-bell" style="color:#f2ce6b;"></i>
        </div>
        <span class="notification-count" id="notification-count">0</span> <!-- Notification Badge -->
    </div>

    <!-- Notification Messages Box -->
    <div class="notification-box" id="notification-box">
    <h4>
        Pending Messages 
        <span class="notification-close" id="close-notification">&times;</span>
    </h4>
    <div class="notification-messages" id="notification-messages"></div>
</div>


    <script>
document.addEventListener("DOMContentLoaded", function () {
    function fetchNotificationCount() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                let notificationCount = document.getElementById('notification-count');
                if (data.count > 0) {
                    notificationCount.textContent = data.count;
                    notificationCount.style.display = "block";
                } else {
                    notificationCount.style.display = "none";
                }
            })
            .catch(error => console.error("Error fetching notification count:", error));
    }

    function fetchPendingMessages() {
        fetch('/notifications/messages')
            .then(response => response.json())
            .then(messages => {
                let messageBox = document.getElementById('notification-messages');
                messageBox.innerHTML = ""; // Clear existing messages
                
                if (messages.length === 0) {
                    messageBox.innerHTML = "<p>No pending messages.</p>";
                } else {
                    messages.forEach(msg => {
                        let messageItem = document.createElement("div");
                        messageItem.classList.add("notification-item");
                        messageItem.innerHTML = `
                            <p>${msg.message}</p>
                            <span class="close-btn">&times;</span>
                        `;

                        // Redirect to /vendors-request when clicking the message
                        messageItem.addEventListener("click", function () {
                            window.location.href = "/vendors-request";
                        });

                        // Stop click from closing the notification if clicked inside the close button
                        messageItem.querySelector(".close-btn").addEventListener("click", function (event) {
                            event.stopPropagation(); // Prevent redirect
                            messageItem.remove(); // Remove the notification
                        });

                        messageBox.appendChild(messageItem);
                    });
                }
            })
            .catch(error => console.error("Error fetching messages:", error));
    }

    document.getElementById('notification-button').addEventListener('click', function () {
        let box = document.getElementById('notification-box');
        if (box.style.display === "none" || box.style.display === "") {
            fetchPendingMessages();
            box.style.display = "block";
        } else {
            box.style.display = "none";
        }
    });

    document.getElementById('close-notification').addEventListener('click', function () {
        document.getElementById('notification-box').style.display = "none";
    });

    // Fetch notification count every 5 seconds
    fetchNotificationCount();
    setInterval(fetchNotificationCount, 5000);
});


    </script>   

<script>
function markAsSeen() {
    fetch('{{ route("notifications.markAsSeen") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Notifications marked as seen.');
        }
    })
    .catch(error => console.error('Error marking notifications as seen:', error));
}
</script>

<script>
$(document).ready(function() {
    $(".footer").off("click").on("click", function(event) {
        event.stopPropagation();
        event.preventDefault();
        return false;
    });
});
</script>


@endsection
