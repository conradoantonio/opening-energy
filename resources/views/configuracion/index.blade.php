@extends('layouts.main')

@section('content')
<section class="admin-content">
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
                    <div class="col-md-4 m-auto text-white p-t-40 p-b-90 general-info" data-url="{{url("configuracion")}}" data-refresh="table" data-el-loader="card">
                        
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
                            <h2 class="">Configuración de encuesta</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-data" action="/encuesta/update" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
                            <div class="form-group d-none">
                                <label>Tipo</label>
                                <input type="text" class="form-control" name="tipo" value="{{$item->tipo}}">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Link de encuesta</label>
                                    <input type="text" value="{{$item->valor}}" class="form-control not-empty" name="valor" placeholder="Link de encuesta" data-msg="Link de encuesta" required>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success save" data-target-id="form-data">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
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