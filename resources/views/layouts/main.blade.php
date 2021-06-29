<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="base-url" content="{{ url('') }}">
        <meta name="user-id" content="{{ auth()->user()->id }}">
        <title>@yield('title', isset($title) ? $title .' | '.env('APP_NAME') : env('APP_NAME'))</title>
        <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
        <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.png') }}"/>
        <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png" sizes="16x16">
        <link rel="stylesheet" href="{{ asset('vendor/pace/pace.css') }}">
        <script src="{{ asset('vendor/pace/pace.min.j') }}s"></script>
        <!--vendors-->
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-scrollbar/jquery.scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/timepicker/bootstrap-timepicker.min.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,500,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('fonts/jost/jost.css') }}">
        <!--Material Icons-->
        <link rel="stylesheet" type="text/css" href="{{ asset('fonts/materialdesignicons/materialdesignicons.min.css') }}">
        <!--Bootstrap + atmos Admin CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/atmos.css') }}">
        <!-- Additional library for page -->
        <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">

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
        <!--page specific scripts for demo-->
        <script src="{{ asset('vendor/DataTables/datatables.js')}}"></script>
        <script src="{{ asset('vendor/DataTables/colReorder.js')}}"></script>
        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/systemFunctions.js')}}"></script>
        <script src="{{ asset('js/general-ajax.js')}}"></script>
        <script src="{{ asset('js/validfunctions.js')}}"></script>
        <script src="{{ asset('js/globalFunctions.js')}}"></script>
        <script src="{{ asset('vendor/blockui/jquery.blockUI.js')}}"></script>
        <script src="{{ asset('vendor/timepicker/bootstrap-timepicker.min.js')}}"></script>
        <script src="{{ asset('js/bootstrap-input-spinner.js')}}"></script>
        <!--Additional Page includes-->
        <script src="{{ asset('vendor/apexchart/apexcharts.min.js')}}"></script>
        <!--chart data for current dashboard-->
        <script src="{{ asset('/js/dashboard-01.js')}}"></script>

        <script type="text/javascript">
            var baseUrl = "{{url('')}}";
        </script>
    </head>
    <body class="sidebar-pinned">
        <aside class="admin-sidebar">
            <div class="admin-sidebar-brand">
                <!-- begin sidebar branding-->
                <img class="admin-brand-logo" src="{{ asset('img/logo.png') }}" width="40" alt="atmos Logo">
                <span class="admin-brand-content font-secondary"><a href="/productos">  Energy Opening</a></span>
                <!-- end sidebar branding-->
                <div class="ml-auto">
                    <!-- sidebar pin-->
                    <a href="#" class="admin-pin-sidebar btn-ghost btn btn-rounded-circle"></a>
                    <!-- sidebar close for mobile device-->
                    <a href="#" class="admin-close-sidebar"></a>
                </div>
            </div>
            <div class="admin-sidebar-wrapper js-scrollbar">
                <ul class="menu">
                    @if (Auth::user()->tipo_usuario === 1)
                    <li class="menu-item {{ in_array($menu, ['Productos']) ? 'active' : ''}}">
                        <a href="/productos" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Productos</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-table-edit"></i>
                            </span>
                        </a>
                    </li>                    
                    <li class="menu-item {{ in_array($menu, ['Clientes']) ? 'active' : ''}}">
                        <a href="/clientes" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Clientes</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-account"></i>
                            </span>
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->tipo_usuario !== 1)
                        <li class="menu-item {{ in_array($menu, ['Realizar pedido']) ? 'active' : ''}}">
                            <a href="/realizar-pedido" class="menu-link">
                                <span class="menu-label">
                                    <span class="menu-name">Realizar pedido</span>
                                </span>
                                <span class="menu-icon">
                                    <i class="icon-placeholder mdi mdi-cart"></i>
                                </span>
                            </a>
                        </li>
                    @endif
                    <li class="menu-item {{ in_array($menu, ['Pedidos']) ? 'active' : ''}}">
                        <a href="/pedidos" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Pedidos</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-finance"></i>
                            </span>
                        </a>
                    </li>
                    <li class="menu-item {{ in_array($menu, ['Encuesta de servicios']) ? 'active' : ''}}">
                        <a href="/encuesta" class="menu-link">
                            <span class="menu-label">
                                <span class="menu-name">Encuesta de servicios</span>
                            </span>
                            <span class="menu-icon">
                                <i class="icon-placeholder mdi mdi-playlist-edit"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        <main class="admin-main">
            <!--site header begins-->
            <header class="admin-header">
                <a href="#" class="sidebar-toggle" data-toggleclass="sidebar-open" data-target="body"> </a>
                <nav class=" ml-auto">
                    <ul class="nav align-items-center">
                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#"   role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-sm avatar-online">
                                    <span class="avatar-title rounded-circle bg-dark">{{ substr(Auth::user()->nombre, 0, 5)}}</span>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right"   >
                                <a class="dropdown-item log-out" href="javascript:;">Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </header>
            <!--site header ends -->
            @yield('content')
        </main>

        
    </body>
</html>