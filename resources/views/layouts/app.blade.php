<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
<style>
.main-panel {
    width: calc(100% - 165px);
}
.fa {
    color: #F69EAF;
}

body, .table thead th, .sidebar, .sidebar .nav .nav-item.active > .nav-link .menu-title, h1, .h1, h2, h3, h4, h5, h6, .h2, .h3, .h4, .h5, .h6 ,
.form-control, .typeahead, .tt-query, .tt-hint, .select2-container--default .select2-selection--single .select2-search__field, .select2-container--default .select2-selection--single, .form-select{
  font-family: "Libre Baskerville", serif;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
}
.form-control, .typeahead, .tt-query, .tt-hint, .select2-container--default .select2-selection--single .select2-search__field, .select2-container--default .select2-selection--single, .form-select{
    font-size: 18px;
}
.content-wrapper {
    background: #FFFAFB;
    padding: 10px;
}
.table td {
    color: #858796;
}
table {
    border-color: #ccc !important;
}
.sidebar {
    background: #FFE9F0;
        width: 165px;
}
select {
    height: 54px;
    border-radius: 2px !important;
}
.navbar .navbar-brand-wrapper .navbar-brand img {
    height: 70px;
}
.navbar, .navbar .navbar-brand-wrapper {
    background: #FFF5F8;
}
li.nav-item {
    border-bottom: 1px solid #ffffff !important;
}
.sidebar .nav .nav-item.active, .sidebar .nav .nav-item:hover {
    background: #FFFAFB;
    color: #000;
}
.sidebar .nav .nav-item {
    padding: 0 7px;
}
.sidebar .nav.sub-menu .nav-item .nav-link.active {
    color: #000 !important;
}
button.btn.btn-primary, button.btn.btn-primary:hover {
    background: #DC1921;
    border: 1px solid #DC1921;
}
span.menu-title, sidebar .nav .nav-item .nav-link i.menu-arrow:before {
    color: #000000 !important;
}
.cst_sec{
    line-height: 25px !important;
}
.sidebar .nav .nav-item .nav-link i.menu-icon {
    margin-left: 0px;
    margin-right: 10px;
}
.navbar .navbar-menu-wrapper .navbar-nav .nav-item .nav-link i {
    font-size: 14px;
    margin-top: 4px;
}
.sidebar .nav .nav-item.active > .nav-link i, .sidebar .nav .nav-item .nav-link i {
    color: #F69EAF;
    margin-right: 15px;
}
.animate-text span {
    opacity: 0;
    display: inline-block;
    animation: fadeUp 0.6s forwards;
}
button.btn.btn-primary, button.btn.btn-primary:hover {
    background: #DC1921;
    border: 1px solid #DC1921;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice{
    padding: 10px 5px !important;
}
select.form-select {
    color: #000;
}
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.cst_sec{
        line-height: 55px;
    border: 1px solid #ccc;
    padding: 50px 25px;
    width: 100%;
    border-radius: 10px;
}
ul.pagination {
    margin-top: 20px;
    float: right;
}
.active span.page-link {
    background: #1bcfb4;
    border: 1px solid #1bcfb4;
}
.sidebar .nav.sub-menu .nav-item .nav-link.active {
    color: #06b99d;
}
.img_wrap {
    padding: 20px;
}
.img_wrap img {
    width: 100%;
}
.addfund th, .addfund td{
    background: aliceblue;
}
img{
    width: 100%;
}
.certificate {
    height: 600px;
    background: url('http://127.0.0.1:8000/assets/images/w23.png');
    background-size: cover;
    background-position: center;

    display: flex;
    justify-content: center;   /* horizontal center */
    align-items: center;       /* vertical center */
    text-align: center;
}

.certificate-content h1 {
    font-size: 30px;
    font-weight: 600;
}

.certificate-content h2 {
    font-size: 24px;
    font-weight: 600;
    margin-top: 10px;
}

.certificate-content h3 {
    font-size: 22px;
    font-weight: 600;
    margin-top: 10px;
}

.certificate-content p {
    font-size: 18px;
    margin-top: 20px;
}

.certificate-content .date {
    font-size: 16px;
}
.certificate-content {
    width: 800px;
    margin-top: 100px;
}
@media print {
    @page {
        size: A4;
        margin: 0;
    }

    #certificate-print {
        width: 210mm;
        height: 297mm;
    }
}


@media print {
    body {
        margin: 0;
        background: #fff;
    }

    .navbar,
    .sidebar,
    .page-header,
    footer {
        display: none !important;
    }

    #certificate-print {
        display: block !important;
        width: 210mm;
        height: 297mm;
        margin: auto;
    }
    #certificate-print {
        background: url('http://127.0.0.1:8000/assets/images/w23.png') center/cover no-repeat !important;

        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
   
    #certificate-print {
        display: block;
        border: 2px solid red;
        height: 300px;
    }
    .printBtn {
        display: none;

    }

}
</style>
       
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            
<div class="container-fluid page-body-wrapper">
    
                @include('layouts.sidebar')
            <!-- Page Content -->
            
                <div class="main-panel">
                    <div class="content-wrapper">
                        <main>
                            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow" style="margin-bottom: 20px;">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                

            @endisset
                {{ $slot }}
                </main>
</div>
</div>
            
            <div>
        </div>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
   <!-- Place the first <script> tag in your HTML's <head> -->


    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqDeI1dXB5eZnzzGcqepqwzqn9HYk2LzY&libraries=places&callback=initGoogle" async defer></script>  
<script>
    
    function initGoogle() {
        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input, {
            componentRestrictions: { country: "ca" }, // restrict to Canada
            types: ["address"] // optional: only address results
        });
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            var postalCode = '';
            var city = '';
            for (var i = 0; i < place.address_components.length; i++) {
                var component = place.address_components[i];
                if (component.types.includes('postal_code')) {
                    postalCode = component.long_name;
                }
                if (component.types.includes('locality')) {
                    city = component.long_name;
                }
            }
            document.getElementById('postal_code').value = postalCode;
            document.getElementById('city').value = city;
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            document.getElementById('latlong').value = place.geometry.location.lat() + ',' +  place.geometry.location.lng();
        });
    }

    function capitalizeWords(input) {
        input.value = input.value.replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }
    function smalleWords(input) {
        input.value = input.value.toLowerCase();
    }

    $(document).ready(function () {
        $('#contact').on('input', function () {
            var mobileNumber = $(this).val();

            // Allow only digits
            mobileNumber = mobileNumber.replace(/\D/g, '');

            // Limit input to 10 digits
            if (mobileNumber.length > 10) {
                mobileNumber = mobileNumber.substring(0, 10);
            }

            $(this).val(mobileNumber);

            // Show error if the number is not exactly 10 digits
            if (mobileNumber.length === 10) {
                $('#error-message').hide();
            } else {
                $('#error-message').show();
            }
        });
    });
</script>


    </body>
</html>
