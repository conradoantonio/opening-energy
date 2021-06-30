@extends('layouts.main')

@section('content')
<style>
    .dataTables_filter, .dataTables_length{
        display: none;
    }
</style>
<section class="admin-content">
    @include('pedidos.modal')
    @include('pedidos.details_modal')
    <div class="m-b-30 bg-stars">
        <div class="bg-title">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 m-auto text-white p-t-40 p-b-90">
                        {{-- <h1>Contactos</h1>
                        <p class="opacity-75">
                            Aquí podrá visualizar y modificar los contactos.
                        </p> --}}
                    </div>
                    <div class="col-md-4 m-auto text-white p-t-40 p-b-90 general-info" data-url="{{url("pedidos")}}" data-refresh="table" data-el-loader="card">
                        
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
                        <div class="row">
                            <div class="col-12 col-md">
                                <h2 class="">Lista de pedidos</h2>
                            </div>
                            <div class="col-12 col-md-auto text-right">
                                <a href="javascript:;" class="icon refresh-content-ped"><i class="mdi mdi-refresh"></i> </a>
                                @if (Auth::user()->tipo_usuario === 1)
                                <button class="btn btn-dark download-pedidos" type="button"><i class="mdi mdi-download"></i> Descargar excel</button>
                                <!--<button class="btn btn-dark email-pedidos" data-target="#editForm" type="button"><i class="mdi mdi-email"></i> Enviar por correo</button>-->
                                @endif
                            </div>
                            <div class="col-12 mt-2">
                                <div class="row align-items-center">
                                    <div class="col">
                                        Inicialmente, sólo se muestran un máximo de 100 registros, utilice los filtros para hacer su busqueda más adeacuada a lo que requiera.
                                        <br>
                                        Los filtros de fecha hacen referencía al campo fecha de entrega.
                                    </div>
                                    @if (Auth::user()->tipo_usuario === 1)
                                        <!--<div class="col-auto mt-2 text-right">
                                            <button class="btn btn-dark print-pedidos" type="button"><i class="mdi mdi-printer"></i> Imprimir</button>
                                        </div>-->
                                    @endif
                                </div>                                
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end" style="padding-bottom: 15px;">
                            <div class="col-12" style="padding-bottom: 15px; font-size: 20px; font-weight: bold;">
                                Filtros
                            </div>
                            <div class="col-auto">
                                <label>Estado:</label>
                                <select  class="form-control js-select2 not-empty" id="estado_ped" style="width: 150px;">
                                    <option value="todos">Todos</option>
                                    <option value="atendido">Atendido</option>
                                    <option value="pendiente">Pendiente</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <label>Desde:</label>
                                <input value="" type="date" class="form-control not-empty" name="fecha_ini" id="fecha_ini" placeholder="Desde" style="width: 170px;"></input>
                            </div>
                            <div class="col-auto">
                                <label>Hasta:</label>
                                <input value="" type="date" class="form-control not-empty" name="fecha_fin" id="fecha_fin" placeholder="Hasta" style="width: 170px;"></input>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary" data-toggle="tooltip" data-placement="top" id="btn_search_ped" title="Buscar">Buscar</button>
                                <button class="btn btn-secondary refresh-content-ped" data-toggle="tooltip" data-placement="top" id="btn_limpiar_ped" title="Buscar">Limpiar filtros</button>
                            </div>
                        </div>
                        <div class="table-responsive rows-container">
                            @include('pedidos.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $('body').delegate('.print-row','click', function(e) {
        e.stopPropagation();
        var row = $.extend(true, {}, $(this).data('row'));
        imprimirPedido([row]);
    });

    $('body').delegate('.details-row','click', function(e) {
        e.stopPropagation();
        var route = $('div.general-info').data('url');
        var row = $(this).data('row');
        var target = $(this).data('target');
        console.log(route);
        //Set action url to form
        $('div'+target+' form').get(0).setAttribute('action', route.concat('/update/documentacion'));

        var target = $(this).data('target');
        
        setFormDocumentacion(row, target, false, {{Auth::user()->tipo_usuario}});
        
        $("#printDiv").prop("disabled", false);
        $('div'+target).modal();
    });

    $('body').delegate('.btn-d-file','click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var form = $(this).closest('form');
        var input = $(this).parent().parent().find('input').first();
        var $this = $(this);
        if($(this).data('file')) {
            var formData = new FormData();
            formData.append("id",form.find('input[name=id]').val());
            formData.append("file",$(this).data('file'));
            loadingMessage('Descargando...');
            $.ajax({
                url: $(".general-info").data("url")+'/documentacion/download',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function (data) {
                    var a = document.createElement('a');
                    var url = window.URL.createObjectURL(data);
                    a.href = url;
                    a.download = form.find('input[name=id]').val() + "_" +$this.data('file').split("/")[$this.data('file').split("/").length - 1];
                    document.body.append(a);
                    a.click();
                    a.remove();
                    window.URL.revokeObjectURL(url);
                    if ( swal.getState().isOpen ) { swal.close(); }
                }
            });
            return false;
        } else {
            swal({
                title: 'Error',
                icon: "error",
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<p class='text-response'>"+"Sin documento para descargar"+"</p>"
                    },
                },
                buttons: false,
                closeOnEsc: false,
                closeOnClickOutside: false,
                timer: 2000
            }).catch(swal.noop);
            return;
        }
        
    });
    
    $('#table-pedi tbody').on( 'click', 'tr', function (e) {
        if (!$(e.target).is("button") && !$(e.target).is("i")) {
            $(this).toggleClass('selected');
        }
    } );

    $('body').delegate('.print-pedidos','click', function() {
        var seleccionados = $("#table-pedi").dataTable().api().rows('.selected').nodes(),
            rows          = [];
        if (seleccionados.length) {
            $.each(seleccionados, function(i, elem) {
                rows.push($(elem).find(".print-row").data("row"));
            });
            imprimirPedido(rows);
        } else {
            swal({
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<p class='text-response'>Se debe elegir al menos un pedido para imprimir.</p>"
                    },
                },
                buttons: false,
                closeOnEsc: false,
                closeOnClickOutside: false,
                timer: 2000
            }).catch(swal.noop);
        }
    });

    function imprimirPedido(pedidos) {
        swal({
            title: 'Error',
            icon: "error",
            content: {
                element: "div",
                attributes: {
                    innerHTML:"<p class='text-response'>"+"Funcionalidad no desarrollada"+"</p>"
                },
            },
            buttons: false,
            closeOnEsc: false,
            closeOnClickOutside: false,
            timer: 2000
        }).catch(swal.noop);
        return;
        var mywindow = window.open('', 'PRINT');
        var htmlPed =   '<html>'+
                            '<head>'+
                                $("html").find("head").html()+
                            '</head>'+
                            '<body style="background-color: #fff;">';
        $.each(pedidos, function(i, elem){
            htmlPed +=          '<div class="imp-ped-indi">'+
                                    '<table class="mb-4">'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<td width="120" style="vertical-align: initial;">'+
                                                    '<img class="admin-brand-logo" src="{{ asset('img/logo.jpeg') }}" width="120" alt="atmos Logo">'+
                                                '</td>'+
                                                '<td>'+
                                                    '<div class="row align-items-end">'+
                                                        '<div class="col-auto text-right col-text">'+
                                                            '<span class="font-weight-bold">FECHA Y HORA</span>'+
                                                        '</div>'+
                                                        '<div class="col p-0 mr-4 col-resp">'+
                                                            elem.created_at+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="row align-items-end">'+
                                                        '<div class="col-auto text-right col-text">'+
                                                            '<span class="font-weight-bold">NOMBRE</span>'+
                                                        '</div>'+
                                                        '<div class="col p-0 mr-4 col-resp">'+
                                                            elem.nombre+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="row align-items-end">'+
                                                        '<div class="col-auto text-right col-text">'+
                                                            '<span class="font-weight-bold">DOMICILIO</span>'+
                                                        '</div>'+
                                                        '<div class="col p-0 mr-4 col-resp">'+
                                                            elem.direccion+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="row align-items-end">'+
                                                        '<div class="col-auto text-right col-text">'+
                                                            '<span class="font-weight-bold">TELÉFONO</span>'+
                                                        '</div>'+
                                                        '<div class="col p-0 mr-4 col-resp">'+
                                                            elem.telefono+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="row align-items-end">'+
                                                        '<div class="col-auto text-right col-text">'+
                                                            '<span class="font-weight-bold">EMAIL</span>'+
                                                        '</div>'+
                                                        '<div class="col p-0 mr-4 col-resp">'+
                                                            elem.email+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="row align-items-end">'+
                                                        '<div class="col-auto text-right col-text">'+
                                                            '<span class="font-weight-bold">FIRMA DE PAGO</span>'+
                                                        '</div>'+
                                                        '<div class="col p-0 mr-4 col-resp">'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                    '<table class="mb-4 table-bordered">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th>PRODUCTO</th>'+
                                                '<th width="70">CANT.</th>'+
                                                '<th width="85">UNIDAD</th>'+
                                                '<th width="300" class="text-center">NOTAS</th>'+
                                                '<th width="105" class="text-center">PESO</th>'+
                                                '<th width="130" class="text-center">TOTAL</th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>';
            
            $.each(elem.productos, function(i2, elem2){
                console.log(elem2);
                var nombre = "",
                    nota   = ""
                    unidad = "";
                if (elem2.producto_id == 0) {
                    nombre = elem2.nota;
                } else {
                    nombre = elem2.producto.nombre;
                    nota   = elem2.nota;
                    //unidad = elem2.producto.unidad.abreviacion;
                }
                htmlPed +=                  '<tr>'+
                                                '<td>'+nombre+'</td>'+
                                                '<td>'+elem2.cantidad+'</td>'+
                                                '<td>'+unidad+'</td>'+
                                                '<td>'+nota+'</td>'+
                                                '<td></td>'+
                                                '<td></td>'+
                                            '</tr>';
            });

            if (elem.productos.length < 40) {
                for (var i = elem.productos.length; i < 40; i++) {
                    htmlPed +=                  '<tr>'+
                                                    '<td>&nbsp;</td>'+
                                                    '<td></td>'+
                                                    '<td></td>'+
                                                    '<td></td>'+
                                                    '<td></td>'+
                                                    '<td></td>'+
                                                '</tr>';
                }
            }

            htmlPed +=                  '</tbody>'+
                                    '</table>'+
                                    '<table class="">'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<td></td>'+
                                                '<td width="280" class="font-weight-bold">SUBTOTAL</td>'+
                                                '<td width="130" style="border: 1px solid #000000 !important;"></td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td></td>'+
                                                '<td width="280" class="font-weight-bold">IMPORTE DE CAJA</td>'+
                                                '<td width="130" style="border: 1px solid #000000 !important;"></td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td></td>'+
                                                '<td width="280" class="font-weight-bold">CARGO DE PAGO CON TARJETA 4%</td>'+
                                                '<td width="130" style="border: 1px solid #000000 !important;"></td>'+
                                            '</tr>'+
                                            '<tr>'+
                                                '<td></td>'+
                                                '<td width="280" class="font-weight-bold">TOTAL</td>'+
                                                '<td width="130" style="border: 1px solid #000000 !important;"></td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                '</div>';
        });
        htmlPed +=          '</body>'+
                        '</html>';
        mywindow.document.write(htmlPed);

        mywindow.document.close(); 
        mywindow.focus();

        mywindow.onload = function(){
            setTimeout(function(){ 
                mywindow.print();
                setTimeout(function(){ 
                    mywindow.close();
                }, 3000);
            }, 500);
        };
    }

    $(document).on("click", "#printDiv", function (e) {
        var printContents = document.querySelector("#printableArea").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        setTimeout(function(){ 
            window.print();
            setTimeout(function(){ 
                document.body.innerHTML = originalContents;
            }, 500);
        }, 500);

    });

    $(document).on("click", ".download-pedidos", function (e) {
        $(".tooltip").remove();
        var url = $('div.general-info').data('url');
        var refresh = $('div.general-info').data('refresh');
        var element = $('div.general-info').data('el-loader');

        url += "/excel/download?estado="+$("#estado_ped").val();
        if($("#fecha_ini").val()){
            url += "&fecha_ini="+$("#fecha_ini").val();
        }
        if($("#fecha_fin").val()){
            url += "&fecha_fin="+$("#fecha_fin").val();
        }       
        loadingMessage('Descargando...');
        $.ajax({
            url: url,
            method: 'GET',
            processData: false,
            contentType: false,
            xhrFields: {
                responseType: 'blob'
            },
            success: function (data) {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = 'pedidos.xlsx';
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
                if ( swal.getState().isOpen ) { swal.close(); }
            }
        });
    });

    $(document).on("click", ".email-pedidos", function (e) {
        swal({
            title: 'Error',
            icon: "error",
            content: {
                element: "div",
                attributes: {
                    innerHTML:"<p class='text-response'>"+"Funcionalidad no desarrollada"+"</p>"
                },
            },
            buttons: false,
            closeOnEsc: false,
            closeOnClickOutside: false,
            timer: 2000
        }).catch(swal.noop);
        return;
        loadingMessage('Enviando...');
        config = {
        }
        $.ajax({
            type: "GET",
            method: "GET",
            url: $(".general-info").data("url")+"/mail",
            cache:false,
            contentType: false,
            processData: false,
            success: function(data) {
                if ( swal.getState().isOpen ) { swal.close(); }
                swal({
                    title: data.status == 'success' ? 'Bien: ' : 'Error',
                    icon: data.status ? data.status : "success",
                    content: {
                        element: "div",
                        attributes: {
                            innerHTML:"<p class='text-response'>"+data.msg ? data.msg : "Pedidos enviados exitosamente!"+"</p>"
                        },
                    },
                    buttons: false,
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                    timer: 2000
                }).catch(swal.noop);
            },
            error: function(xhr, status, error) {
                displayAjaxError(xhr, status, error, config);
            }
        });
    });

    $('body').delegate('.edit-row','click', function(e) {
        e.stopPropagation();
        var target = $(this).data('target');

        mostrarPedido($(this));

        $("#printDiv").prop("disabled", false);
        $('div'+target).modal();
    });

    $(document).on("click", ".close-btn", function (e) {
        $(".modal-backdrop").remove();
        $("#viewForm").removeClass("show");
        $("#viewForm").hide();
        $("#viewForm").attr("aria-hidden",!0);
        $("#viewForm").removeAttr("aria-modal");
        $('#viewForm').modal('hide');
    });
    
    function mostrarPedido($this) {
        var target = $this.data('target');
        var row = $.extend(true, {}, $this.data('row'));
        console.log(row);
        //Set action url to form
        $('div'+target + " .modal-body").data("row", row);
        $("#idPedido").html(row.id);
        var productos = row.productos,
            htmlProd  = "";
        htmlProd += '<div class="pedido-header">'+
                        '<div class="row align-items-start mb-3">'+
                            '<div class="col">'+
                                '<img class="admin-brand-logo" src="{{ asset('img/logo.jpeg') }}" width="100" alt="atmos Logo">'+
                            '</div>'+
                            '<div class="col-auto">'+
                                '<button class="btn btn-secondary mr-2" id="cancel-edit" style="display: none;">Cancelar</button>'+
                                @if (Auth::user()->tipo_usuario === 1)
                                '<button class="btn btn-primary" id="edit-ped">Editar</button>'+
                                @endif
                            '</div>'+
                        '</div>'+
                        '<div class="row align-items-start">'+
                            '<div class="col">'+
                                '<div class="row">'+
                                    '<div class="col-auto font-weight-bold pr-0" style="width: 120px;">'+
                                        'Nombre:'+
                                    '</div>'+
                                    '<div class="col pl-0">'+
                                        row.user.nombre+
                                    '</div>'+                             
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-auto font-weight-bold pr-0" style="width: 120px;">'+
                                        'Teléfono:'+
                                    '</div>'+
                                    '<div class="col pl-0">'+
                                        row.user.telefono+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-auto font-weight-bold pr-0" style="width: 120px;">'+
                                        'Email:'+
                                    '</div>'+
                                    '<div class="col pl-0">'+
                                        row.user.email+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-auto font-weight-bold pr-0" style="width: 120px;">'+
                                        'Dirección:'+
                                    '</div>'+
                                    '<div class="col pl-0">'+
                                        row.direccion+
                                    '</div>'+
                                '</div>'+
                                '<div class="row">'+
                                    '<div class="col-auto font-weight-bold pr-0" style="width: 120px;">'+
                                        'Flete:'+
                                    '</div>'+
                                    '<div class="col pl-0 div-flete" data-flete="'+row.importe_flete+'">'+
                                        row.flete+ ' - $'+numberWithCommas(row.importe_flete.toFixed(4))+
                                    '</div>'+
                                '</div>'+
                                '<div class="row align-items-end">'+
                                    '<div class="col-auto font-weight-bold pr-0" style="width: 120px;">'+
                                        'Fecha de entrega:'+
                                    '</div>'+
                                    '<div class="col pl-0 view-div">'+
                                        row.fecha_entrega+
                                    '</div>'+
                                    '<div class="col pl-0 edit-div" style="display: none;">'+
                                        '<input value="'+row.fecha_entrega+'" type="date" class="form-control not-empty fecha_entrega" data-msg="Fecha de entrega" name="fecha_entrega" placeholder="Fecha de entrega"></input>'+
                                    '</div>'+
                                '</div>';
                            if(row.observaciones) {
                                htmlProd +=
                                '<div class="row">'+
                                    '<div class="col-auto font-weight-bold pr-0" style="width: 120px;">'+
                                        'Observaciones:'+
                                    '</div>'+
                                    '<div class="col pl-0">'+
                                        row.observaciones+
                                    '</div>'+
                                '</div>';
                            }
                            htmlProd +=   
                            '</div>'+
                            '<div class="col-auto text-right">'+
                                '<h3 class="font-primary">Folio - '+row.id+'</h3>'+
                                '<div>'+
                                    row.created_at+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div id="content-produc-princ">';
        var vfFlete = 0;
        $.each(productos, function(i, producto) {
            //producto.producto.nombre = producto.producto.nombre+ ' ('+producto.producto.unidad.abreviacion+')';
            vfFlete = vfFlete + (row.importe_flete * producto.cantidad);
            producto.total  = '$'+numberWithCommas(producto.total.toFixed(4));
            htmlProd += '<div class="content-product" data-row='+"'"+JSON.stringify(producto)+"'"+' style="padding: 20px 0 32px;">'+
                            '<div class="row align-items-center">'+
                                '<div class="col pb-3 pb-md-0 cont-pedi-cant">'+
                                    '<div class="product-name font-weight-bold">'+
                                        producto.producto+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-auto cont-pedi-cant">'+
                                    '<div class="row align-items-center">'+
                                        '<div class="col mt-3 mt-md-0 view-div"  style="font-size: 18px; min-width: 130px;">';
                            htmlProd +=     numberWithCommas(producto.cantidad) + " LTS";      
                        htmlProd +=     '</div>'+
                                        '<div class="col mt-3 mt-md-0 edit-div"  style="width: 150px; display: none;">';
                            htmlProd +=     '<select  class="form-control js-select2 cantidad-inp" style="width: 100%;">'+
                                                '<option value="10000">10,000 LTS</option>'+
                                                '<option value="15000">15,000 LTS</option>'+
                                                '<option value="30000">30,000 LTS</option>'+
                                            '</select>';  
                        htmlProd +=     '</div>'+
                                        '<div class="col mt-3 mt-md-0 view-div"  style="font-size: 18px;">';
                            htmlProd +=     '$'+numberWithCommas(producto.costo.toFixed(4)) + "";      
                        htmlProd +=     '</div>'+
                                        '<div class="col mt-3 mt-md-0 edit-div" style="width: 130px; display: none;">';
                            htmlProd +=     '<input type="number" name="precio_base" data-msg="Precio base" class="form-control not-empty precio_base fixed4" value="'+numberWithCommas(producto.costo.toFixed(4))+'"/>'      
                        htmlProd +=     '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
            htmlProd += '</div>';
        });

        htmlProd += '</div>'+
                    '<div class="content-product"  style="padding: 14px 0 32px;">'+
                            '<div class="row align-items-center">'+
                                '<div class="col-12">'+
                                    '<span class="font-weight-bold float-right" style="font-size: 20px;" id="flete-pedido">Flete: $'+numberWithCommas(row.total_flete.toFixed(4))+'</span>'+
                                '</div>'+
                                '<div class="col-12">'+
                                    '<span class="font-weight-bold float-right" style="font-size: 22px;" id="total-pedido">Total: $'+numberWithCommas(row.total.toFixed(4))+'</span>'+
                                '</div>'+
                            '</div>'+
                    '</div>';
        $('div'+target + " .modal-body").html(htmlProd);

        /* Inicia elementos de agregar productos */
        $('.js-select2').each(function () {
            $(this).select2({
                dropdownParent: $(this).parent()
            });
        });

        $('.cantidad-inp').each(function () {
            $(this).val($(this).closest('.content-product').data("row").cantidad);
            $(this).trigger('change.select2');
        });
        $(".fecha_entrega").attr("min", getMinDay());
        $("#inpCant").inputSpinner();
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

        $("#btn-product-nuevo").click(function(e) {
            var vcProducto = {
                                isOtro: true,
                                unidad: {
                                    fraccionario: true
                                }
                             }
            $("#content-produc-princ").append('<div class="content-product" data-row='+"'"+JSON.stringify(vcProducto)+"'"+' style="padding: 20px 0 32px;">'+
                                                '<div class="row align-items-center">'+
                                                    '<div class="col-12 pb-0">'+
                                                        '<div class="product-name font-weight-bold">'+
                                                            'Otro'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<div class="col-12 cont-pedi-cant">'+
                                                        '<div class="row align-items-center">'+
                                                            '<div class="col mt-3 edit-div"  style="font-size: 18px;">'+
                                                                '<div style="width: 180px;">'+
                                                                    '<input type="number" class="form-control inpCant" value="1" min="0.01"  step="0.5" data-decimals="2">'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-auto mt-3 mt-md-0">'+
                                                                '<span class="text-right total-product"></span>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                                '<div class="row align-items-start mt-4 edit-div">'+
                                                    '<div class="col-auto font-weight-bold pr-0" style="width: 85px;">Nota:</div>'+
                                                     '<div class="col pl-0">'+
                                                        '<textarea type="text" class="form-control nota" name="nota" placeholder="Nota" data-msg="Nota" rows="3" required style="resize: none;"></textarea>'+ 
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
                    if (vcProducto.unidad.fraccionario) {
                        vcMin = "0.01";
                        vcStep = "0.5";
                        vcDecimals = "2";
                    }
                    var vfTotalProduct = parseFloat(parseFloat($("#inpCant").val()) * vcProducto.costo).toFixed(2);
                    $("#content-produc-princ").append('<div class="content-product" data-row='+"'"+JSON.stringify(vcProducto)+"'"+' style="padding: 20px 0 32px;">'+
                                                        '<div class="row align-items-center">'+
                                                            '<div class="col-12 pb-0">'+
                                                                '<div class="product-name font-weight-bold">'+
                                                                    vcProducto.nombre+ ' ('+vcProducto.unidad.abreviacion+')'+
                                                                    '<button class="text-secondary btn-elim-product edit-div" style="position: absolute; top: 0; right: 15px;" data-toggle="tooltip" title="Eliminar producto">'+
                                                                            '<i class="mdi mdi-delete" style="font-size: 19px;"></i>'+
                                                                    '</button>'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-12 cont-pedi-cant">'+
                                                                '<div class="row align-items-center">'+
                                                                    '<div class="col mt-3 edit-div"  style="font-size: 18px;">'+
                                                                        '<div style="width: 180px;">'+
                                                                            '<input type="number" class="form-control inpCant" value="'+$("#inpCant").val()+'" min="'+vcMin+'"  step="'+vcStep+'" data-decimals="'+vcDecimals+'">'+
                                                                        '</div>'+
                                                                    '</div>'+
                                                                    '<div class="col-auto mt-3 mt-md-0">'+
                                                                        '<span class="text-right total-product">$'+vfTotalProduct+'</span>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="row align-items-start mt-4 edit-div">'+
                                                            '<div class="col-auto font-weight-bold pr-0" style="width: 85px;">Nota:</div>'+
                                                             '<div class="col pl-0">'+
                                                                '<textarea type="text" class="form-control nota" name="nota" placeholder="Nota" data-msg="Nota" rows="3" required style="resize: none;"></textarea>'+ 
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

        configurarProductos();
        //calculaTotal();

        $("#edit-ped").click(function(){
            if ($(this).html().trim() == "Editar") {
                $("#cancel-edit").show();
                $("#edit-ped").html("Guardar");
                $("#printDiv").prop("disabled", true);
                $(".view-div").hide();
                $(".edit-div").show();
                $(".cont-pedi-cant").removeClass("col-md-6");
                $(".cont-pedi-cant").removeClass("pb-3");
                $(".cont-pedi-cant").removeClass("pb-md-0");
                $(".cont-pedi-cant").addClass("pb-0");
            } else {
                var inputs = [];
                var msgError = '';
                var form = $("#viewForm");

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

                var products = $("#content-produc-princ .content-product");

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
                        'keep_modal'      : 'viewForm',
                    }
                    var form_id = form.attr('id');
                    var formData = new FormData();

                    var arrayProd = [];
                    $.each(products, function(i, elem) {  
                        var item = $(elem).data("row");    
                        arrayProd.push({nombre: item.producto, cantidad: $(elem).find(".cantidad-inp").val(), costo: $(elem).find(".precio_base").val()});
                    });
                    console.log($('div'+target + " .modal-body").data("row"));
                    formData.append("id", $('div'+target + " .modal-body").data("row").id);
                    formData.append("fecha_entrega", $("input[name=fecha_entrega]").val());
                    
                    formData.append("productos", JSON.stringify(arrayProd));
                    
                    $.ajax({
                        method: "POST",
                        type: "POST",
                        url: '/pedidos/update',
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
                                    title: data.status == 'success' ? 'Bien: ' : 'Error',
                                    icon: data.status ? data.status : "success",
                                    content: {
                                        element: "div",
                                        attributes: {
                                            innerHTML:"<p class='text-response'>"+data.msg ? data.msg : "¡Pedido guardado exitosamente!"+"</p>"
                                        },
                                    },
                                    buttons: false,
                                    closeOnEsc: false,
                                    closeOnClickOutside: false,
                                    timer: 2000
                                }).catch(swal.noop);
                            }

                            $this.data("row", data.item[0]);
                            $this.closest("tr").find(".print-row").data("row", data.item[0]);
                            $this.closest("tr").find("td").eq(6).html(data.item[0].fecha_entrega);
                            $this.closest("tr").find("td").eq(7).html("$"+numberWithCommas(parseFloat(data.item[0].total).toFixed(4)));       
                            mostrarPedido($this);
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
            }
        });

        $("#cancel-edit").click(function(){
            mostrarPedido($this);
            $("#printDiv").prop("disabled", false);
        });
    }

    $('body').delegate('.aprov-row','click', function() {
        var route = $('div.general-info').data('url')+'/status';
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        var row_id = $(this).hasClass('special-row') ? $(this).data('row-id') : $(this).parent().siblings("td:nth-child(1)").text();
        ids_array.push(row_id);

        swal({
            title: 'Se atendera el pedido con el Folio '+row_id+', ¿Está seguro de continuar?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                config = {
                    'route'     : route,
                    'id'        : row_id,
                    'refresh'   : "table"
                }
                loadingMessage();
                ajaxSimple(config);
            }
        }).catch(swal.noop);
    });

    function getMinDay() {
        var today = new Date();
        today.setDate(today.getDate());
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

    function configurarProductos() {

        $.each($(".inpCant[type=number]"), function(i, elem) {
            var $elem = $(elem);
            if (!$elem.next(".input-group").length) {
                $elem.inputSpinner();
            }
        });

        $(".cantidad-inp").off("change").change(function(){
            $(this).select2("destroy");
            $(this).select2({
                dropdownParent: $(this).parent()
            });
            calculaTotal();
        });

        $("input[name=precio_base]").off("keyup").keyup(function(){
            var value = $(this).val();
            if(value.split(".").length > 1) {
                if(value.split(".")[1].length > 4) {
                    value = parseFloat($(this).val()).toFixed(4);
                }
            }
            //parseFloat($("#precio_base").val()).toFixed(4);
            $(this).val(value);
            calculaTotal();
        });
    }

    function calculaTotal() {
        var products = $(".content-product"),
            vfTotal  = 0;
            vfFlete = parseFloat($('.div-flete').data("flete")),
            vfFleteTota = 0;
        $.each(products, function(i, elem) {       
            if ($(elem).data("row") != undefined) {
                vfTotal = vfTotal + (parseFloat($(elem).find("input[name=precio_base]").val()) * parseFloat($(elem).find(".cantidad-inp").val()));
                vfFleteTota = vfFleteTota + ((parseFloat(vfFlete) * parseFloat($(elem).find(".cantidad-inp").val())));
            }
            
        });
        vfTotal = parseFloat(vfTotal) + parseFloat(vfFleteTota);
        
        $("#flete-pedido").html("Flete: $"+numberWithCommas(vfFleteTota.toFixed(4)));

        $("#total-pedido").html("Total: $"+numberWithCommas(vfTotal.toFixed(4)));

        if (vfTotal > 0) {
            $("#edit-ped").prop("disabled", false);
        } else {
            $("#edit-ped").prop("disabled", true);
        }
    }

    $('body').delegate('.refresh-content-ped','click', function() {
        $(".tooltip").remove();
        $("#estado_ped").val("todos");
        $("#fecha_ini, #fecha_fin").val(null);
        var url = $('div.general-info').data('url');
        var refresh = $('div.general-info').data('refresh');
        var element = $('div.general-info').data('el-loader');

        var config = {
            "element"         : element,
            "refresh"         : refresh,
            "method"          : 'get',
            "container_class" : "rows-container",
            "table_class"     : "data-table",
            "route"           : url,
            "callback"        : "fill_table",
        }

        blockElement(config);
        refreshTable(url);
        unBlockElement();
    });

    $('body').delegate('#btn_search_ped','click', function() {
        $(".tooltip").remove();
        var url = $('div.general-info').data('url');
        var refresh = $('div.general-info').data('refresh');
        var element = $('div.general-info').data('el-loader');

        url += "?estado="+$("#estado_ped").val();
        if($("#fecha_ini").val()){
            url += "&fecha_ini="+$("#fecha_ini").val();
        }
        if($("#fecha_fin").val()){
            url += "&fecha_fin="+$("#fecha_fin").val();
        }       

        var config = {
            "element"         : element,
            "refresh"         : refresh,
            "method"          : 'get',
            "container_class" : "rows-container",
            "table_class"     : "data-table",
            "route"           : url,
            "callback"        : "fill_table",
        }

        blockElement(config);
        refreshTable(url);
        unBlockElement();
    });
</script>
@endsection