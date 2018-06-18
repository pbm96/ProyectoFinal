
@extends('templates.main')
@section('titulo_pagina', 'Pagina no encontrada')
@section('estilos')
    @endsection
@section('contenido')
    <div class="container">
        <div class="row justify-content-center">
        <article>
            <h1 class="header text-primary text-center">404</h1>
            <p class="error text-center">PAGE NOT FOUND</p>
        </article>
        </div>
        <article class="row justify-content-center">
                <img  class="mt-1" src="{{asset('imagenes/errores/error-404-homer.png')}}" alt="ouchhh" >
            </article>

    </div>
@endsection()