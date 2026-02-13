<style>
    /* Dropdown Menu Fix for Dark Navbar */
    .navbar .dropdown-menu {
        background-color: #0f1114 !important;
        border: none;
        padding: 0;
        min-width: 200px;
    }
    .navbar .dropdown-menu .dropdown-item {
        color: #ddd !important;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    .navbar .dropdown-menu .dropdown-item:hover,
    .navbar .dropdown-menu .dropdown-item:focus {
        background-color: #b3d33c !important;
        color: #000 !important;
    }

    /* Google Translate Styling to match your theme */
    #google_translate_element {
        display: inline-block;
        vertical-align: middle;
    }
    .goog-te-gadget-simple {
        background-color: transparent !important;
        border: 1px solid #ddd !important;
        padding: 4px !important;
        border-radius: 4px !important;
        font-size: 12px !important;
    }
    /* Hide the "Powered by" text for a cleaner look */
    .goog-te-gadget span { display: none !important; }
</style>

<div class="container-fluid bg-light py-1 px-4 d-none d-lg-block border-bottom">
    <div class="row align-items-center text-center gx-0">

        <div class="col-lg-3 py-1"> <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-geo-alt-fill me-2" style="color:#b3d33c; font-size:1.1rem;"></i>
                <div class="text-start">
                    <small class="d-block text-uppercase fw-semibold text-dark">Our Office</small>
                    <small class="text-muted">Vikas Nagar, Kanpur</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 py-1 border-start"> <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-envelope-fill me-2" style="color:#b3d33c; font-size:1.1rem;"></i>
                <div class="text-start">
                    <small class="d-block text-uppercase fw-semibold text-dark">Email Us</small>
                    <small><a href="mailto:info@blocinfra.com" class="text-muted text-decoration-none">info@blocinfra.com</a></small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 py-1 border-start border-end"> <div class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-telephone-fill me-2" style="color:#b3d33c; font-size:1.1rem;"></i>
                <div class="text-start">
                    <small class="d-block text-uppercase fw-semibold text-dark">Call Us</small>
                    <small class="text-muted">+91 73111 22392</small>
                </div>
            </div>
        </div>

        <div class="col-lg-3 py-1">
            <div id="google_translate_element"></div>
        </div>

    </div>
</div>
