@extends('layouts.main')

@section('content')
<section class="admin-content">
    @include('admins.modal')
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
                    <div class="col-md-4 m-auto text-white p-t-40 p-b-90 general-info" data-url="{{url("administradores")}}" data-refresh="table" data-el-loader="card">
                        
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
                            <h2 class="">Lista de administradores</h2>
                        </div>
                        <div class="col-12 col-md-auto text-right">
                            <a href="javascript:;" class="icon refresh-content"><i class="mdi mdi-refresh"></i> </a>
                            <button class="btn btn-dark new-row2" data-target="#editForm" type="button">Nuevo administrador</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rows-container">
                            @include('admins.table')
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