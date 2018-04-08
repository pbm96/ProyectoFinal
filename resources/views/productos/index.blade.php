<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'Home')

@section('estilos')
    <style></style>
    @endsection


@section('contenido')

@foreach($productos as $producto)
    {{$producto->nombre}}
    <br>
    {{$producto->created_at}}
    @endforeach
{{ $productos->render() }}
@endsection


<!-- seccion  de los enlaces de scripts-->
@section('scripts')
    @endsection