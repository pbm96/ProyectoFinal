@extends('templates.main')
@section('titulo_pagina', 'Perfil de '.$usuario->nombre_usuario)
@section('estilos')
    <style>
    </style>
@endsection

@section('contenido')

    <div class="row mt-5">
        <div class="col-lg-3 text-center mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-4 col-sm-4">
                            <div class="avatar m-auto">
                                @if($usuario->imagen!=null)
                                    <img src="{{ asset('imagenes/perfil/'.$usuario->imagen)}}"
                                         class="img-fluid rounded-circle">
                                @else
                                    <img src="{{ asset('imagenes/perfil/user-default.png')}}"
                                         class="img-fluid rounded-circle">

                                @endif
                            </div>
                            <hr class="d-md-none d-sm-none">
                        </div>
                        <div class="col-lg-12 col-md-8 col-sm-8 border-left">
                            <div class="row mt-3 justify-content-center">
                                <h4 class="card-title "><i class="fas fa-user text-primary"></i> {{$usuario->nombre}}
                                </h4>
                                <div class="ml-2 mt-1">
                                    @for($i=0;$i
                                        <$usuario->valoracion;$i++)
                                        <i class="fas fa-star yellow-text"></i>
                                    @endfor
                                    @for($i=0;$i
                                        <5-$usuario->valoracion;$i++)
                                        <i class="far fa-star "></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="h5 my-3">
                                <span class="badge bg-dark">{{count($productos_user)+count($productos_vendidos_user)}}</span>
                                Productos
                                <br>
                                <span class="badge bg-success">{{count($productos_vendidos_user)}}</span> Vendidos
                            </div>
                            <div class=" row justify-content-end">
                                @guest
                                    <a class="btn btn-primary" id="boton_mensaje" href="{{route('login')}}"> Chat</a>
                                @endguest
                                @auth
                                    @if(auth()->user()->id != $usuario->id)
                                        <a class="btn btn-primary" id="boton_mensaje"
                                           href="{{route('mis_mensajes',[auth()->user()->id,$usuario->id])}}"> Chat</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right container">
                    <small><i class="fa fa-clock text-primary"></i> Usuario desde {{$fecha_user}}</small>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="nav nav-tabs nav-justified  aqua-gradient text-white" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#panel5" role="tab"><i
                                class="fas fa-shopping-basket"></i> Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#panel6" role="tab"><i class="fas fa-dollar-sign"></i>
                        Vendidos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#panel7" role="tab"><i class="fas fa-star"></i>
                        Valoraciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#panel8" role="tab"><i class="fas fa-map-marker"></i>
                        Localizacion</a>
                </li>
            </ul>
            <!-- Paneles -->
            <div class="tab-content">
                <!--Panel 1-->
                <div class="tab-pane fade in show active" id="panel5" role="tabpanel">
                    <br> @if(count($productos_user)>0) @foreach($productos_user as $producto)
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            @if(count($producto->imagen)>0)
                                                <img src="{{ asset('imagenes/productos/'.$producto->imagen[0]->nombre) }}"
                                                     alt="Imagen del producto" style="width:100%;border-radius: 1em"
                                                     height="160"
                                                     class="card-img-top mt-2 ml-2 mb-2 img-responsive"> @else
                                                <img src="{{ asset('imagenes/productos/fakeapop_default.png') }}"
                                                     alt="Imagen del producto" style="width:100%;border-radius: 1em"
                                                     height="160" class="img-responsive mb-2  mt-2 ml-2">
                                            @endif
                                        </div>
                                        <div class=" col-md-8">
                                            <div class="card-body">
                                                <h4 class="card-title"> {{ $producto->nombre }} </h4>
                                                <p class="card-text h3"> {{ $producto->precio }} €</p>
                                                <a href="{{route('ver_producto',$producto->id)}}"
                                                   class="btn btn-outline-info"> Mas datos </a>
                                                <p class="card-text h3 text-right"> creado
                                                    hace {{$producto->diferencia}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @else
                        <div class="row justify-content-center">
                            <h2 class="h2">{{ $usuario->nombre }} No tiene ningun producto subido</h2>
                        </div>
                    @endif
                </div>
                <!--/.Panel 1-->
                <!--Panel 2-->
                <div class="tab-pane fade" id="panel6" role="tabpanel">
                    <br> @if(count($productos_vendidos_user)>0) @foreach($productos_vendidos_user as $producto)
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            @if(count($producto->imagen)>0)
                                                <img src="{{ asset('imagenes/productos/'.$producto->imagen[0]->nombre) }}"
                                                     alt="Imagen del producto" style="width:100%;border-radius: 1em"
                                                     height="160"
                                                     class="card-img-top mt-2 ml-2 img-responsive mb-2"> @else
                                                <img src="{{ asset('imagenes/productos/fakeapop_default.png') }}"
                                                     alt="Imagen del producto" style="width:100%;border-radius: 1em"
                                                     height="160" class="img-responsive  mt-2 ml-2 mb-2">
                                            @endif
                                        </div>
                                        <div class=" col-md-8">
                                            <div class="card-body">
                                                <h4 class="card-title"> {{ $producto->nombre }} </h4>
                                                <p class="card-text h3"> {{ $producto->precio }} €</p>
                                                <a href="{{route('ver_producto',$producto->id)}}"
                                                   class="btn btn-outline-info"> Mas datos </a>
                                                <p class="card-text h3 text-right"> creado
                                                    hace {{$producto->diferencia}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                        <br>
                        <div class="row justify-content-center">
                            <h2 class="h2">{{$usuario->nombre}} No ha vendido ningún producto</h2>
                        </div>
                    @endif
                </div>
                <!--/.Panel 2-->
                <!--Panel 3-->
                <div class="tab-pane fade" id="panel7" role="tabpanel">
                    @if($datos_user_venta!='') @foreach($datos_user_venta as $key=>$vendido_a) @if($datos_venta_producto[$key]->comentario_venta_comprador!=null
                || $datos_venta_producto[$key]->valoracion_venta_comprador!=null)
                        <br>
                        <div class="media col-sm-8">
                            @if($vendido_a->imagen !=null)
                                <img class="d-flex rounded-circle avatar z-depth-1-half mr-3"
                                     src="{{asset('imagenes/perfil/'.$vendido_a->imagen)}}" height="60"
                                     width="15" alt="Avatar">
                            @else
                                <img class="d-flex rounded-circle avatar z-depth-1-half mr-3"
                                     src="{{asset('imagenes/perfil/user-default.png')}}" height="60"
                                     width="15" alt="Avatar">
                            @endif
                            <div class="media-body">
                                <div class="row">
                                    <h5 class="mt-0 ml-3 font-weight-bold blue-text">{{$vendido_a->nombre_usuario}}</h5>
                                    @if($datos_venta_producto[$key]->valoracion_venta_comprador!=null)
                                        <div class="ml-3">
                                            @for($i=0;$i
                                            <$datos_venta_producto[$key]->valoracion_venta_comprador;$i++)
                                                <i class="fas fa-star yellow-text"></i> @endfor @for($i=0; $i
                                    <5-$datos_venta_producto[$key]->valoracion_venta_comprador; $i++)
                                                <i class="far fa-star"></i> @endfor
                                        </div>
                                    @endif
                                </div>
                                @if($datos_venta_producto[$key]->comentario_venta_comprador!=null) {{$datos_venta_producto[$key]->comentario_venta_comprador}}
                                @endif
                            </div>
                        </div>

                    @endif @endforeach @endif @if($productos_comprados_user!='') @foreach($productos_comprados_user as $key=>$producto)
                        <br>
                        <div class="media col-sm-8">
                            @if($datos_user_compra[$key]->imagen !=null)
                                <img class="d-flex rounded-circle avatar z-depth-1-half mr-3"
                                     src="{{asset('imagenes/perfil/'.$datos_user_compra[$key]->imagen)}}"
                                     width="15" height="60" alt="Avatar">
                            @else
                                <img class="d-flex rounded-circle avatar z-depth-1-half mr-3"
                                     src="{{asset('imagenes/perfil/user-default.png')}}" height="60"
                                     width="15" alt="Avatar">
                            @endif
                            <div class="media-body">
                                <div class="row">
                                    <h5 class="mt-0 ml-3 font-weight-bold blue-text">{{$datos_user_compra[$key]->nombre_usuario}}</h5>
                                    @if($producto->valoracion_venta_vendedor!=null)
                                        <div class="ml-3">
                                            @for($i=0;$i
                                            <$producto->valoracion_venta_vendedor;$i++)
                                                <i class="fas fa-star yellow-text"></i> @endfor @for($i=0;$i
                                    <5-$producto->valoracion_venta_vendedor;$i++)
                                                <i class="far fa-star "></i> @endfor
                                        </div>
                                    @endif
                                </div>
                                @if($producto->comentario_venta_vendedor!=null) {{$producto->comentario_venta_vendedor}} @endif
                            </div>
                        </div>
                    @endforeach @endif
                </div>
                <!--/.Panel 3-->
                <!-- Panel 4-->
                <div class="tab-pane fade" id="panel8" role="tabpanel">
                    <br>
                    <div id="googleMap" style="width:100%;height:400px;"></div>
                </div>
                <!-- /Panel 4-->

                <!-- /Paneles-->
            </div>
        </div>

    </div>
@endsection

@section('scripts')


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7G5aANtgkHs8FRZ6kyEsUOCwd4DG5QM"></script>
    <script>
        initMap();

        function initMap() {
                    {{$latitud=$direccion->latitud}}
                    {{$longitud=$direccion->longitud}}
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
        }

        $('.carousel').carousel({
            interval: false
        })

    </script>
@endsection