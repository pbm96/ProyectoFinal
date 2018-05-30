@extends('templates.main')
@section('titulo_pagina', 'Perfil de '.$usuario->nombre_usuario)
@section('estilos')
    <style>
    .media .avatar {
    width: 64px;
    }

    </style>
    @endsection
@section('contenido')

<div class="container">
<div class="row">
    <div class="offset-1"></div>
    <div class="card testimonial-card col-sm-9 ">

        <div class="row">
        <div class="card-up  lighten-1 mt-3">
            <div class="avatar ml-5 white"><img src="{{ asset('imagenes/perfil/'.$usuario->imagen)}}" height="250" width="250" class="rounded-circle">
            </div>
        </div>
            <div class=" offset-3 mt-5">
                <div class="row mt-5">
                    <table class="table table-bordered table-responsive b text-center">

                        <tr>
                            <th>Productos Subidos</th>
                            <th>Productos Vendidos</th>

                        </tr>
                        <tr>
                            <td>{{count($productos_user)+count($productos_vendidos_user)}}</td>
                            <td>{{count($productos_vendidos_user)}}</td>
                        </tr>
                    </table>
                </div>
        </div>
        </div>

        <div class="card-body ml-5">
            <!-- Name --><div class="row">
            <h4 class="card-title ml-5 "><i class="fas fa-user text-primary"></i> {{$usuario->nombre}}</h4>
                <div class="ml-4">
                    @for($i=0;$i<$usuario->valoracion;$i++)
                    <i class="fas fa-star yellow-text"></i>
                        @endfor
                    @for($i=0;$i<5-$usuario->valoracion;$i++)
                            <i class="far fa-star "></i>
                        @endfor

                </div>
            </div>
            <hr>
            <!-- Quotation -->
            <p class="text-right"><i class="fa fa-clock text-primary"></i> Usuario desde {{$fecha_user}}</p>
        </div>

    </div>
</div>

    <ul class="nav nav-tabs nav-justified  aqua-gradient text-white mt-5" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel5" role="tab"><i class="fas fa-shopping-basket"></i> Productos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel6" role="tab"><i class="fas fa-dollar-sign"></i> Vendidos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel7" role="tab"><i class="fas fa-star"></i> Valoraciones</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel8" role="tab"><i class="fas fa-map-marker"></i> Localizacion</a>
        </li>
    </ul>
    <!-- Tab panels -->
    <div class="tab-content">
        <!--Panel 1-->
        <div class="tab-pane fade in show active" id="panel5" role="tabpanel">
            <br>
            @if(count($productos_user)>0)
            @foreach($productos_user->chunk(4) as $productChunk)

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

            @else
                <h2>{{$usuario->nombre}} No tiene ningun producto subido</h2>
            @endif
        </div>
        <!--/.Panel 1-->
        <!--Panel 2-->
        <div class="tab-pane fade" id="panel6" role="tabpanel">
            <br>
            @if(count($productos_vendidos_user)>0)
            @foreach($productos_vendidos_user->chunk(4) as $productChunk)

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

                @else
                <br>
                <h2>{{$usuario->nombre}} No ha vendido ningún producto</h2>
            @endif
        </div>
        <!--/.Panel 2-->
        <!--Panel 3-->



        <div class="tab-pane fade" id="panel7" role="tabpanel">

            @if($datos_user_venta!='')

            @foreach($datos_user_venta as $key=>$vendido_a)

            @if($datos_venta_producto[$key]->comentario_venta_comprador!=null || $datos_venta_producto[$key]->valoracion_venta_comprador!=null)

            <br>
                <div class="media col-sm-8">
                <img class="d-flex rounded-circle avatar z-depth-1-half mr-3" src="{{asset('imagenes/perfil/'.$vendido_a->imagen)}}" height="60" width="15" alt="Avatar">
                <div class="media-body">
                   <div class="row"><h5 class="mt-0 ml-3 font-weight-bold blue-text">{{$vendido_a->nombre_usuario}}</h5>
                           @if($datos_venta_producto[$key]->valoracion_venta_comprador!=null)
                           <div class="ml-3">
                               @for($i=0;$i<$datos_venta_producto[$key]->valoracion_venta_comprador;$i++)
                                   <i class="fas fa-star yellow-text"></i>
                               @endfor
                               @for($i=0;$i<5-$datos_venta_producto[$key]->valoracion_venta_comprador;$i++)
                                   <i class="far fa-star "></i>
                               @endfor
                           </div>
                        @endif
                   </div>
                    @if($datos_venta_producto[$key]->comentario_venta_comprador!=null)

                       {{$datos_venta_producto[$key]->comentario_venta_comprador}}
                    @endif
                </div>
                </div>

            @endif
            @endforeach
                @endif
               @if($productos_comprados_user!='')

                @foreach($productos_comprados_user as $key=>$producto)
                    <br>
                    <div class="media col-sm-8">
                        <img class="d-flex rounded-circle avatar z-depth-1-half mr-3" src="{{asset('imagenes/perfil/'.$datos_user_compra[$key]->imagen)}}" width="15" height="60" alt="Avatar">
                        <div class="media-body">
                            <div class="row"><h5 class="mt-0 ml-3 font-weight-bold blue-text">{{$datos_user_compra[$key]->nombre_usuario}}</h5>
                                @if($producto->valoracion_venta_vendedor!=null)
                                    <div class="ml-3">
                                        @for($i=0;$i<$producto->valoracion_venta_vendedor;$i++)
                                            <i class="fas fa-star yellow-text"></i>
                                        @endfor
                                        @for($i=0;$i<5-$producto->valoracion_venta_vendedor;$i++)
                                            <i class="far fa-star "></i>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                            @if($producto->comentario_venta_vendedor!=null)

                                {{$producto->comentario_venta_vendedor}}
                            @endif
                        </div>
                    </div>
                    @endforeach

            @endif


        </div>
        <!--/.Panel 3-->
        <div class="tab-pane fade" id="panel8" role="tabpanel">
            <br>
            <div id="googleMap" style="width:100%;height:400px;"></div>
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
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!',
            });}

        $('.carousel').carousel({
            interval:false
        })


    </script>
@endsection
