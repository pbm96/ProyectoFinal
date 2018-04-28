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
<div class="container principal col-sm-8">
            <h3 class="row mt-4 justify-content-sm-center">{{$producto->nombre}}</h3>
    <div class="container">
        <div class=" row justify-content-sm-center">
            <div id="carouselExampleIndicators" class="carousel slide img-thumbnail  " data-ride="carousel">
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

                            <div class="carousel-item {{ $loop->first ? ' active' : '' }}" >
                                <img src="/imagenes/productos/{{$imagen->nombre}}" class=" img-responsive   " width="500" height="300
" >
                            </div>

                    @endforeach
                    </div>
                 @else
                    <img src="/imagenes/productos/fakeapop_default.png" class="img-responsive " width="500" height="300>
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

    </div>
    <div class="container col-sm-8 mt-1">
    <hr>
    </div>
    <div class="container  mt-4">

            <h4 class=" col-sm-9">{{$producto->precio}}€</h4>
            <h4 class="  text-right">{{$producto->precio}}€</h4>
    </div>
<div class="container col-sm-8 mt-3">
    <nav>
        <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#descripcion" role="tab" aria-controls="descripcion" aria-selected="true">Descripcion</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#localizacion" role="tab" aria-controls="localizacion" aria-selected="false">Localizacion</a>
        </div>
    </nav>
    <div class="tab-content container" id="nav-tabContent">
        <div class="tab-pane fade show active" id="descripcion" role="tabpanel" aria-labelledby="nav-home-tab">{{$producto->descripcion}}</div>
        <div class="tab-pane fade" id="localizacion" role="tabpanel" aria-labelledby="nav-profile-tab">
            <p>El producto se encuentra en:</p>
            <h4>{{$producto->user->direccion->nombre}}</h4>
            <div id="googleMap" style="width:100%;height:400px;"></div>
        </div>
    </div>
</div>


    <div class="container mt-5">
        <div class="row ">
    <div class=" col align-self-start ">
        <a class="btn btn-primary text-light  "> volver</a>
    </div>
    <div class="justify-content-between ">
    <a class="btn btn-primary text-light pull-left"> abrir chat</a>
    </div>
        </div>
    </div>
        @else
        <div class="container ">
        <div class="alert-danger h-50 text-center ">
            <h3>No se ha encontrado el  producto</h3>
            </div>
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