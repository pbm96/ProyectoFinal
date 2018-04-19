
<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'Home')

@section('estilos')
    <style></style>
@endsection


@section('contenido')

    <div class="jumbotron text-center">
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima aliquam, nesciunt quasi enim pariatur suscipit neque quas minus ipsum quia dolorem obcaecati dicta! Aut voluptate dolor exercitationem et, aspernatur fuga.
    </div>

    @foreach($productos->chunk(4) as $productChunk)
    <div class="row">
        @foreach($productChunk as $producto)
            <div class="col-lg-3 col-md-6 col-sm-12 mb-5">
                <div class="card">
                        <div class="card-header">
                        <img src="{{ asset('imagenes/productos/fakeapop_default.png') }}" alt="Imagen del producto" style="width:100%" class="img-responsive">
                        </div>
                    <div class="card-title container text-center h5">
                        {{ $producto->nombre }}
                    </div>
                    <div class="card-body">
                    <a href="ver-producto/{{ $producto->id }}" class="btn btn-primary">Detalles</a>
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