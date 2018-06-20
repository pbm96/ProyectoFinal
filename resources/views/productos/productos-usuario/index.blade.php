<!-- include del nav y de los enlaces de estilos-->

@extends('templates.main') 
@section('titulo_pagina', 'Mis productos') 
 
@section('contenido')
<h2 class="text-center pb-5 h1 pt-2">Mis Productos</h2>
@if(count($productos)>0) @foreach($productos->chunk(4) as $productChunk)

<div class="row">
    @foreach($productChunk as $producto)
    <div class="col-lg-3 col-md-6 col-sm-12 mb-5">
        <div class="card">
            <div class="card-header imagenes_productos">
                @if(count($producto->imagen)>0)

                <img src="{{ asset('imagenes/productos/'.$producto->imagen[0]->nombre) }}" alt="Imagen del producto" style="width:100%" height="200"
                    class="card-img-top"> @else
                <img src="{{ asset('imagenes/productos/fakeapop_default.png') }}" alt="Imagen del producto" style="width:100%" height="200" class="card-img-top">                @endif
            </div>

            <div class="card-body">
                <h4 class="card-title"> {{ $producto->nombre }} </h4>
                <p class="card-text h3"> {{ $producto->precio }} €</p>
                <div class="row mb-2 justify-content-center ">
                    <a href="{{route('editar_producto',$producto->id)}}" class="text-info col-sm-3  text-center p-2" data-toggle="popover" data-trigger="hover"
                        data-placement="right" data-content="Editar"><i
                                                class="fas fa-edit"></i></a>
                    <a href="{{route('venta_producto',$producto->id)}}" class="text-success col-sm-3 offset-sm-1 text-center p-2" data-toggle="popover"
                        data-trigger="hover" data-placement="right" data-content="Vender"><i
                                                class="fas fa-handshake"></i></a>
                    <a href="{{route('borrar_producto',$producto->id)}}" class=" text-danger col-sm-3 offset-sm-1 text-center p-2 confirm" data-confirm="Seguro que quieres borrar el Producto? "
                        data-toggle="popover" data-trigger="hover" data-placement="right" data-content="Borrar"><i
                                                class="fas fa-trash-alt "></i></a>
                </div>
                <div class="row justify-content-center">
                    <a href="{{route('ver_producto',$producto->id)}}" class="btn btn-outline-info"> Más
                                        datos </a>
                </div>
                <p class="card-text h3 text-right"> creado hace {{$producto->diferencia}}</p>


            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach
<div class="row justify-content-around">
    <div class="">{{ $productos->render() }}</div>
</div>
@else
<h1>No tienes productos</h1>
@endif
@endsection

<!-- seccion  de los enlaces de scripts-->

@section('scripts')
<script>
    $('.confirm').on('click', function (e) {
            return !!confirm($(this).data('confirm'));
        });
</script>
@endsection