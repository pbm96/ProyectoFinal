
<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'Home')

@section('estilos')
    <style>
        .card-title{
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
@endsection


@section('contenido')

    <section class="card mb-5">
        <h4 class="card-header">Filtrar resultados</h4>
        <div class="card-body">
            {!! Form::Open(['route'=>'index','method'=>'GET']) !!}
                <div class="row justify-content-around">
                    <div class="col-lg-3 col-md-6">
                        <h3>Categorias</h3>         
                        <ul class="list-group list-group-flush">
                        @foreach($listaCategorias as $categoria)
                            <li class="list-group-item"><input type="checkbox" value="{{ $categoria->id }}" name="categorias[]">{{ $categoria->nombre }}</li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label for="">Precio</label>
                        <select class="form-control" name="ordenPrecio" id="ordenPrecio">
                            <option selected value="" disabled>Selecciona una opcion</option>
                            <option value="">Mayor a menor</option>
                            <option value="">Menor a mayor</option>
                        </select>
                        <hr>
                        <label for="">Localizacion</label>
                        <select class="form-control" name="ordenDistancia" id="ordenDistancia">
                            <option selected value="" disabled>Selecciona una opcion</option>
                            <option value="">Mas cercanos primero</option>
                            <option value="">Mas lejanos primero</option>
                        </select>
                        {!! Form::label('precioMin','Precio minimo') !!}
                        {!! Form::number('precioMin',0 ,['class'=>'form-control','placeholder'=>'','min'=>0]) !!}
                        {!! Form::label('precioMax','Precio maximo') !!}
                        {!! Form::number('precioMax',20000 ,['class'=>'form-control','placeholder'=>'','min'=>0]) !!}
                    </div>
                </div>
                <div class="row justify-content-center">
                    {!!Form::submit('filtrar',['class'=>'btn btn-outline-primary'])!!}
                </div>
            {!! Form::close() !!}
        </div>
    </section>

    @foreach($productos->chunk(4) as $productChunk)

    <div class="row">
        @foreach($productChunk as $producto)
            <div class="col-lg-3 col-md-6 col-sm-12 mb-5">
                <div class="card">
                        <div class="card-header">
                            @if(count($producto->imagen)>0)

                                <img src="{{ asset('imagenes/productos/'.$producto->imagen[0]->nombre) }}" alt="Imagen del producto" style="width:100%" height="160"  class="card-img-top">
                            @else
                                <img src="{{ asset('imagenes/productos/fakeapop_default.png') }}" alt="Imagen del producto" style="width:100%" class="card-img-top">
                            @endif
                        </div>
                    
                    <div class="card-body">
                        <h4 class="card-title"> {{ $producto->nombre }} </h4>
                        <p class="card-text h3"> {{ $producto->precio }} €</p>
                        <a href="{{route('ver_producto',$producto->id)}}" class="btn btn-outline-info"> Mas datos </a>

                            <p class="card-text h3 text-right"> creado hace {{$producto->diferencia}}</p>


                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @endforeach
        <div class="">{{ $productos->render() }}</div>
@endsection
<!-- seccion  de los enlaces de scripts-->
@section('scripts')
@endsection