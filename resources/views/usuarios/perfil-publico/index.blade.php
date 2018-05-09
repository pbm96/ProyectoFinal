@extends('templates.main')
@section('titulo_pagina', 'Perfil de'.$usuario->nombre_usuario.'-Fakeapop')
@section('estilos')
    <style>
    .media .avatar {
    width: 64px;
    }
    .shadow-textarea textarea.form-control::placeholder {
    font-weight: 300;
    }
    .shadow-textarea textarea.form-control {
    padding-left: 0.8rem;
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
            <div class="avatar ml-5 white"><img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%2810%29.jpg" class="rounded-circle">
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
            <h4 class="card-title ml-5 "><i class="fas fa-user"></i> {{$usuario->nombre}}</h4>
                <div class="ml-4">
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>


                </div>
            </div>
            <hr>
            <!-- Quotation -->
            <p><i class="fa fa-quote-left"></i> Usuario desde {{$usuario->created_at}}</p>
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
            <div class="">{{ $productos_user->render() }}</div>
        </div>
        <!--/.Panel 1-->
        <!--Panel 2-->
        <div class="tab-pane fade" id="panel6" role="tabpanel">
            <br>
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
            <div class="">{{ $productos_vendidos_user->render() }}</div>
        </div>
        <!--/.Panel 2-->
        <!--Panel 3-->



        <div class="tab-pane fade" id="panel7" role="tabpanel">

            @foreach($datos_user_venta as $key=>$vendido_a)
            <br>
                <div class="media">
                <img class="d-flex rounded-circle avatar z-depth-1-half mr-3" src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.jpg" alt="Avatar">
                <div class="media-body">
                   <div class="row"><h5 class="mt-0 ml-3 font-weight-bold blue-text">{{$vendido_a->nombre_usuario}}</h5> <div class="ml-3"><i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> </div></div>
                    {{$datos_venta_producto[$key]->comentario_venta}}
                </div>
                </div>

   @endforeach

        </div>
        <!--/.Panel 3-->
        <div class="tab-pane fade" id="panel8" role="tabpanel">
            <br>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil odit magnam minima, soluta doloribus reiciendis molestiae placeat unde eos molestias. Quisquam aperiam, pariatur. Tempora, placeat ratione porro voluptate odit minima.</p>
        </div>
    </div>


</div>





@endsection

@section('scripts')


@endsection
