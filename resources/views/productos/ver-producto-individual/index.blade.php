<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'ver-'.$producto->nombre)

@section('estilos')
    <style></style>
@endsection


@section('contenido')

    @if($producto!=null)
    <div class="container ">
        <h3 class=" text-center ">{{$producto->nombre}}</h3>
    </div>

    <div class="container mt-3">
        <div class=" row justify-content-sm-center  ">
            <div class="col-sm-5 table-bordered  ">

                @foreach($imagenes as $imagen)
            <img src="/imagenes/productos/{{$imagen->nombre}}" class="img-thumbnail img-responsive">
                    @endforeach
            </div>

         </div>
    </div>

<div class="container col-sm-8 mt-5">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#descripcion" role="tab" aria-controls="descripcion" aria-selected="true">Descripcion</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#localizacion" role="tab" aria-controls="localizacion" aria-selected="false">Localizacion</a>
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
        console.log(parseFloat({{$latitud}}));
            console.log(parseFloat({{$longitud}}));
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


    </script>
@endsection