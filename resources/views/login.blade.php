<!DOCTYPE html>
<html lang="en">
<head>
    
        <title>Energy Opening - Iniciar Sesión</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">

        <!--vendors-->
        <!--<link rel="stylesheet" type="text/css" href="https://rawgit.com/noppa/text-security/master/dist/text-security.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-scrollbar/jquery.scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/timepicker/bootstrap-timepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('fonts/jost/jost.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/dropzone/dropzone.css') }}">-->
        <!--Material Icons-->
        <!--<link rel="stylesheet" type="text/css" href="{{ asset('fonts/materialdesignicons/materialdesignicons.min.css') }}">-->
        <!--Bootstrap + atmos Admin CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/atmos.css') }}">
        <!-- Additional library for page -->
        <!--<link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css')}}">
        <link rel="stylesheet" href="{{ asset('vendor/DataTables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css')}}">

        {{-- Summernote --}}
        <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-bs4.css') }}"/>-->

</head>
<body class="jumbo-page">

<main class="admin-main  ">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-4" style="background-color: #404040;">
                <div class="row align-items-center m-h-100">
                    <div class="mx-auto col-md-8">
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto rounded mb-3" style="padding: 10px; text-align: center;">
                                <img src="{{asset('/img/logo-login.png')}}" style="width: 60%;" alt="">
                            </div>
                            <div class="col"></div>
                        </div>
                        <h3 class="text-center p-b-20 fw-400" style="color: #e9642b;">Login</h3>
                        <form class="needs-validation" action="/login" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group floating-label col-md-12">
                                    <label>Email</label>
                                    <input name="email" type="email" required class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group floating-label col-md-12">
                                    <label>Password</label>
                                    <input name="password" type="password" placeholder="Contraseña" required class="form-control "  >
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>

                        </form>

                        <div style="width: 100%; text-align: center; margin-top: 30px; font-size: 16px; color: #e9642b;">
                            ¿Aún no tienes cuenta? <a href="/registrarse" style="color: #f2ae89;"><strong>Registrate</strong></a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 d-none d-md-block" style="text-align: right; background-color: #404040; padding-right: 0;">
                <img style="max-width: 100%; max-height: 100vh;" src="{{asset('img/bg-login.jpg')}}"></img>
            </div>
        </div>
    </div>
</main>


<!--<script src="{{ asset('vendor/pace/pace.min.js') }}"></script>
<script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{ asset('vendor/popper/popper.js')}}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('vendor/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('vendor/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{ asset('vendor/listjs/listjs.min.js')}}"></script>
<script src="{{ asset('vendor/moment/moment.min.js')}}"></script>
<script src="{{ asset('vendor/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('js/atmos.min.js')}}"></script>
<script src="{{ asset('vendor/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('vendor/blockui/jquery.blockUI.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('vendor/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
{{-- <script src="https://js.pusher.com/4.1/pusher.min.js"></script> --}} -->

<!--page specific scripts for demo-->

<!--Additional Page includes-->
<!--<script src="{{ asset('vendor/apexchart/apexcharts.min.js')}}"></script> -->


</body>
</html>