@extends('templates.main')
@section('titulo_pagina', 'Permiso-Denegado')

@section('contenido')
<div class="container-fluid">
    <h1 class="text-center mt-5 h1">Permiso Denegado</h1>
    <img  class="img-responsive" src="{{asset('/imagenes/errores/error-403.png')}}">

</div>
    @endsection()
