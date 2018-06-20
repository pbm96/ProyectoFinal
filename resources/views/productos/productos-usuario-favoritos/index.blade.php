
<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'Mis Favoritos')

@section('contenido')

@if(count($productos_favoritos) > 0)

    @foreach($productos_favoritos->chunk(4) as $productChunk)

        <div class="row">
            @foreach($productChunk as $producto)
                <div class="col-lg-3 col-md-6 col-sm-12 mb-5">
                    <div class="card">
                        <div class="card-header imagenes_productos">

                            @if( $producto->producto->imagen->isEmpty())
                                <img src="{{ asset('imagenes/productos/fakeapop_default.png') }}" alt="Imagen del producto" style="width:100%" height="200" class="card-img-top">
                            @else
                                <img src="{{ asset('imagenes/productos/'.$producto->producto->imagen[0]->nombre)}}" alt="Imagen del producto" style="width:100%" height="200"  class="card-img-top">

                            @endif
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"> {{ $producto->nombre }} </h4>
                            <p class="card-text h3"> {{ $producto->precio }} €</p>

                            <a href="{{route('ver_producto',$producto->producto_id)}}" class="btn btn-outline-info"> Mas Datos</a>

                            <p class="card-text h3 text-right"> creado hace {{$producto->diferencia}}</p>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
    <div class="row justify-content-around">
        <div class="">{{ $productos_favoritos->render() }}</div>
    </div>


    @else
    <h1>No tienes productos favoritos</h1>
    @endif
@endsection
<!-- seccion  de los enlaces de scripts-->
@section('scripts')

@endsection