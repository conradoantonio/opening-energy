@extends('layouts.main')

@section('content')
<section class="admin-content">
    @include('productos.modal')
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
                    <div class="col-md-4 m-auto text-white p-t-40 p-b-90 general-info" data-url="{{url("productos")}}" data-refresh="table" data-el-loader="card">
                        
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
                            <h2 class="">Lista de productos</h2>
                        </div>
                        <div class="col-12 col-md-auto text-right">
                            <a href="javascript:;" class="icon refresh-content"><i class="mdi mdi-refresh"></i> </a>
                            <button class="btn btn-dark new-row" data-target="#editForm" type="button">Nuevo producto</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rows-container">
                            @include('productos.table')
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

        setForm(row, target);
        $('div'+target).modal();
    });
</script>
@endsection