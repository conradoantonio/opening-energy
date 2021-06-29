@extends('layouts.main')

@section('content')
<section class="admin-content">
    @include('clientes.modal')
    @include('clientes.modal_productos')
    @include('clientes.modal_direcciones')
    <div class=" bg-dark m-b-30 bg-stars">
        <div class="bg-title">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 m-auto text-white p-t-40 p-b-90">
                        {{-- <h1>Contactos</h1>
                        <p class="opacity-75">
                            Aquí podrá visualizar y modificar los contactos.
                        </p> --}}
                    </div>
                    <div class="col-md-4 m-auto text-white p-t-40 p-b-90 general-info" data-url="{{url("clientes")}}" data-refresh="table" data-el-loader="card">
                        
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
                            <h2 class="">Lista de clientes</h2>
                        </div>
                        <div class="col-12 col-md-auto text-right">
                            <a href="javascript:;" class="icon refresh-content"><i class="mdi mdi-refresh"></i> </a>
                            <button class="btn btn-dark new-row2" data-target="#editForm" type="button">Nuevo cliente</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rows-container">
                            @include('clientes.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $("#costo").on("change", function(){
        if ($("#costo").val() > 0) {
            $("#costo").val(parseFloat($("#costo").val()).toFixed(2));
        } else {
            $("#costo").val(parseInt("1").toFixed(2));
        }
    });

    $('body').delegate('.edit-row','click', function() {
        var route = $('div.general-info').data('url');
        var row = $(this).data('row');
        var target = $(this).data('target');

        //Set action url to form
        $('div'+target+' form').get(0).setAttribute('action', route.concat('/update'));
        $(target).find("#password").removeClass("not-empty");
        setForm(row, target);
        $('div'+target).modal();
    });

    $('body').delegate('.delete-row-direc','click', function() {
        var row = $(this).closest("tr").data("row");
        console.log($(this).closest("tr"), row);
        var $this = $(this).closest("tr");
        swal({
            title: 'Se dará de baja la siguiente dirección: '+row.direccion+', ¿Está seguro de continuar?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                $this.remove();
            }
        }).catch(swal.noop);
    });

    $('body').delegate('.edit-row-direc','click', function() {
        var row = $(this).closest("tr").data("row");
        $("#uid").val($(this).closest("tr").data("uid"));
        $("#estado").val(row.estado);
        $("#municipio").val(row.municipio);
        $("#codigo_postal").val(row.codigo_postal);
        $("#colonia").val(row.colonia);
        $("#calle").val(row.calle);
        $("#numero_exterior").val(row.numero_exterior);
        $("#numero_interior").val(row.numero_interior);
        $("#flete").val(row.flete);
        $("#importe_flete").val(row.importe_flete);
        $(".edit-row-direc, .delete-row-direc, .save3, .close-direc").prop("disabled", true);
        $(".edit-form-direc").show();
        $(".add-form-direc").hide();
        $(".tooltip").remove();
    });

    $('body').delegate('#cancelEditDireccion','click', function() {
        $("#uid").val("");
        $("#estado").val("");
        $("#municipio").val("");
        $("#codigo_postal").val("");
        $("#colonia").val("");
        $("#calle").val("");
        $("#numero_exterior").val("");
        $("#numero_interior").val("");
        $("#flete").val("");
        $("#importe_flete").val("");
        $(".edit-row-direc, .delete-row-direc, .save3, .close-direc").prop("disabled", false);
        $(".edit-form-direc").hide();
        $(".add-form-direc").show();
        $(".tooltip").remove();
    });

    $('body').delegate('.delete-row-product','click', function() {
        var row = $(this).closest("tr").data("row");
        console.log($(this).closest("tr"), row);
        var $this = $(this).closest("tr");
        swal({
            title: 'Se dará de baja el registro con el nombre '+row.producto.nombre+', ¿Está seguro de continuar?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                $this.remove();
            }
        }).catch(swal.noop);
    });

    $('body').delegate('#agregarProducto','click', function() {
        var vlContinue = true;
        $("#productosEdit .tableProductos tbody tr").each(function() {
            var row = $(this).data('row');
            if(row.producto_id == $("#producto_id").val()) {
                vlContinue = false;
            }
        });
        
        if(vlContinue) {
            if($("#is_precio_especifico").prop("checked")) {
                if($("#producto_id").val()) {
                    if($("#precio_especifico").val() != "" && $("#precio_especifico").val() > 0) {
                        var product = {
                            producto_id: $("#producto_id").val(),
                            producto: $("#producto_id").children('option:selected').data('row'),
                            tipo_precio: 'precio_manual',
                            precio: parseFloat($("#precio_especifico").val()).toFixed(4)
                        }
                        addProduct(product);
                    } else {
                        swal({
                            title: 'Verifique los siguientes campos:',
                            icon: 'error',
                            content: {
                                element: "div",
                                attributes: {
                                    innerHTML:"<ul class='error_list'><li>Precio: vacío</li></ul>"
                                },
                            }
                        }).catch(swal.noop);
                    }                    
                }
            } else {
                if($("#producto_id").val() && $("#tipo_precio").val()) {
                    var product = {
                        producto: $("#producto_id").children('option:selected').data('row'),
                        producto_id: $("#producto_id").val(),
                        tipo_precio: $("#tipo_precio").val(),
                        precio: $("#producto_id").children('option:selected').data('row')[$("#tipo_precio").val()]
                    }
                    addProduct(product);
                }
            }
        } else {
            swal({
                title: 'Ocurrio un error',
                icon: 'error',
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<ul class='error_list'><li>Producto ya esta agregado en la lista</li></ul>"
                    },
                }
            }).catch(swal.noop);
        }        
    });

    $('body').delegate('#agregarDireccion','click', function() {
        var vlContinue = true,
            vcMsg      = "";
        if($("#estado").val() == "") {
            vcMsg+= '<li>Estado: vacío</li>';
            vlContinue = false;
        }
        if($("#municipio").val() == "") {
            vcMsg+= '<li>Municipio: vacío</li>';
            vlContinue = false;
        }
        if($("#codigo_postal").val() == "") {
            vcMsg+= '<li>Código postal: vacío</li>';
            vlContinue = false;
        } else {
            if($("#codigo_postal").val().toString().length > 5) {
                vcMsg+= '<li>Código postal: demasiado largo</li>';
                vlContinue = false;
            } else {
                if($("#codigo_postal").val().toString().length < 5) {
                    vcMsg+= '<li>Código postal: demasiado corto</li>';
                    vlContinue = false;
                }
            }
        }
        if($("#colonia").val() == "") {
            vcMsg+= '<li>Colonia: vacío</li>';
            vlContinue = false;
        }
        if($("#calle").val() == "") {
            vcMsg+= '<li>Calle: vacío</li>';
            vlContinue = false;
        }
        if($("#numero_exterior").val() == "") {
            vcMsg+= '<li>Número exterior: vacío</li>';
            vlContinue = false;
        }

        if($("#flete").val() == "") {
            vcMsg+= '<li>Flete: vacío</li>';
            vlContinue = false;
        }
        if($("#importe_flete").val() == "") {
            vcMsg+= '<li>Importe flete: vacío</li>';
            vlContinue = false;
        }

        if(vlContinue) {
            var direccion = {
                estado: $("#estado").val(),
                municipio: $("#municipio").val(),
                codigo_postal: $("#codigo_postal").val(),
                colonia: $("#colonia").val(),
                calle: $("#calle").val(),
                numero_exterior: $("#numero_exterior").val(),
                numero_interior: $("#numero_interior").val(),
                flete: $("#flete").val(),
                importe_flete: $("#importe_flete").val()
            }
            addDireccion(direccion);
        } else {
            swal({
                title: 'Verifique los siguientes campos:',
                icon: 'error',
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<ul class='error_list'>"+vcMsg+"</ul>"
                    },
                }
            }).catch(swal.noop);
        }
            
    });

    $('body').delegate('#editDireccion','click', function() {
        var vlContinue = true,
            vcMsg      = "";
        if($("#estado").val() == "") {
            vcMsg+= '<li>Estado: vacío</li>';
            vlContinue = false;
        }
        if($("#municipio").val() == "") {
            vcMsg+= '<li>Municipio: vacío</li>';
            vlContinue = false;
        }
        if($("#codigo_postal").val() == "") {
            vcMsg+= '<li>Código postal: vacío</li>';
            vlContinue = false;
        } else {
            if($("#codigo_postal").val().toString().length > 5) {
                vcMsg+= '<li>Código postal: demasiado largo</li>';
                vlContinue = false;
            } else {
                if($("#codigo_postal").val().toString().length < 5) {
                    vcMsg+= '<li>Código postal: demasiado corto</li>';
                    vlContinue = false;
                }
            }
        }
        if($("#colonia").val() == "") {
            vcMsg+= '<li>Colonia: vacío</li>';
            vlContinue = false;
        }
        if($("#calle").val() == "") {
            vcMsg+= '<li>Calle: vacío</li>';
            vlContinue = false;
        }
        if($("#numero_exterior").val() == "") {
            vcMsg+= '<li>Número exterior: vacío</li>';
            vlContinue = false;
        }

        if($("#flete").val() == "") {
            vcMsg+= '<li>Flete: vacío</li>';
            vlContinue = false;
        }
        if($("#importe_flete").val() == "") {
            vcMsg+= '<li>Importe flete: vacío</li>';
            vlContinue = false;
        }

        if(vlContinue) {
            var direccion = $("#direccionesEdit .tableDirecciones tbody tr[data-uid="+$("#uid").val()+"]").data("row");
            direccion.estado          = $("#estado").val();
            direccion.municipio       = $("#municipio").val();
            direccion.codigo_postal   = $("#codigo_postal").val();
            direccion.colonia         = $("#colonia").val();
            direccion.calle           = $("#calle").val();
            direccion.numero_exterior = $("#numero_exterior").val();
            direccion.numero_interior = $("#numero_interior").val();
            direccion.flete           = $("#flete").val();
            direccion.importe_flete   = $("#importe_flete").val();
            editDireccion(direccion, $("#uid").val());
        } else {
            swal({
                title: 'Verifique los siguientes campos:',
                icon: 'error',
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<ul class='error_list'>"+vcMsg+"</ul>"
                    },
                }
            }).catch(swal.noop);
        }
            
    });

    $('body').delegate('#is_precio_especifico','change', function() {
        if($("#is_precio_especifico").prop("checked")) {
            $(".not_precio_especifico").hide();
            $(".precio_especifico").show();
        } else {
            $(".not_precio_especifico").show();
            $(".precio_especifico").hide();
        }
    });

    /*$('body').delegate('#buscarCodigo','click', function() {
        if($("#codigo_postal").val() != "") {
            $.ajax({
                method: "GET",
                type: "GET",
                url: "https://apisgratis.com/api/codigospostales/v2/colonias/cp/?valor="+$("#codigo_postal").val(),
                cache:false,
                success: function(data) {
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    //displayAjaxError(xhr, status, error, config);
                }
            });
        } else {
            swal({
                title: 'Ocurrio un error',
                icon: 'error',
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<ul class='error_list'><li>Coloque un valor valido para código postal</li></ul>"
                    },
                }
            }).catch(swal.noop);
        }
    });*/

    $('body').delegate('.edit-product','click', function() {
        var route = $('div.general-info').data('url');
        var row = $(this).data('row');
        var target = $(this).data('target');
        
        //Set action url to form
        $('div'+target+' form').get(0).setAttribute('action', route.concat('/update/productos'));

        setFormProductos(row, target);

        $('div'+target).modal();
    });

    $('body').delegate('.edit-direcci','click', function() {
        var route = $('div.general-info').data('url');
        var row = $(this).data('row');
        var target = $(this).data('target');
        $("#uid").val("");
        $("#estado").val("");
        $("#municipio").val("");
        $("#codigo_postal").val("");
        $("#colonia").val("");
        $("#calle").val("");
        $("#numero_exterior").val("");
        $("#numero_interior").val("");
        $(".edit-row-direc, .delete-row-direc, .save3, .close-direc").prop("disabled", false);
        $(".edit-form-direc").hide();
        $(".add-form-direc").show();
        
        //Set action url to form
        $('div'+target+' form').get(0).setAttribute('action', route.concat('/update/direcciones'));

        setFormDirecciones(row, target);

        $('div'+target).modal();
    });
</script>
@endsection