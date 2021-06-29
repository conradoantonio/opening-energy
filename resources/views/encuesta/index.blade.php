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
                            <h2 class="">Contestar encuesta</h2>
                        </div>
                    </div>
                    <div class="card-body">                        
                        <div class="form-row">
                            <div class="col-md-12" style="margin-bottom: 20px">
                                <a style="color: #6472ea; text-decoration: underline;" target="_blank"l href="{{$item->valor}}">{{$item->valor}}</a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection