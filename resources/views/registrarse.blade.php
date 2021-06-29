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
            <div class="col-lg-4  bg-white">
                <div class="row align-items-center m-h-100">
                    <div class="mx-auto col-md-8">
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto rounded mb-3" style="padding: 10px; background-color: #212841;">
                                <img src="{{asset('/img/logo.png')}}" width="120" alt="">
                            </div>
                            <div class="col"></div>
                        </div>
                        <h3 class="text-center p-b-20 fw-400">Registrate</h3>
                        <form id="form-data" onsubmit="return false;"  class="needs-validation" action="/clientes/save" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="redirect" data-redirect="true" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
                            @csrf
                            <div class="form-row d-none">
                                <div class="form-group col-12">
                                    <label>registo</label>
                                    <input type="text" class="form-control" name="registro" value="si">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control not-empty" name="nombre" placeholder="Nombre" data-msg="Nombre">
                                </div>
                            </div>
                            <div class="form-row">        
                                <div class="form-group col-12">
                                    <label>Correo electrónico</label>
                                    <input type="email" id="email" name="email" data-msg="Correo electrónico" class="form-control not-empty email"/>
                                </div>        
                            </div>

                            <div class="form-row">        
                                <div class="form-group col-md-6">
                                    <label>Contraseña</label>
                                    <input type="password" id="password" name="password" data-msg="Contraseña" class="form-control not-empty confirm"/>
                                </div>      
                                <div class="form-group col-md-6">
                                    <label>Confirmar contraseña</label>
                                    <input type="password" id="password_confirm" name="password_confirm" data-msg="Confirmar contraseña" class="form-control"/>
                                </div>   
                            </div>

                            <div class="form-row">        
                                <div class="form-group col-md-6">
                                    <label>Teléfono</label>
                                    <input type="number" id="telefono" name="telefono" data-msg="Teléfono" class="form-control not-empty numeric"/>
                                </div> 
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg save" data-target-id="form-data">Registrarse</button>

                        </form>
                    </div>

                </div>
            </div>
            <div class="col-lg-8 d-none d-md-block bg-cover" style="background-image: url({{asset('img/bg-login.jpg')}});">

            </div>
        </div>
    </div>
</main>
<script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('vendor/blockui/jquery.blockUI.js')}}"></script>
<script src="{{ asset('vendor/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('vendor/popper/popper.js')}}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('vendor/select2/js/select2.full.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('vendor/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{ asset('js/general-ajax.js')}}"></script>
<script src="{{ asset('js/globalFunctions.js')}}"></script>
<!--<script src="{{ asset('vendor/pace/pace.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{ asset('vendor/popper/popper.js')}}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

<script src="{{ asset('vendor/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{ asset('vendor/listjs/listjs.min.js')}}"></script>
<script src="{{ asset('vendor/moment/moment.min.js')}}"></script>
<script src="{{ asset('vendor/daterangepicker/daterangepicker.js')}}"></script>-->
<!--<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('js/atmos.min.js')}}"></script>




<script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
{{-- <script src="https://js.pusher.com/4.1/pusher.min.js"></script> --}} -->

<!--page specific scripts for demo-->

<!--Additional Page includes-->
<!--<script src="{{ asset('vendor/apexchart/apexcharts.min.js')}}"></script> -->

<script src="{{ asset('js/validfunctions.js')}}"></script>

</body>
</html>