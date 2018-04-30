<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'ver-'.$producto->nombre)

@section('estilos')
<style>
    .carousel{
        box-shadow: #aeb9cc 5px 5px 5px;
    }
    h4{
        display: inline;
    }
</style>
@endsection


@section('contenido')

    @if($producto!=null)
<div class="container col-sm-8 mb-5">
    <h2 class="row mt-4 justify-content-sm-center"> {{$producto->nombre}} </h2>
    <div class=" row justify-content-sm-center">
        <div id="carouselExampleIndicators" class="d-flex align-items-center carousel slide img-thumbnail w-100"data-ride="carousel" style="height:300px: overflow:hidden">
            <ol class="carousel-indicators">
                @if(count($imagenes)>0)
                    @foreach( $imagenes as $imagen => $value )
                        <li data-target="#carouselExampleIndicators"  data-slide-to="{{$imagen}}" class="{{ $loop->first ? 'active' : '' }}"></li>
                    @endforeach
                @else
                    <li data-target="#carouselExampleIndicators"  data-slide-to="1" class="active"></li>
                @endif
            </ol>
            @if(count($imagenes)>0)
                <div class="carousel-inner">
                    @foreach($imagenes as $imagen)
                        <div class="carousel-item text-center {{ $loop->first ? ' active' : '' }}" >
                            <img src="/imagenes/productos/{{$imagen->nombre}}" class="img-responsive" style="max-width:100%">
                        </div>
                    @endforeach

                </div>
            @else
                <img src="/imagenes/productos/fakeapop_default.png" class="img-fluid">
            @endif
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
    <hr>
    <h4 class="col-sm-9">{{$producto->precio}}€</h4>
    <div class="col-lg-12 mt-3">
        <nav>
            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                <a class="nav-item nav-link lead active" id="nav-home-tab" data-toggle="tab" href="#descripcion" role="tab" aria-controls="descripcion" aria-selected="true">Descripcion</a>
                <a class="nav-item nav-link lead" id="nav-profile-tab" data-toggle="tab" href="#localizacion" role="tab" aria-controls="localizacion" aria-selected="false">Localizacion</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="descripcion" role="tabpanel" aria-labelledby="nav-home-tab">{{$producto->descripcion}}</div>
            <div class="tab-pane fade" id="localizacion" role="tabpanel" aria-labelledby="nav-profile-tab">
            <p>El producto se encuentra en:</p>
                <h4>{{$producto->user->direccion->nombre}}</h4>
                <div id="googleMap" style="width:100%;height:400px;"></div>
            </div>
        </div>
    </div>

    <div class="row mt-5 justify-content-end">
        <a class="btn btn-outline-primary text-light pull-left"> abrir chat</a>
    </div>
    @else
        <div class="alert-danger h-50 text-center">
            <h3>No se ha encontrado el  producto</h3>
        </div>
    </div>
    @endif
@endsection


<!-- seccion  de los enlaces de scripts-->
@section('scripts')


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7G5aANtgkHs8FRZ6kyEsUOCwd4DG5QM"></script>
    <script>
        initMap();
        function initMap() {
        {{$latitud=$producto->user->direccion->latitud}}
                {{$longitud=$producto->user->direccion->longitud}}
        var myLatLng = {lat: parseFloat({{$latitud}}), lng: parseFloat({{$longitud}})};

            var map = new google.maps.Map(document.getElementById('googleMap'), {
                zoom: 14,
                center: myLatLng
            });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: 'Hello World!'
        });}

        $('.carousel').carousel({
            interval:false
        })


    </script>
@endsection