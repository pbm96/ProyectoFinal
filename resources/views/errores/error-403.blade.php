@extends('templates.main')
@section('titulo_pagina', 'Permiso-Denegado')

@section('contenido')
<div class="container">
    <img  class="img-responsive" src="{{asset('/imagenes/errores/error-403.png')}}">
    <h1 class="text-center mt-5">Permiso Denegado</h1>
</div>
    @endsection()
