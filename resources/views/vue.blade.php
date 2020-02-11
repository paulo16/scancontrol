<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'scancontrol') }}</title>

    <!-- Scripts -->
    <script src="{{asset('assets/libs/PDFObject/pdfobject.min.js')}}"></script> 
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" />

    <!--Morris Chart-->
    <link rel="stylesheet" href="{{asset('assets/libs/morris-js/morris.css')}}"/>
    <link href="{{asset('assets/libs/custombox/custombox.min.css')}}" rel="stylesheet">

    <!-- App css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"  />
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" />

   <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body>


<!-- Navigation Bar-->
@include('layouts.navbar')
<!-- End Navigation Bar-->

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->

<div id="app" class="wrapper">
    <div>
            
         <app></app>     

    </div> <!-- end container -->
</div>
<!-- end wrapper -->

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                2016 - 2019 &copy; Adminto theme by <a href="">Coderthemes</a> 
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-sm-block">
                    <a href="javascript:void(0);">About Us</a>
                    <a href="javascript:void(0);">Help</a>
                    <a href="javascript:void(0);">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</footer>

@routes <!-- Permet a vuejs d'utiliser les route de laravel grace au package ziggy -->
<!-- end Footer -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor js -->
<script type="text/javascript" src="{{asset('assets/js/vendor.min.js')}}"></script>

<!-- knob plugin -->
<script type="text/javascript" src="{{asset('assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

<!-- Modal-Effect -->
<script type="text/javascript" src="{{asset('assets/libs/custombox/custombox.min.js')}}"></script>

<!--- For PDF --->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>

<!-- App js-->
<script type="text/javascript" src="{{asset('assets/js/app.min.js')}}"></script>

</body>
</html>