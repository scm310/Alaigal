<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
    footer {
        background-color: {{ $footerSetting->color_code ?? '#222' }};
        color: #fff;
        padding: 20px 0;
        font-size: 14px;
    }

    footer h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    footer p, footer a {
        font-size: 14px;
        color: #ccc;
        margin-bottom: 8px;
    }

    footer a {
        text-decoration: none;
    }

    footer a:hover {
        color: #fff;
    }

    .social-icons a {
        font-size: 20px;
        margin: 0 10px;
        transition: color 0.3s ease-in-out;
    }

    .social-icons a:hover {
        color: #fff;
    }

    .copyright {
        font-size: 12px;
        color: #888;
        text-align: center;
        margin-top: 10px;
    }
</style>

<footer class="">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- Left Section: Copyright -->
            <div class="col-12 col-md-4  mb-md-2">
                <p>{{ $gs->copyright_text }}.</p>
            </div>

            <!-- Center Section: Social Media Icons -->
            <div class="col-12 col-md-4 text-center">
                <h3>Follow Us</h3>
                <div class="d-flex justify-content-center gap-3">
                    <a  >
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a >
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a >
                        <i class="bi bi-twitter"></i>
                    </a>
                </div>
            </div>

            <!-- Right Section: Designed By -->
            <div class="col-12 col-md-4 text-center text-md-end">
                <span>
                Powered by Accelerated Development Machines</span>
            </div>
        </div>


    </div>
</footer>
