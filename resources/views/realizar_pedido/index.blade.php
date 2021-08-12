@extends('layouts.main')

@section('content')
<section class="admin-content">
    @include('realizar_pedido.modal')
    <div class=" bg-dark m-b-30 bg-stars">
        <div class="bg-title">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-lg-9 text-white p-t-40 p-b-60">
                        {{-- <h1>Contactos</h1> --}}
                        <div class="row">
                            {{-- <div class="col-12 col-md-auto text-center pb-3">
                                <img src="{{asset('/img/logo.png')}}" width="140" alt="">
                            </div> --}}
                            <div class="col">
                                <p class="opacity-75 mb-0 mt-4">
                                    En Energy Opening estamos comprometidos a ofrecer la más alta calidad en todos nuestros productos, garantizando la satisfacción de nuestros clientes. <br><br>                                      
                                </p>
                                <!--<ul class="opacity-75">
                                    <li>Aceptamos todas las formas de pago</li>
                                    <li>Costos Aproximados</li>
                                    <li>Haz tu pedido hoy y recíbelo mañana</li>
                                    <li>No cobramos envío</li>
                                    <li>Mínimo de compra $500 (Gdl y Zapopan) y $1000 (Tlaquepaque, Tonala, Tlajomulco)</li>
                                </ul>-->
                            </div>
                        </div>
                        
                    </div>
                    <div class="d-none col-md-2 col-lg-3 m-auto text-white p-t-40 p-b-90 general-info" data-url="{{url("realizar-pedido")}}" data-refresh="table" data-el-loader="card">
                        
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
                        <div class="col-12 col-md">
                            <h2 class="">Realizar pedido</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end" id="loading-div">
                            <div class="col mt-2 text-center my-3">
                                <img src="{{ asset('img/loading.gif') }}" style="width: 100%; max-width: 80px;">
                            </div>
                        </div>
                        <div class="row align-items-end d-none">
                            <div class="col-auto mt-2">
                                <label  class="font-secondary">Producto:</label><br>
                                <select  class="form-control js-select2 selectProducto" id="selectProductoTodos" style="width: 200px;">
                                    @foreach($productos as $producto)
                                        <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if (Auth::user()->tipo_usuario === 1)
                            <div class="col-auto mt-2" style="width: 130px;">                                
                                <label  class="font-secondary">Precio base:</label><br>
                                <div id="precio_base" style="margin-bottom: 6px; font-size: 15px; font-weight: bold; margin-top: 7px;">
                                </div>                                
                            </div>
                            @else
                            <div class="col-auto mt-2 d-none" style="width: 130px;">                                
                                <label  class="font-secondary">Precio base:</label><br>
                                <div id="precio_base" style="margin-bottom: 6px; font-size: 15px; font-weight: bold; margin-top: 7px;">
                                </div>                                
                            </div>
                            @endif
                            <div class="col-auto mt-2" style="width: 170px;">
                                @if (Auth::user()->tipo_usuario === 1)
                                <label  class="font-secondary">Precio especial:</label><br>
                                @else
                                <label  class="font-secondary">Precio:</label><br>
                                @endif
                                <div id="precio_especial" style="margin-bottom: 6px; font-size: 15px; font-weight: bold; margin-top: 7px;">
                                </div>
                            </div>
                            <div class="col-auto mt-2">
                                <label  class="font-secondary">Producto:</label><br>
                                <select  class="form-control js-select2" id="selectCantidades" style="width: 150px;">
                                    <option value="10000">10,000 LTS</option>
                                    <option value="15000">15,000 LTS</option>
                                    <option value="30000">30,000 LTS</option>
                                </select>
                            </div>
                            <div class="col-auto mt-2">
                                <button class="btn btn-primary" id="btn-agregar">Agregar</button>
                            </div>
                        </div>
                        <div id="content-pedido">
                                    
                        </div>
                        <div class="mt-3">
                            <div class="content-product mb-3" style="padding-top: 20px">
                                <div class="">
                                    <span class="font-weight-bold float-right" style="font-size: 22px;">Total: <span id="total-pedido">$0.00</span></span><br><br>
                                    <p class="float-right" style="font-size: 20px;">Costo aproximado, este es el precio base sin flete.</p>
                                    <br>
                                    <br>
                                    <br>
                                    {{-- <small class="float-right" style="font-size: 20px;"></small><br> --}}
                                    <a class="float-right" target="_blank" href="https://wa.link/3a8znv">
                                        <div class="row align-items-center">
                                            <i class="col-auto px-0 mdi mdi-whatsapp" style="font-size: 30px; color: #06d755;"></i>
                                            <span class="col pl-2">+52 1 33 2968 8853</span>
                                        </div>                                            
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
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

