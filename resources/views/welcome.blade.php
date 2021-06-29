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
        <title>Energy Opening</title>
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
    </head>
    <body class="sidebar-pinned">
        <main class="admin-main p-0">
            <!-- Modal -->
            <div class="modal fade modal-slide-right" id="contForm" tabindex="-1" role="dialog" aria-labelledby="slideRightModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="slideRightModalLabel">Formulario de pedido</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form id="form-data" action="" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
                                <div id="first-view">
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control not-empty" name="nombre" placeholder="Nombre" data-msg="Nombre" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label>Correo electrónico</label>
                                            <input type="text" class="form-control email not-empty" name="email" placeholder="example@gmail.com" data-msg="Correo electrónico" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label>Dirección</label>
                                            <textarea type="text" class="form-control not-empty" name="direccion" placeholder="Dirección" data-msg="Dirección" rows="3" required style="resize: none;"></textarea> 
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-12">
                                            <label>Teléfono</label>
                                            <input type="text" class="form-control not-empty" name="telefono" placeholder="Teléfono" data-msg="Teléfono" required>
                                        </div>
                                    </div>
                                </div>
                                <div id="second-view">
                                    <div class="pedido-header">
                                        <div class="row align-items-start mb-3">
                                            <div class="col">
                                                <img class="admin-brand-logo" src="{{ asset('img/logo.jpeg') }}" width="100" alt="Logo">
                                            </div>
                                        </div>
                                        <div class="row align-items-start">
                                            <div class="col-auto font-weight-bold pr-0" style="width: 85px;">
                                                Nombre:
                                            </div>
                                            <div class="col pl-0" id="pedido-nombre">
                                            </div>
                                        </div>
                                        <div class="row align-items-start">
                                            <div class="col-auto font-weight-bold pr-0" style="width: 85px;">
                                                Teléfono:
                                            </div>
                                            <div class="col pl-0" id="pedido-telefono">
                                            </div>
                                        </div>
                                        <div class="row align-items-start">
                                            <div class="col-auto font-weight-bold pr-0" style="width: 85px;">
                                                Email:
                                            </div>
                                            <div class="col pl-0" id="pedido-email">
                                            </div>
                                        </div>
                                        <div class="row align-items-start">
                                            <div class="col-auto font-weight-bold pr-0" style="width: 85px;">
                                                Dirección:
                                            </div>
                                            <div class="col pl-0" id="pedido-direccion">
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div id="pedido-content">
                                            
                                    </div>
                                    <div class="content-product"  style="padding: 14px 0 32px;">
                                        <div class="row align-items-center">
                                            <div class="col-12 text-right">
                                                <span class="font-weight-bold float-right" style="font-size: 22px;">Total: $<span id="pedido-total"></span></span><br><br>
                                                <small class="">Costo aproximado.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="first-back" data-dismiss="modal">Regresar</button>
                            <button type="button" class="btn btn-secondary" id="second-back">Regresar</button>
                            <button id="cont-pedido-modal" type="button" class="btn btn-success" data-target-id="form-data">Continuar con el pedido</button>
                            <button id="env-pedido" type="submit" class="btn btn-success" data-target-id="form-data">Confirmar pedido</button>
                        </div>
                    </div>
                </div>
            </div>
            <section class="admin-content">
            <div class="m-b-30 bg-stars">
                <div class="bg-title">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10 col-lg-9 text-white p-t-40 p-b-60">
                                {{-- <h1>Contactos</h1> --}}
                                <div class="row">
                                    <div class="col-12 col-md-auto text-center pb-3">
                                        <img src="{{asset('/img/logo.png')}}" width="140" alt="">
                                    </div>
                                    <div class="col">
                                        <p class="opacity-75 mb-0">
                                            En Geomarket estamos comprometidos a ofrecer la más alta calidad y frescura en todos nuestros productos, garantizando la satisfacción de nuestros clientes. <br><br>
                                            Haz tu pedido ahora y recíbelo mañana en tu casa:<br>                                        
                                        </p>
                                        <ul class="opacity-75">
                                            <li>Aceptamos todas las formas de pago</li>
                                            <li>Costos Aproximados</li>
                                            <li>Haz tu pedido hoy y recíbelo mañana</li>
                                            <li>No cobramos envío</li>
                                            <li>Mínimo de compra $500 (Gdl y Zapopan) y $1000 (Tlaquepaque, Tonala, Tlajomulco)</li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="d-none col-md-2 col-lg-3 m-auto text-white p-t-40 p-b-90 general-info" data-url="{{url("pedidos")}}" data-refresh="table" data-el-loader="card">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container pull-up">
                <div class="row">
                    {{-- Table --}}
                    <div class="col-lg-12 m-b-30">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="">Pedidos</h2>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-end" id="loading-div">
                                    <div class="col mt-2 text-center my-3">
                                        <img src="{{ asset('img/loading.gif') }}" style="width: 100%; max-width: 80px;">
                                    </div>
                                </div>
                                <div class="row align-items-end d-none">
                                    <div class="col-auto mt-2">
                                        <label  class="font-secondary">Categorías:</label><br>
                                        <select  class="form-control js-select2" id="selectCategorias" style="width: 250px;">
                                            @if($frutas)
                                                <option selected value="Frutas">Frutas</option>
                                            @endif
                                            @if($verduras)
                                                <option value="Verduras">Verduras</option>
                                            @endif
                                            @if($cereales)
                                                <option value="Cereales">Cereales</option>
                                            @endif
                                            @if($lacteos)
                                                <option value="Lacteos">Lácteos</option>
                                            @endif
                                            @if($carnicos)
                                                <option value="Carnicos">Carnicos</option>
                                            @endif
                                            @if($abarrotes)
                                                <option value="Abarrotes">Abarrotes</option>
                                            @endif
                                            <option value="Todos">Todos los productos</option>
                                        </select>
                                    </div>
                                    <div class="col-auto mt-2">
                                        <label  class="font-secondary">Producto:</label><br>
                                        @if($frutas)
                                            <select  class="form-control js-select2 selectProducto" id="selectProductoFrutas" style="width: 250px;">
                                                @foreach($frutas as $producto)
                                                    <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @if($verduras)
                                            <select  class="form-control js-select2 selectProducto" id="selectProductoVerduras" style="width: 250px; display: none;">
                                                @foreach($verduras as $producto)
                                                    <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @if($cereales)
                                            <select  class="form-control js-select2 selectProducto" id="selectProductoCereales" style="width: 250px; display: none;">
                                                @foreach($cereales as $producto)
                                                    <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @if($lacteos)
                                            <select  class="form-control js-select2 selectProducto" id="selectProductoLacteos" style="width: 250px; display: none;">
                                                @foreach($lacteos as $producto)
                                                    <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @if($carnicos)
                                            <select  class="form-control js-select2 selectProducto" id="selectProductoCarnicos" style="width: 250px; display: none;">
                                                @foreach($carnicos as $producto)
                                                    <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @if($abarrotes)
                                            <select  class="form-control js-select2 selectProducto" id="selectProductoAbarrotes" style="width: 250px; display: none;">
                                                @foreach($abarrotes as $producto)
                                                    <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <select  class="form-control js-select2 selectProducto" id="selectProductoTodos" style="width: 250px;">
                                            @foreach($productos as $producto)
                                                <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-auto mt-2" style="width: 180px;">
                                        <label for="inpCant">Cantidad:</label>
                                        <input type="number" class="form-control" id="inpCant" min="0.01"  step="0.5" data-decimals="2" value="1">
                                    </div>
                                    <div class="col-auto mt-2">
                                        <button class="btn btn-primary" id="btn-agregar">Agregar</button>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-link" id="btn-product-nuevo" style="border: 0; background: transparent; box-shadow: unset;">
                                            ¿No encontraste<br>tu producto?
                                        </button>
                                    </div>
                                </div>
                                <div id="content-pedido">
                                    
                                </div>
                                <div class="mt-3">
                                    <div class="content-product mb-3" style="padding-top: 20px">
                                        <div class="">
                                            <span class="font-weight-bold float-right" style="font-size: 22px;">Total: <span id="total-pedido">$0.00</span></span><br><br>
                                            <small class="float-right">Costo aproximado.</small><br>
                                            <a class="float-right" href="https://wa.link/p5oahu">
                                                <div class="row align-items-center">
                                                    <i class="col-auto px-0 mdi mdi-whatsapp" style="font-size: 30px; color: #06d755;"></i>
                                                    <span class="col pl-2">+52 1 33 3477 1410</span>
                                                </div>                                            
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary float-right" data-target="#contForm" id="cont-pedido" disabled>Continuar con el pedido</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </main>

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
            var baseUrl     = "{{url('')}}";
            refreshModal = false;

            $("#inpCant").inputSpinner();

            window.onbeforeunload = function(e) {
                return true;
            }

            $("#selectCategorias").on("change", function(){
                $('.selectProducto').next(".select2-container").hide();
                $('#selectProducto'+$(this).val()).next(".select2-container").show();

                $('#selectProducto'+$(this).val()).trigger("change");
            });

            $(".selectProducto").on("change", function(){
                var cate       = $("#selectCategorias").val();
                var vcProducto = $("#selectProducto"+cate+" option[value="+$("#selectProducto"+cate).val()+"]").data("row");
                $("#inpCant").attr("min", "1");
                $("#inpCant").attr("step", "1");
                $("#inpCant").attr("data-decimals", "0");
                $("#inpCant").val(1);
            });

            $("#selectCategorias").trigger("change");

            $("#loading-div").next().removeClass("d-none");
            $("#loading-div").remove();

            $("#btn-product-nuevo").click(function(e) {
                var vcProducto = {
                                    isOtro: true
                                 }
                $("#content-pedido").append('<div class="content-product" data-row='+"'"+JSON.stringify(vcProducto)+"'"+'>'+
                                                '<div class="row align-items-center">'+
                                                    '<div class="col-12 col-md-5 pb-3 pb-md-0">'+
                                                        '<div class="product-name font-weight-bold">'+
                                                            'Otro'+
                                                            '<button class="d-block d-md-none text-secondary btn-elim-product" style="position: absolute; top: 0; right: 15px;" data-toggle="tooltip" title="Eliminar producto">'+
                                                                    '<i class="mdi mdi-delete" style="font-size: 19px;"></i>'+
                                                            '</button>'+
                                                        '</div>'+
                                                        '<div>'+
                                                            '<button class="text-danger btn-elim-product d-none d-md-block" data-toggle="tooltip" title="Eliminar producto">Eliminar</button>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="col-12 col-md-7">'+
                                                        '<div class="row align-items-center">'+
                                                            '<div class="col-12 col-md">'+
                                                                '<textarea type="text" class="form-control nota" placeholder="Producto que desea" rows="2" style="resize: none;"></textarea>'+
                                                            '</div>'+
                                                            '<div class="col col-md-auto mt-3 mt-md-0">'+
                                                                '<div style="width: 180px;">'+
                                                                    '<input type="number" class="form-control inpCant" min="0.01"  step="0.5" data-decimals="2" value="1">'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-auto mt-3 mt-md-0" style="min-width: 140px;">'+
                                                                '<div class="text-right total-product"></div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>');
                swal({
                  position: 'top-right',
                  icon: 'success',
                  title: 'Producto agregado correctamente.',
                  buttons: false,
                  timer: 1500
                });
                configurarProductos();
                calculaTotal();
            });

            $("#btn-agregar").click(function(e){
                var cate       = $("#selectCategorias").val();
                if (parseFloat($("#inpCant").val()) > 0 && $("#selectProducto"+cate).val() != "") {
                    var vcProducto = $("#selectProducto"+cate+" option[value="+$("#selectProducto"+cate).val()+"]").data("row");
                    if (vcProducto) {
                        var vcMin = "1",
                            vcStep = "1",
                            vcDecimals = "0";
                        var vfTotalProduct = parseFloat(parseFloat($("#inpCant").val()) * vcProducto.costo).toFixed(2);
                        $("#content-pedido").append('<div class="content-product" data-row='+"'"+JSON.stringify(vcProducto)+"'"+'>'+
                                                        '<div class="row align-items-center">'+
                                                            '<div class="col-12 col-md-5 pb-3 pb-md-0">'+
                                                                '<div class="product-name font-weight-bold">'+
                                                                    vcProducto.nombre+ ' ('+vcProducto.unidad.abreviacion+')'+
                                                                    '<button class="d-block d-md-none text-secondary btn-elim-product" style="position: absolute; top: 0; right: 15px;" data-toggle="tooltip" title="Eliminar producto">'+
                                                                            '<i class="mdi mdi-delete" style="font-size: 19px;"></i>'+
                                                                    '</button>'+
                                                                '</div>'+
                                                                '<div>'+
                                                                    '<button class="text-danger btn-elim-product d-none d-md-block" data-toggle="tooltip" title="Eliminar producto">Eliminar</button>'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-12 col-md-7">'+
                                                                '<div class="row align-items-center">'+
                                                                    '<div class="col-12 col-md">'+
                                                                        '<textarea type="text" class="form-control nota" placeholder="Nota" rows="2" style="resize: none;"></textarea>'+
                                                                    '</div>'+
                                                                    '<div class="col col-md-auto mt-3 mt-md-0">'+
                                                                        '<div style="width: 180px;">'+
                                                                            '<input type="number" class="form-control inpCant" value="'+$("#inpCant").val()+'" min="'+vcMin+'"  step="'+vcStep+'" data-decimals="'+vcDecimals+'">'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                    '<div class="col-auto mt-3 mt-md-0" style="min-width: 140px;">'+
                                                                        '<div class="text-right total-product">$'+vfTotalProduct+'</div>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>');
                        
                        swal({
                          position: 'top-right',
                          icon: 'success',
                          title: 'Producto agregado correctamente.',
                          buttons: false,
                          timer: 1500
                        });
                        configurarProductos();
                        calculaTotal();
                    }
                }
            });

            function configurarProductos() {
                $(".btn-elim-product").off("click").click(function(){
                    $(this).closest(".content-product").remove();
                    calculaTotal();
                    $(".tooltip").remove();
                });

                $.each($(".inpCant[type=number]"), function(i, elem) {
                    var $elem = $(elem);
                    if (!$elem.next(".input-group").length) {
                        $elem.inputSpinner();
                    }
                });

                $(".inpCant[type=number]").off("change").change(function(){
                    var $this   = $(this),
                        elemRow = $this.closest(".content-product"),
                        row     = elemRow.data("row");
                    elemRow.find(".total-product").html("$"+parseFloat(parseFloat($this.val() * row.costo)).toFixed(2));
                    calculaTotal();
                });
            }

            function calculaTotal() {
                var products = $("#content-pedido .content-product"),
                    vfTotal  = 0;
                $.each(products, function(i, elem) {       
                    if ($(elem).data("row").isOtro == undefined) {
                        vfTotal = vfTotal + ($(elem).data("row").costo * parseFloat($(elem).find(".inpCant").val()));
                    }
                });

                $("#total-pedido").html("$"+vfTotal.toFixed(2));

                if (vfTotal > 0) {
                    $("#cont-pedido").prop("disabled", false);
                } else {
                    $("#cont-pedido").prop("disabled", true);
                }
            }

            $("#cont-pedido").click(function(){
                if ($("#content-pedido .content-product").length) {
                    var route = $('div.general-info').data('url');
                    var target = $(this).data('target');
                    $('div'+target+' form').get(0).setAttribute('action', route.concat('/save'));
                    /*Se muestra lo necesario*/
                    $("#first-view, #first-back, #cont-pedido-modal").show();
                    /*Se oculta lo necesario*/
                    $("#second-view, #second-back, #env-pedido").hide();
                    $('div'+target).modal();
                } 
            });

            $("#second-back").click(function(){
                $("#first-view, #first-back, #cont-pedido-modal").show();
                $("#second-view, #second-back, #env-pedido").hide();
            });

            $("#cont-pedido-modal").click(function(){
                var inputs = [];
                var msgError = '';
                var form = $(this).data('target-id') ? $('form#'+$(this).data('target-id')) : $(this).closest('form');
                form.find('input, select, textarea').each(function(i,e) {
                    if ( $(this).hasClass('not-empty') ) {//Required fields
                        if ( !$(this).val() || $(this).val() == 0 ) {//If empty or nothing selected
                            if ($(this).hasClass('select2') || $(this).hasClass('select2-js')) {
                                $(this).parent().children('span.select2').addClass("select-error");
                            } else if ($(this).hasClass('selectpicker')) {//Si es un selectpicker se agrega un error especial
                                $(this).parent().children('button.dropdown-toggle').addClass("select-error");
                            } else if ($(this).hasClass('custom-file-input')) {//
                                $(this).parent().addClass("file-error");
                            } else {
                                $(this).parent().addClass('has-error');
                            }
                            inputs.push($(this).data('msg'));
                            msgError = msgError +"<li>"+$(this).data('msg')+": Campo vacío</li>";
                        } else {
                            if ($(this).hasClass('select2') || $(this).hasClass('select2-js')) {
                                $(this).parent().children('span.select2').removeClass("select-error");
                            } else if ($(this).hasClass('selectpicker')) {
                                $(this).parent().children('button.dropdown-toggle').removeClass("select-error");
                            } else if ($(this).hasClass('custom-file-input')) {
                                $(this).parent().removeClass("file-error");
                            } else {
                                $(this).parent().removeClass('has-error');
                            }
                        }
                    }
                    var re_email = /^(?:[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,6})?$/;
                    if ( $(this).hasClass('email') ) {
                        if(!$(this).val().match(re_email)) {
                            /*if ( !$(this).parent().hasClass("has-error") ) {*///If has content but it is not the correct
                                $(this).parent().addClass('has-error');
                                inputs.push($(this).data('msg'));
                                msgError = msgError +"<li>"+$(this).data('msg')+": Correo inválido</li>";
                            /*}*/
                        }
                    }
                });
                var products = $("#content-pedido .content-product");

                if (products.length == 0) {
                    inputs.push("Productos");
                    msgError = msgError +"<li>Productos: Sin productos</li>";
                }

                if (inputs.length == 0) {
                    $("#first-view, #first-back, #cont-pedido-modal").hide();
                    $("#second-back, #env-pedido").show("250");
                    $("#pedido-nombre").html($("input[name=nombre]").val());
                    $("#pedido-email").html($("input[name=email]").val());
                    $("#pedido-direccion").html($("textarea[name=direccion]").val());
                    $("#pedido-telefono").html($("input[name=telefono]").val());
                    $("#pedido-content").html("");
                    var total = 0;
                    $.each(products, function(i, elem) {  
                        var item = $(elem).data("row");
                        if (item.isOtro != undefined) {
                            item.nombre = "Otro";
                            item.total = '';
                        } else {
                            item.nombre = item.nombre + " (" + item.unidad.abreviacion + ")";
                            item.total = parseFloat($(elem).find(".inpCant").val() * item.costo).toFixed(2);
                            total = total + ($(elem).find(".inpCant").val() * item.costo);
                        }
                        var htmlProd = '<div class="content-product" style="padding: 20px 0 32px;">'+
                                            '<div class="row align-items-center">'+
                                                '<div class="col-12 col-md-6 pb-3 pb-md-0">'+
                                                    '<div class="product-name font-weight-bold">'+
                                                        item.nombre+
                                                    '</div>'+
                                                '</div>'+
                                                '<div class="col-12 col-md-6">'+
                                                    '<div class="row align-items-center">'+
                                                        '<div class="col mt-3 mt-md-0"  style="font-size: 18px;">';
                                            htmlProd +=     $(elem).find(".inpCant").val();
                                        htmlProd +=     '</div>'+
                                                        '<div class="col-auto mt-3 mt-md-0">'+
                                                            '<span class="text-right total-product">$'+item.total+'</span>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>';
                            if ($(elem).find(".nota").val() != "") {
                                htmlProd += '<div class="row align-items-center mt-2">'+
                                                '<div class="col-auto font-weight-bold pr-0" style="width: 85px;">Nota:</div>'+
                                                 '<div class="col pl-0">'+
                                                    $(elem).find(".nota").val()+   
                                                '</div>'+
                                            '</div>';
                            }
                            htmlProd += '</div>';

                            $("#pedido-content").append(htmlProd);
                    });
                    $("#pedido-total").html(parseFloat(total).toFixed(2));
                    $("#second-view").show(500);
                } else {
                    swal({
                        title: 'Verifique los siguientes campos: ',
                        icon: 'error',
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML:"<ul class='error_list'>"+msgError+"</ul>"
                            },
                        }
                    }).catch(swal.noop);
                    $(".guardar").prop( "disabled", false ).removeClass('disabled');
                    return false;
                }
            });

            $("#env-pedido").on('click', function() {
                var inputs = [];
                var msgError = '';
                var form = $(this).data('target-id') ? $('form#'+$(this).data('target-id')) : $(this).closest('form');

                form.find('input, select, textarea').each(function(i,e) {
                    if ( $(this).hasClass('not-empty') ) {//Required fields
                        if ( !$(this).val() || $(this).val() == 0 ) {//If empty or nothing selected
                            if ($(this).hasClass('select2') || $(this).hasClass('select2-js')) {
                                $(this).parent().children('span.select2').addClass("select-error");
                            } else if ($(this).hasClass('selectpicker')) {//Si es un selectpicker se agrega un error especial
                                $(this).parent().children('button.dropdown-toggle').addClass("select-error");
                            } else if ($(this).hasClass('custom-file-input')) {//
                                $(this).parent().addClass("file-error");
                            } else {
                                $(this).parent().addClass('has-error');
                            }
                            inputs.push($(this).data('msg'));
                            msgError = msgError +"<li>"+$(this).data('msg')+": Campo vacío</li>";
                        } else {
                            if ($(this).hasClass('select2') || $(this).hasClass('select2-js')) {
                                $(this).parent().children('span.select2').removeClass("select-error");
                            } else if ($(this).hasClass('selectpicker')) {
                                $(this).parent().children('button.dropdown-toggle').removeClass("select-error");
                            } else if ($(this).hasClass('custom-file-input')) {
                                $(this).parent().removeClass("file-error");
                            } else {
                                $(this).parent().removeClass('has-error');
                            }
                        }
                    }
                    var re_email = /^(?:[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,6})?$/;
                    if ( $(this).hasClass('email') ) {
                        if(!$(this).val().match(re_email)) {
                            /*if ( !$(this).parent().hasClass("has-error") ) {*///If has content but it is not the correct
                                $(this).parent().addClass('has-error');
                                inputs.push($(this).data('msg'));
                                msgError = msgError +"<li>"+$(this).data('msg')+": Correo inválido</li>";
                            /*}*/
                        }
                    }
                });

                var products = $("#content-pedido .content-product");

                if (products.length == 0) {
                    inputs.push("Productos");
                    msgError = msgError +"<li>Productos: Sin productos</li>";
                }

                if (inputs.length == 0) {
                    loadingMessage('Enviando...')

                    ajaxType = form.data('ajax-type');
                    config = {
                        'redirect'        : form.data('redirect'),
                        'refresh'         : form.data('refresh'),
                        'column'          : form.data('column'),
                        'table_class'     : form.data('table_class'),
                        'container_class' : form.data('container_class'),
                        'callback'        : form.data('callback'),
                        'keep_modal'      : form.data('keep_modal'),
                    }
                    var form_id = form.attr('id');
                    var formData = new FormData($("form#"+form_id)[0]);

                    var arrayProd = [];
                    $.each(products, function(i, elem) {  
                        var item = $(elem).data("row");     
                        if ($(elem).data("row").isOtro == undefined) {
                            arrayProd.push({producto_id : item.id, cantidad: $(elem).find(".inpCant").val(), nota: $(elem).find(".nota").val()});       
                        } else {
                            arrayProd.push({producto_id: 0, cantidad: $(elem).find(".inpCant").val(), nota: $(elem).find(".nota").val()});
                        }
                    });
                    
                    formData.append("productos", JSON.stringify(arrayProd));
                    
                    $.ajax({
                        method: "POST",
                        type: "POST",
                        url: $("form#"+form_id).attr('action'),
                        data: formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            if (! config.keep_modal ) { $('div.modal').modal('hide'); }
                            if ( swal.getState().isOpen ) { swal.close(); }
                            unBlockElement(config.element_class);
                            
                            if(! config.callback ) {
                                swal({
                                    title: 'Bien',
                                    icon: "success",
                                    content: {
                                        element: "div",
                                        attributes: {
                                            innerHTML:"Hemos recibido tu pedido y se entregará el día de mañana, nos pondremos en contacto por WhatsApp para cualquier duda.<br><br>¡Gracias por elegir Geomarket! "
                                        },
                                    },
                                    closeOnClickOutside: false,
                                    closeOnEsc: false
                                }).then(function(){
                                    swal({
                                        title: data.status == 'success' ? 'Bien: ' : 'Bien:',
                                        icon: data.status ? data.status : "success",
                                        content: {
                                            element: "div",
                                            attributes: {
                                                innerHTML:"<p class='text-response'>"+data.msg ? data.msg : "¡Pedido enviado exitosamente!"+"</p>"
                                            },
                                        },
                                        buttons: false,
                                        closeOnEsc: false,
                                        closeOnClickOutside: false,
                                        timer: 2000
                                    }).catch(swal.noop);
                                }).catch(swal.noop);
                            }

                            $("#inpCant").val(1);
                            $("#content-pedido").html("");
                            calculaTotal();
                            $("input[name=nombre]").val("");
                            $("input[name=email]").val("");
                            $("textarea[name=direccion]").val("");
                            $("input[name=telefono]").val("");
                        },
                        error: function(xhr, status, error) {
                            displayAjaxError(xhr, status, error, config);
                        }
                    });
                } else {
                    swal({
                        title: 'Verifique los siguientes campos: ',
                        icon: 'error',
                        content: {
                            element: "div",
                            attributes: {
                                innerHTML:"<ul class='error_list'>"+msgError+"</ul>"
                            },
                        }
                    }).catch(swal.noop);
                    $(".guardar").prop( "disabled", false ).removeClass('disabled');
                    return false;
                }
            });
        </script>
    </body>
</html>