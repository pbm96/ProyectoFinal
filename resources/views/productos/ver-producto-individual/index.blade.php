<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'Home')

@section('estilos')
    <style></style>
@endsection


@section('contenido')
    <div class="container ">
        <h3 class=" text-center ">{{$producto->nombre}}</h3>
    </div>

    <div class="container mt-3">
        <div class=" row justify-content-sm-center  ">
            <div class="col-sm-6 table-bordered  ">
            visor imagenes
            </div>

         </div>
    </div>
    <div class="container mt-3">
        <div class=" row justify-content-sm-center ">
            <div class="col-sm-6 table-bordered "  >{{$producto->descripcion}}</div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
    <div class=" col align-self-start ">
        <a class="btn btn-primary text-light  "> volver</a>
    </div>
    <div class="justify-content-between ">
    <a class="btn btn-primary text-light pull-left"> abrir chat</a>
    </div>
        </div>
    </div>
@endsection


<!-- seccion  de los enlaces de scripts-->
@section('scripts')
@endsection