<script type="text/javascript">
    var baseUrl     = "{{url('')}}";
    refreshModal = false;

    var direcciones = {!! json_encode($direcciones) !!};


    $.each(direcciones, function(i, row) {  
        var direccionHtml = row.calle+" "+row.numero_exterior;
        if(row.numero_interior) {
            direccionHtml+= " Int. "+row.numero_interior;
        }
        direccionHtml+= " - Col. "+row.colonia+" - "+row.municipio+", "+row.estado+'. C.P: '+row.codigo_postal;
        row.direccion = direccionHtml;
        $("#selectDirecciones").append('<option data-row='+"'"+JSON.stringify(row)+"'"+' value="'+row.id+'">'+row.direccion+'</option>');
        if(i == 0)
            $("#lblFlete").html(row.flete + ' - $' + numberWithCommas(row.importe_flete.toFixed(4)));
    });

    $('body').delegate('#selectDirecciones','change', function() {
        var vcDireccion = $(this).children('option:selected').data("row");
        $("#lblFlete").html(vcDireccion.flete + ' - $' + numberWithCommas(vcDireccion.importe_flete.toFixed(4)));
    });

    $("#fecha_entrega").attr("min", getMinDay());

    window.onbeforeunload = function(e) {
        return true;
    }

    function getMinDay() {
        var today = new Date();
        today.setDate(today.getDate() + 2);
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd;
        } 
        if(mm<10){
            mm='0'+mm;
        } 
        return yyyy+'-'+mm+'-'+dd;
    }

    $(".selectProducto").on("change", function(){
        var vcProducto = $(this).children('option:selected').data("row");
        $("#precio_base").html("$"+numberWithCommas(vcProducto.precio_base.toFixed(4)));
        if(vcProducto.user) {
            if(vcProducto.user.tipo_precio != "precio_manual") {
                $("#precio_especial").html("$"+numberWithCommas(vcProducto[vcProducto.user.tipo_precio].toFixed(4)));
            } else {
                $("#precio_especial").html("$"+numberWithCommas(vcProducto.user.precio.toFixed(4)));
            }                
        } else {
            $("#precio_especial").html("Sin precio especial");
        }
    });

    $("#loading-div").next().removeClass("d-none");
    $("#loading-div").remove();

    $("#selectProductoTodos").trigger("change");

    $("#btn-agregar").click(function(e){
        if ($("#selectProductoTodos").val() != "") {
            if($("#content-pedido").find('.content-product').length == 0){
                var vcProducto = $("#selectProductoTodos").children('option:selected').data("row");            
                if (vcProducto) {
                    var costo = vcProducto.precio_base.toFixed(4);
                    if(vcProducto.user) {
                        if(vcProducto.user.tipo_precio != "precio_manual") {
                            costo = vcProducto[vcProducto.user.tipo_precio].toFixed(4);
                        } else {
                            costo = vcProducto.user.precio.toFixed(4);
                        }
                    }
                    var vfTotalProduct = parseFloat(parseFloat($("#selectCantidades").val()) * costo).toFixed(4);
                    $("#content-pedido").append('<div class="content-product" data-row='+"'"+JSON.stringify(vcProducto)+"'"+'>'+
                                                    '<div class="row align-items-center">'+
                                                        '<div class="col-12 col-md-5 pb-3 pb-md-0">'+
                                                            '<div class="product-name font-weight-bold">'+
                                                                vcProducto.nombre+
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
                                                                '<div class="col col-md-auto mt-3 mt-md-0">'+
                                                                    '<div style="width: 180px; font-size: 17px;" class="inpCant" data-cantidad="'+$("#selectCantidades").val()+'">'+
                                                                        numberWithCommas($("#selectCantidades").val())+ ' LTS'+
                                                                    '</div>'+
                                                                '</div>'+
                                                                '<div class="col col-md-auto mt-3 mt-md-0">'+
                                                                    '<div style="width: 180px; font-size: 17px;" class="inpCant" data-cantidad="'+$("#selectCantidades").val()+'">'+
                                                                        '$'+numberWithCommas(parseFloat(costo).toFixed(4))+
                                                                    '</div>'+
                                                                '</div>'+
                                                                '<div class="col-auto mt-3 mt-md-0" style="min-width: 140px;">'+
                                                                    '<div class="text-right total-product">$'+numberWithCommas(vfTotalProduct)+'</div>'+
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
            } else {
                swal({
                    position: 'top-right',
                    icon: 'error',
                    title: 'Solo se puede agregar un producto por pedido.',
                    buttons: false,
                    timer: 1500
                });
            }
            
        }
    });

    function configurarProductos() {
        $(".btn-elim-product").off("click").click(function(){
            $(this).closest(".content-product").remove();
            calculaTotal();
            $(".tooltip").remove();
        });
    }

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
            var vcDireccion = $("#selectDirecciones").children('option:selected').data("row");
            $("#first-view, #first-back, #cont-pedido-modal").hide();
            $("#second-back, #env-pedido").show("250");
            $("#pedido-nombre").html("{{auth()->user()->nombre}}");
            $("#pedido-email").html("{{auth()->user()->email}}");
            $("#pedido-direccion").html(vcDireccion.direccion);
            $("#pedido-flete").html(vcDireccion.flete + ' - $' + numberWithCommas(vcDireccion.importe_flete.toFixed(4)));
            $("#pedido-observaciones").html($("#observaciones").val());
            if($("#observaciones").val()) {
                $("#pedido-observaciones").closest(".row").show();
            } else {
                $("#pedido-observaciones").closest(".row").hide();
            }
            $("#pedido-fecha-entrega").html($("#fecha_entrega").val());
            $("#pedido-telefono").html("{{auth()->user()->telefono}}");
            $("#pedido-content").html("");
            var total = 0;
            var flete = 0;
            $.each(products, function(i, elem) {  
                var item = $(elem).data("row");
                var costo = item.precio_base.toFixed(4);
                if(item.user) {
                    if(item.user.tipo_precio != "precio_manual") {
                        costo = item[item.user.tipo_precio].toFixed(4);
                    } else {
                        costo = item.user.precio.toFixed(4);
                    }
                }
                
                item.total = parseFloat(parseFloat($(elem).find(".inpCant").data("cantidad")) * costo).toFixed(4);
                total = total + (parseFloat($(elem).find(".inpCant").data("cantidad")) * costo);
                flete = flete + (parseFloat($(elem).find(".inpCant").data("cantidad")) * vcDireccion.importe_flete);
                var htmlProd = '<div class="content-product" style="padding: 20px 0 32px;">'+
                                    '<div class="row align-items-center">'+
                                        '<div class="col">'+
                                            '<div class="product-name font-weight-bold">'+
                                                item.nombre+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-auto">'+
                                            '<div class="row align-items-center">'+
                                                '<div class="col mt-3 mt-md-0"  style="font-size: 18px; min-width: 130px;">';
                                    htmlProd +=     numberWithCommas(parseFloat($(elem).find(".inpCant").data("cantidad"))) + " LTS";
                                htmlProd +=     '</div>'+
                                                '<div class="col mt-3 mt-md-0 view-div"  style="font-size: 18px;">';
                                    htmlProd +=     '$'+numberWithCommas(parseFloat(costo).toFixed(4)) + "";      
                                htmlProd +=     '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                    htmlProd += '</div>';

                    $("#pedido-content").append(htmlProd);
            });
            total = total + flete;
            $("#flete-total").html(numberWithCommas(parseFloat(flete).toFixed(4)));
            $("#pedido-total").html(numberWithCommas(parseFloat(total).toFixed(4)));
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

    $("#second-back").click(function(){
        $("#first-view, #first-back, #cont-pedido-modal").show();
        $("#second-view, #second-back, #env-pedido").hide();
    });

    function calculaTotal() {
        var products = $("#content-pedido .content-product"),
            vfTotal  = 0;
        $.each(products, function(i, elem) {       
            if ($(elem).data("row")) {
                var vcProducto = $(elem).data("row");
                var costo = vcProducto.precio_base.toFixed(4);
                if(vcProducto.user) {
                    if(vcProducto.user.tipo_precio != "precio_manual") {
                        costo = vcProducto[vcProducto.user.tipo_precio].toFixed(4);
                    } else {
                        costo = vcProducto.user.precio.toFixed(4);
                    }
                }
                console.log(costo, $(elem).find(".inpCant"));
                vfTotal = vfTotal + (costo * parseFloat($(elem).find(".inpCant").data("cantidad")));
            }
        });

        $("#total-pedido").html("$"+numberWithCommas(vfTotal.toFixed(4)));

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
                arrayProd.push({producto_id : item.id, cantidad: $(elem).find(".inpCant").data("cantidad")});
            });
            
            formData.append("productos", JSON.stringify(arrayProd));
            formData.append("direccion", $("#selectDirecciones").children('option:selected').data("row").direccion);
            formData.append("direccion_id", $("#selectDirecciones").val());
            
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
                                    innerHTML:"Hemos recibido tu pedido, nos pondremos en contacto por WhatsApp para cualquier duda.<br><br>¡Gracias por elegir Energy Opening! "
                                },
                            },
                            closeOnClickOutside: false,
                            closeOnEsc: false
                        }).then(function(){
                        }).catch(swal.noop);
                    }

                    $("#content-pedido").html("");
                    calculaTotal();
                    $("input[name=observaciones]").val("");
                    $("input[name=fecha_entrega]").val("");
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
@endsection