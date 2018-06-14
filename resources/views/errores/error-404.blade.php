
@extends('templates.main')
@section('titulo_pagina', 'Pagina no encontrada')
@section('estilos')
    <style>
        .header{
            font-size: 13.0rem;
            font-weight: 700;
            margin: 2% 0 2% 0;
            text-shadow: 0px 3px 0px #7f8c8d;

        }
        .error {
            margin: -70px 0 2% 0;

            font-size: 4.4rem;
            text-shadow: 0px 3px 0px #7f8c8d;
            font-weight: 300;
        }
    </style>
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