<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'ver-'.$producto->nombre)

@section('contenido')

    @if($producto!=null)
<div class="container col-sm-8 mb-5">
    <h2 class="row mt-4 justify-content-sm-center h1"> {{$producto->nombre}} </h2>
    <div class="card row w-100 mb-3" id="carta_usuario">
        <div class="card-body row" >
        <a class="row" href="{{route('perfil_publico',$usuario_producto->id)}}">
            @if($usuario_producto->imagen!=null)
                <img class="d-flex rounded-circle z-depth-1-half mr-3 mt-1" src="{{asset('imagenes/perfil/'.$usuario_producto->imagen)}}" height="50" width="50" alt="Avatar">
            @else
                <img class="d-flex rounded-circle z-depth-1-half mr-3" src="{{asset('imagenes/perfil/user-default.png')}}" height="50" width="50" alt="Avatar">
            @endif
                <p id="nombre_usuario " class="mt-2 h4"> {{$usuario_producto->nombre_usuario}}</p>
                <div class="ml-2 mt-2 pt-1">
                    @for($i=0;$i<$usuario_producto->valoracion;$i++)
                        <i class="fas fa-star yellow-text"></i>
                    @endfor
                    @for($i=0;$i<5-$usuario_producto->valoracion;$i++)
                        <i class="far fa-star "></i>
                    @endfor

                </div>
            <div class="ml-auto mr-5" >
                @guest
                    <a class="btn btn-primary" id="boton_mensaje" href="{{route('login')}}"> Chat</a>
            @endguest
                @auth
                    @if(auth()->user()->id != $usuario_producto->id)
                        <a class="btn btn-primary" id="boton_mensaje" href="{{route('mis_mensajes',[auth()->user()->id,$usuario_producto->id])}}"> Chat</a>
                        @endif
                    @endauth
            </div>
        </a>
        </div>
    </div>
    <div class=" row justify-content-sm-center">
        <div id="carouselExampleIndicators" class="d-flex align-items-center carousel slide img-thumbnail " data-ride="carousel" >
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
                            <img src="/imagenes/productos/{{$imagen->nombre}}" class="img-responsive imagenes" >
                        </div>
                    @endforeach

                </div>
            @else
                <img src="/imagenes/productos/fakeapop_default.png" class="img-responsive imagenes">
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
    <div class="row">
    <h3 class="col-sm-8 justify-content-between h3 ">{{$producto->precio}}€</h3>
        @guest
            <a class="text-muted col-sm-4"  href="{{route('login')}}" id=""><i class="far fa-2x fa-heart text-dark icono-negro"></i>Añadir a favoritos</a>

        @endguest
        @auth
        @if($producto_favorito==true)
            <a class="text-muted col-sm-4"  id="poner_favorito"><i class="far fa-2x fa-heart  text-danger icono-rojo"></i>Quitar de favoritos</a>
        @else
            <a class="text-muted col-sm-4"  id="poner_favorito"><i class="far fa-2x fa-heart text-dark icono-negro"></i>Añadir a favoritos</a>
        @endif
            @endauth

    </div>



    <div class="col-lg-12 mt-3">
        <nav>
            <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                <a class="nav-item nav-link lead active" id="nav-home-tab" data-toggle="tab" href="#descripcion" role="tab" aria-controls="descripcion" aria-selected="true">Descripcion</a>
                <a class="nav-item nav-link lead" id="nav-profile-tab" data-toggle="tab" href="#localizacion" role="tab" aria-controls="localizacion" aria-selected="false">Localización</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="descripcion" role="tabpanel" aria-labelledby="nav-home-tab">{{$producto->descripcion}}</div>
            <div class="tab-pane fade" id="localizacion" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div id="googleMap" style="width:100%;height:400px;"></div>
            </div>
        </div>
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

            map.setOptions({minZoom: 14, maxZoom: 14});
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Aqui se encuentra el usuario',
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 100,
                    fillColor: "#4285f4",
                    fillOpacity: 0.4,
                    strokeWeight: 0.4
                },
            });

            $('.carousel').carousel({
                interval: false
            });
        }


        $('#poner_favorito').click(function ()
        {
            var route= "{{route('poner_favorito',$producto->id)}}";

            $.ajax({
                type: "GET",
                dataType: "json",
                url: route,
                success: function(data) {
                    if(data!=='' && data=='si') {
                       $('#poner_favorito').empty();
                       $('#poner_favorito').append("<i class='far fa-2x fa-heart text-danger icono-rojo'></i>Quitar de  favoritos")

                    }else{
                        $('#poner_favorito').empty();
                        $('#poner_favorito').append("<i class='far fa-2x fa-heart text-dark icono-negro '></i>Añadir a favoritos")
                    }
                }
            })

        })

    </script>
@endsection