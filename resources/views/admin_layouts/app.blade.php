<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="/admin_assets/assets/" data-template="vertical-menu-template-free">

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/images/favicon.jpeg')}}" type="image/x-icon">
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TIEPMD</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <!--<link rel="icon" type="image/x-icon" href="/admin_assets/assets/img/favicon.png" />-->

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="/admin_assets/assets/vendor/fonts/materialdesignicons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="/admin_assets/assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/admin_assets/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/admin_assets/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/admin_assets/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/admin_assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  
    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/admin_assets/assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/admin_assets/assets/js/config.js"></script>

    <!-- Bootstrap CSS -->
    <!--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">-->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

   



<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>

        body {
            zoom:80%;
        }

        td:first-child,
        th:first-child {
            border-radius: 10px 0 0 10px;
        }

        td:last-child,
        th:last-child {
            border-radius: 0 10px 10px 0;
        }
        #img {
        width: 200px;
        }
        #inputfield {
        padding: 12px 20px;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 10px;
        box-sizing: border-box;
        }
        #h1 {
        border-bottom: solid 2px grey;
        }
        #success {
        background: #C9F3C9;
        }
        #error {
        background: #FDBABA;
        }
        #warning {
        background: #FFE7C1;
        }
        #info {
        background: #BAC7DD;
        }
        #question {
        background: #E7DDD1;
        }
        .avatar {
        height: 28px; /* Set a fixed height for all avatars */
        width: 28px; /* Set a fixed width for all avatars */
        display: flex;
        justify-content: center;
        align-items: center;
        pointer-events: none;
        }

        .avatar-initial {
        font-size: 24px; /* Set a font size for the avatar icons */
        }

        .ms-3 {
        flex: 1; /* Allow the text content to take up remaining space */
        }
        .break-word {
        max-width: 130px; /* Adjust the maximum width as needed */
        white-space: pre-wrap;
        }
       

       .capnew
       {
        text-transform: capitalize;
       }
        .swal2-icon.swal2-error.swal2-icon-show {
    display: none !important;
}
/* Make SweetAlert modals smaller */
.swal2-popup {
    width: 300px !important; /* Adjust the width of the modal */
    font-size: 12px !important; /* Set a smaller font size */
    padding: 15px !important; /* Adjust padding */
}

/* Adjust the header text size */
.swal2-title {
    font-size: 16px !important;
}

/* Adjust the content (body) text size */
.swal2-html-container {
    font-size: 15px !important;
}

/* Adjust the button size */
.swal2-confirm, .swal2-cancel {
    font-size: 12px !important;
    padding: 5px 10px !important;
}


<style>
    /* WebKit browsers (Chrome, Safari) */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
<style>
.swal2-icon {
    display: none !important;
}
</style>

</head>

<body>
    
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            @include('admin_layouts.partials.sidebar')
            <!-- End Sidebar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('admin_layouts.partials.navbar')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('admin_layouts.partials.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!--Pop up-->
    {{-- <div>
        <h1>How to use and customize <img src="https://sweetalert2.github.io/images/swal2-logo.png"></h1>
        <div>
          <h4>Modal Type</h4>
          <p>Sweet alert with modal type and customize message alert with html and css</p>
          <button id="success">Success</button>
          <button id="error">Error</button>
          <button id="warning">Warning</button>
          <button id="info">Info</button>
          <button id="question">Question</button>
        </div>
        <br>
        <div>
          <h4>Custom image and alert size</h4>
          <p>Alert with custom icon and background icon</p>
          <button id="icon">Custom Icon</button>
          <button id="image">Custom Background Image</button>
        </div>
        <br>
        <div>
          <h4>Alert with input type</h4>
          <p>Sweet Alert with Input and loading button</p>
          <button id="subscribe">Subscribe</button>
        </div>
        <br>
        <div>
          <h4>Redirect to visit another site</h4>
          <p>Alert to visit a link to another site</p>
          <button id="link">Redirect to Utopian</button>
        </div>
      </div> --}}



 <!-- Hidden Modal -->
 <div class="modal fade" id="imageModalsnew" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex justify-content-center align-items-center"> <!-- Added classes to center image -->
                                  <img id="modalVehicleImage" src="" alt="Vehicle Image" class="img-fluid">
                                </div>
                              </div>
                            </div>
                          </div>

                      </div>

                      <div class="modal fade" id="imageModalsnews" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  
                                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex justify-content-center align-items-center"> <!-- Added classes to center image -->
                                  <img id="modalVehicleImage" src="" alt="Vehicle Image" class="img-fluid">
                                </div>
                              </div>
                            </div>
                          </div>

                      </div>
                   

       <script src="/admin_assets/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/admin_assets/assets/vendor/libs/popper/popper.js"></script>
    <script src="/admin_assets/assets/vendor/js/bootstrap.js"></script>
    <script src="/admin_assets/assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="/admin_assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="/admin_assets/assets/vendor/js/menu.js"></script>
   
    <script src="/admin_assets/assets/js/main.js"></script>
    <script src="/admin_assets/assets/js/dashboards-analytics.js"></script>
    <script src="/admin_assets/assets/js/ui-modals.js"></script>
    <script src="https://buttons.github.io/buttons.js" async defer></script>
    <script src="https://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>



    <script>
        $(document).ready(function () {
            $('#example, #example1, #example2, #example3, #material-table, #poptable, #example5').DataTable({
                paging: true,
                ordering: false,
                pageLength: 10
            });
        });
    </script>
    <script>
        $(document).on('click', '#success', function (e) {
            swal(
                'Success',
                'You clicked the <b style="color:green;">Success</b> button!',
                'success'
            )
        });
        $(document).on('click', '#error', function (e) {
            swal(
                'Error!',
                'You clicked the <b style="color:red;">error</b> button!',
                'error'
            )
        });
        $(document).on('click', '#warning', function (e) {
            swal(
                'Warning!',
                'You clicked the <b style="color:coral;">warning</b> button!',
                'warning'
            )
        });
        $(document).on('click', '#info', function (e) {
            swal(
                'Info!',
                'You clicked the <b style="color:cornflowerblue;">info</b> button!',
                'info'
            )
        });
        $(document).on('click', '#question', function (e) {
            swal(
                'Question!',
                'You clicked the <b style="color:grey;">question</b> button!',
                'question'
            )
        });
        $(document).on('click', '#icon', function (event) {
            swal({
                title: 'Custom icon!',
                text: 'Alert with a custom image.',
                imageUrl: 'https://image.shutterstock.com/z/stock-vector--exclamation-mark-exclamation-mark-hazard-warning-symbol-flat-design-style-vector-eps-444778462.jpg',
                imageWidth: 200,
                imageHeight: 200,
                imageAlt: 'Custom image',
                animation: false
            })
        });
        $(document).on('click', '#image', function (event) {
            swal({
                title: 'Custom background image, width and padding.',
                width: 700,
                padding: 150,
                background: '#fff url(https://image.shutterstock.com/z/stock-vector--exclamation-mark-exclamation-mark-hazard-warning-symbol-flat-design-style-vector-eps-444778462.jpg)'
            })
        });
        $(document).on('click', '#subscribe', function (e) {
            swal({
                title: 'Submit email to subscribe',
                input: 'email',
                inputPlaceholder: 'Example@email.xxx',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (email) => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            if (email === 'example@email.com') {
                                swal.showValidationError(
                                    'This email is already taken.'
                                )
                            }
                            resolve()
                        }, 2000)
                    })
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.value) {
                    swal({
                        type: 'success',
                        title: 'Thank you for subscribe!',
                        html: 'Submitted email: ' + result.value
                    })
                }
            })
        });
        $(document).on('click', '#link', function (e) {
            swal({
                title: "Are you sure?",
                text: "You will be redirected to https://utopian.io",
                type: "warning",
                confirmButtonText: "Yes, visit link!",
                showCancelButton: true
            })
                .then((result) => {
                    if (result.value) {
                        window.location = 'https://utopian.io';
                    } else if (result.dismiss === 'cancel') {
                        swal(
                            'Cancelled',
                            'Your stay here :)',
                            'error'
                        )
                    }
                })
        });
    </script>
   
