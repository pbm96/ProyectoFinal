<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'ver-'.$producto->nombre)

@section('estilos')
    <style></style>
@endsection


@section('contenido')
    @if($producto!=null)
    <div class="container ">
        <h3 class=" text-center ">{{$producto->nombre}}</h3>
    </div>

    <div class="container mt-3">
        <div class=" row justify-content-sm-center  ">
            <div class="col-sm-5 table-bordered  ">

                @foreach($imagenes as $imagen)
            <img src="/imagenes/productos/{{$imagen->nombre}}" class="img-thumbnail img-responsive">
                    @endforeach
            </div>

         </div>
    </div>

<div class="container col-sm-8 mt-5">
    <nav>
        <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#descripcion" role="tab" aria-controls="descripcion" aria-selected="true">Descripcion</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#localizacion" role="tab" aria-controls="localizacion" aria-selected="false">Localizacion</a>
        </div>
    </nav>
    <div class="tab-content container" id="nav-tabContent">
        <div class="tab-pane fade show active" id="descripcion" role="tabpanel" aria-labelledby="nav-home-tab">{{$producto->descripcion}}</div>
        <div class="tab-pane fade" id="localizacion" role="tabpanel" aria-labelledby="nav-profile-tab">Mapa</div>
    </div>
</div>


    <div class="container mt-5">
        <div class="row ">
    <div class=" col align-self-start ">
        <a class="btn btn-primary text-light  "> volver</a>
    </div>
    <div class="justify-content-between ">
    <a class="btn btn-primary text-light pull-left"> abrir chat</a>
    </div>
        </div>
    </div>
        @else
        <div class="container ">
        <div class="alert-danger h-50 text-center ">
            <h3>No se ha encontrado el  producto</h3>
            </div>
        </div>
    @endif
@endsection


<!-- seccion  de los enlaces de scripts-->
@section('scripts')

@endsection