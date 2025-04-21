@extends('vendor_layouts.app')

@section('content1')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- FontAwesome for Icons -->
<script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    @import url("https://fonts.googleapis.com/css2?family=Merriweather:wght@900&family=Mulish:wght@600&display=swap");

    body {
        background-color: #f7f8fc;
        font-family: "Mulish", sans-serif;
        margin: 0;
    }

    .container1 {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }

    .card1 {
        max-width: 450px;
        width: 100%;
        padding: 15px;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-top: -32px;
        position: relative;
        margin-left:-70px;
    }

    .card1:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .card1 h4 {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        text-align: center;
        margin-bottom: 15px;
        border-bottom: 2px solid #ff68a7;
        padding-bottom: 8px;
    }

    .vendor-table {
        width: 100%;
        border-collapse: collapse;
    }

    .vendor-table th,
    .vendor-table td {
        padding: 6px 8px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .vendor-table th {
        font-weight: bold;
        color: #222;
        width: 40%;
    }

    .vendor-table td {
        color: #444;
        width: 60%;
    }

    .edit-btn {
        background-color:rgb(177, 96, 248);
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        display: block;
        margin: 15px auto;
        text-align: center;
        transition: background 0.3s;
    }

    .edit-btn:hover {
        background-color: rgb(177, 96, 248);
    }

    /* Modal Styling */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        text-align: center;
        height:auto;
        
    }

    .modal input {
        width: 100%;
        padding: 5px;
        margin-bottom: 7px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .modal input[disabled] {
        background: #f2f2f2;
    }

    .close-btn1 {
        background-color: rgb(177, 96, 248);

        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 5px;
    }

    .save-btn {
        background-color:  rgb(177, 96, 248);
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .save-btn:hover {
        background-color: rgb(177, 96, 248);
    }

    .close-btn1:hover {
        background-color: #888;
    }

    @media (max-width: 768px) {
        .container1 {
            flex-direction: column;
            align-items: center;
            padding: 5px;
        }

        .card1 {
            width: 100%;
            margin-left: 5px;
            padding: 12px;
        }

        .modal-content {
            margin-top:-175px;
        }

        .notification-container {
    position: fixed;
    top: 35px !important;
    right: 100px;
    z-index: 1000;
}

/* Bell Icon Style */
.notification-icon {
    position: relative;
    font-size:10px; /* Bigger icon size */
    cursor: pointer;
    background: white; /* White background */
    color: black; /* Black bell icon */
    width:25px !important;
    height:25px !important;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2); /* Smooth shadow effect */
    transition: 0.3s ease-in-out;
}

/* Hover Effect */
.notification-icon:hover {
    background: #f8f9fa; /* Light hover effect */
    transform: scale(1.05);
}

/* Notification Count Badge */
.notification-count {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red; /* Red badge */
    color: white;
    font-size: 12px;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 20px;
    border-radius: 50%;
    font-weight: bold;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

/* Notification Box */
.notification-box {
    position: absolute;
    top:35px !important;
    right: 0;
    width: 300px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    padding: 15px;
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}

/* Notification Header */
.notification-box h4 {
    margin: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
    font-size: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Close Button */
.notification-close {
    cursor: pointer;
    color: red;
    font-size: 18px;
    transition: 0.3s;
}

.notification-close:hover {
    color: darkred;
}

/* Notification Messages */
.notification-messages {
    max-height: 200px;
    overflow-y: auto;
}

/* Notification Item */
.notification-item {
    background: #f1f2f6;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-item p {
    margin: 0;
    font-size: 14px;
}

/* Notification Close Button */
.notification-close-btn {
    background: none;
    border: none;
    color: red;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.notification-close-btn:hover {
    color: darkred;
}

/* Notification fade-in animation */
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
    }

    .header {
    background: linear-gradient(to right, #1d2b64, #f8cdda);
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    border-radius: 8px;
    margin-bottom: 15px;
}



    
</style>

<div class="container1">
    <div class="card1">
        <h4>Vendor Details</h4>
        <table class="vendor-table">
            <tr>
                <th>Vendor Name:</th>
                <td>{{ $vendor->name }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $vendor->email }}</td>
            </tr>
            <tr>
                <th>Phone Number:</th>
                <td>{{ $vendor->phone }}</td>
            </tr>
            <tr>
                <th>Company Name:</th>
                <td>{{ $vendor->company_name }}</td>
            </tr>


        </table>
        <button class="edit-btn" onclick="openModal()">Edit</button>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h4 >Edit Vendor Details</h4>
        <style>
    .form-group {
        display: flex;
        align-items: center;
        gap: 10px; /* Space between label and input */
        margin-bottom: 10px;
    }
    .form-group label {
        width: 150px; /* Set a fixed width for labels */
        font-weight: bold;
    }
    .form-group input {
        flex: 1; /* Make input take remaining space */
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgb(0 0 0 / 84%);
    justify-content: center;
    align-items: center;
}

.cancel{
    display:inline;
}


.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}

/* Bell Icon Style */
.notification-icon {
    position: relative;
    font-size:14px; /* Bigger icon size */
    cursor: pointer;
    background: white; /* White background */
    color: black; /* Black bell icon */
    width:40px;
    height:40px;
    right: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2); /* Smooth shadow effect */
    transition: 0.3s ease-in-out;
}

/* Hover Effect */
.notification-icon:hover {
    background: #f8f9fa; /* Light hover effect */
    transform: scale(1.05);
}

/* Notification Count Badge */
.notification-count {
    position: absolute;
    top: 5px;
    right:-10px;
    background: red; /* Red badge */
    color: white;
    font-size: 12px;
    width:18px;
    height:18px;
    text-align: center;
    line-height: 20px;
    border-radius: 50%;
    font-weight: bold;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

/* Notification Box */
.notification-box {
    position: absolute;
    top: 70px;
    right: 0;
    width: 300px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    padding: 15px;
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}

/* Notification Header */
.notification-box h4 {
    margin: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
    font-size: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Close Button */
.notification-close {
    cursor: pointer;
    color: red;
    font-size: 18px;
    transition: 0.3s;
}

.notification-close:hover {
    color: darkred;
}

/* Notification Messages */
.notification-messages {
    max-height: 200px;
    overflow-y: auto;
}

/* Notification Item */
.notification-item {
    background: #f1f2f6;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-item p {
    margin: 0;
    font-size: 14px;
}

/* Notification Close Button */
.notification-close-btn {
    background: none;
    border: none;
    color: red;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
}

.notification-close-btn:hover {
    color: darkred;
}

/* Notification fade-in animation */
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


</style>

<form action="{{ route('vendor.update', $vendor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Vendor Name:</label>
        <input type="text" name="name" value="{{ $vendor->name }}" placeholder="Enter name" required>
    </div>

    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" value="{{ $vendor->email }}" placeholder="Enter email" disabled>
    </div>

    <div class="form-group">
        <label>Phone Number:</label>
        <input type="text" name="phone" value="{{ $vendor->phone }}" placeholder="Enter phone number" required>
    </div>

    <div class="form-group">
        <label>Company Name:</label>
        <input type="text" name="company_name" value="{{ $vendor->company_name }}" placeholder="Enter company name" required>
    </div>

    <div class="form-buttons">
        <button type="button" class="close-btn1 cancel" onclick="closeModal()">Cancel</button>
        <button type="submit" class="save-btn">Update</button>
    </div>
</form>

    </div>
</div>

<!-- Notification Container -->
<div class="notification-container">
<div class="notification-icon" id="notification-button">
    <i class="fas fa-bell" style="color:#f2ce6b;"></i> <!-- Light Blue -->
    <span id="notification-count" class="notification-count" style="display: none;">0</span>
</div>


    <!-- Notification Box -->
    <div class="notification-box" id="notification-box" style="display: none;">
        <h4>Notifications <span id="close-notification" class="notification-close">✖</span></h4>
        <div class="notification-messages" id="notification-messages"></div>
    </div>
</div>




<script>
document.addEventListener("DOMContentLoaded", function () {
    // Fetch notification count
    function fetchNotificationCount() {
        fetch("{{ route('vendor.notifications.count') }}")
            .then(response => response.json())
            .then(data => {
                let countElement = document.getElementById("notification-count");
                if (countElement) {
                    countElement.textContent = data.count;
                    countElement.style.display = data.count > 0 ? "block" : "none";
                }
            })
            .catch(error => console.error("Error fetching notification count:", error));
    }

    // Fetch notifications for the logged-in vendor
    function fetchNotifications() {
        fetch("{{ route('vendor.notifications.messages') }}")
            .then(response => response.json())
            .then(data => {
                let messageBox = document.getElementById("notification-messages");
                messageBox.innerHTML = "";

                if (data.messages.length === 0) {
                    messageBox.innerHTML = "<p>No new notifications.</p>";
                } else {
                    data.messages.forEach(msg => {
                        let notificationItem = document.createElement("div");
                        notificationItem.classList.add("notification-item");
                        notificationItem.innerHTML = `
                            <p>${msg.message} - <strong>Your request has been completed successfully.</strong></p>
                            <button class="notification-close-btn" data-id="${msg.id}">✖</button>
                        `;
                        messageBox.appendChild(notificationItem);
                    });

                    // Attach event listeners to close buttons
                    document.querySelectorAll(".notification-close-btn").forEach(button => {
                        button.addEventListener("click", function () {
                            let notificationId = this.getAttribute("data-id");
                            markNotificationAsRead(notificationId, this);
                        });
                    });
                }
            })
            .catch(error => console.error("Error fetching notifications:", error));
    }

    // Mark notification as read and remove from DB
    function markNotificationAsRead(id, element) {
        fetch(`/vendor/notifications/read/${id}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                element.parentElement.remove(); // Remove notification from UI
                fetchNotificationCount(); // Update count
            }
        })
        .catch(error => console.error("Error marking notification as read:", error));
    }

    // Show/hide notification box
    document.getElementById("notification-button").addEventListener("click", function () {
        let box = document.getElementById("notification-box");
        if (box.style.display === "none" || box.style.display === "") {
            fetchNotifications();
            box.style.display = "block";
        } else {
            box.style.display = "none";
        }
    });

    // Close notification box
    document.getElementById("close-notification").addEventListener("click", function () {
        document.getElementById("notification-box").style.display = "none";
    });

    // Auto-fetch notifications count every 5 seconds
    fetchNotificationCount();
    setInterval(fetchNotificationCount, 5000);
});

</script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function openModal() {
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");

        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to update vendor details?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, update it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>


@endsection