<!-- <script>
        // Disable right-click
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Disable certain key presses (PrintScreen, F12, Ctrl+Shift+I/J/U, Ctrl+S, Ctrl+P, Ctrl+C, Ctrl+V, Ctrl+X, etc.)
        document.addEventListener('keydown', event => {
            const blockedKeys = [
                'PrintScreen', 'F12', 'F11', 'F5'
                /*,
                'c', 'C', 'x', 'X', 'v', 'V', 's', 'S', 'p', 'P', 'a', 'A', 'u', 'U',
                'I', 'J', 'U'*/
            ];
            const blockedCombinations = [
                'Shift+I', 'Shift+J', 'Shift+C', 'Shift+X', 'Shift+V', 'Shift+U',
                'Ctrl+S', 'Ctrl+P', 'Ctrl+U', 'Ctrl+C', 'Ctrl+X', 'Ctrl+V',
                'Ctrl+Shift+I', 'Ctrl+Shift+J', 'Ctrl+Shift+U',
                'Meta+S', 'Meta+P', 'Meta+U', 'Meta+C', 'Meta+X', 'Meta+V'
            ];

            const key = event.key;
            const combination = `${event.ctrlKey ? 'Ctrl+' : ''}${event.metaKey ? 'Meta+' : ''}${event.shiftKey ? 'Shift+' : ''}${key}`;

            if (blockedKeys.includes(key) || blockedCombinations.includes(combination)) {
                event.preventDefault();
            }

            // Clear clipboard data on PrintScreen
            if (key === 'PrintScreen') {
                setTimeout(() => {
                    navigator.clipboard.writeText('');
                }, 100);
                alert('Screenshots are disabled on this site.');
            }
        });

        // Continuously monitor and clear clipboard data
        setInterval(() => {
            navigator.clipboard.writeText('');
        }, 1000);

        // Disable copying content
        document.addEventListener('copy', event => event.preventDefault());
    </script>-->
  <script>
    $(document).ready(function () {

      
        $(document).on('submit', '.ajax-form', function (event) {
            event.preventDefault(); // Prevent full-page reload
            
            let form = $(this);
            let formData = new FormData(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: form.attr('method') || 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    form.find('button[type="submit"]').prop('disabled', true);
                },
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Action completed successfully!',
                    });

                    // Handle page updates dynamically without reload
                    if(response.redirect_url){
                        setTimeout(() => {
                            window.location.href = response.redirect_url;
                        }, 2000);
                    } else if(response.update_section){
                        $(response.update_section).html(response.updated_content);
                    } else {
                        form.trigger("reset"); // Reset the form on success
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors || { error: ['Something went wrong!'] };
                    let errorMessage = Object.values(errors).join('\n');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                    });
                },
                complete: function () {
                    form.find('button[type="submit"]').prop('disabled', false);
                }
            });
        });

       
        $(document).on('click', '.open-modal', function (event) {
            event.preventDefault();

            let modalTarget = $(this).data('target'); // Get modal ID
            let modalUrl = $(this).data('url'); // Get modal content URL

            $.ajax({
                url: modalUrl,
                type: 'GET',
                success: function (response) {
                    $(modalTarget).find('.modal-body').html(response);
                    $(modalTarget).modal('show');
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to load modal content.',
                    });
                }
            });
        });
    });
</script>

</body>
</html>
