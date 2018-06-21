<!-- include del nav y de los enlaces de estilos-->


@extends('templates.main') 
@section('titulo_pagina', 'Home') 
@section('estilos')
@endsection
 
@section('contenido')
<div class="row justify-content-around mb-4 d-block d-sm-none ">
    <div class="col-lg-4">
        {{ Form::open(['route' => ['buscador'], 'method' => 'GET', 'class' => 'form-inline']) }}
        <div class="md-form my-0 ">
            {{ Form::text('buscar', old('buscar'), array('placeholder'=>'Buscar...','class'=>'form-control mr-sm-2','aria-label'=>'buscar'))
            }}
            <button class="btn btn-outline-primary btn-sm d-inline" type="submit">Buscar</button>
        </div>
        {{ Form::close() }}
    </div>
</div>
<div class="row justify-content-around mb-4 mt-4">
    <div class="card col-lg-12" style="padding: 0">
        <div class="card-header text-right" onclick="$('#filtro').slideToggle()">
            <h3>Filtrar productos <span class="fa fa-caret-down"></span></h3>
        </div>
        <div class="card-body collapse" id="filtro">
            {!! Form::Open(['route'=>'index','method'=>'GET']) !!}
            <div class="row justify-content-center">
                <div class="form-group col-lg-4 col-md-5">
                    <h4 onclick="$('#listaCategorias').slideToggle()"><a href="#" class="text-dark">Categorias <span
                                        class="fa fa-caret-down"></span></a></h4>
                    <div class="collapse" id="listaCategorias">

                        <?php $cat = \Illuminate\Support\Facades\Input::has('categoriasSeleccionadas') ? \Illuminate\Support\Facades\Input::get('categoriasSeleccionadas') : [] ?> @foreach($listaCategorias as $clave=>$categoria)

                        <input class="checkbox__input" type="checkbox" id="{{ $categoria->nombre }}" name="categoriasSeleccionadas[]" value="{{$categoria->id}}"
                            {{ in_array($categoria->id, $cat) ? 'checked':'' }} />
                        <label class="checkbox__label" for="{{ $categoria->nombre }}"> {{ $categoria->nombre }}</label> <br>                        @endforeach
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-5">
                    <h4><label for="orden">Orden</label></h4>
                    {!! Form::select('orden',array( 'precio,asc' => 'Precio ascendiente', 'precio,desc' => 'Precio descendente', 'created_at,desc'
                    => 'Más nuevos primero', 'created_at,asc' => 'Más antiguos primero'),null,['class'=>'form-control'])
                    !!}
                    <hr>
                    <label for="slider2" id="sliderValue"></label>
                    <input id="slider2" type="text" name="slider" onchange="showPrecioValue()" class="span2" value="" data-slider-min="0" data-slider-max="10000"
                        data-slider-step="5" data-slider-value="[0,10000]" />

                </div>
            </div>
            <input type="hidden" value="{{\Illuminate\Support\Facades\Input::get('buscar')}}" name="buscar">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    {!!Form::submit('Filtrar',['class'=>'btn btn-outline-primary'])!!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@foreach($productos->chunk(4) as $productChunk)

<div class="row">
    @foreach($productChunk as $producto)
    <div class="col-lg-3 col-md-6 col-sm-12 mb-5">
        <div class="card">
            <div class="card-header imagenes_productos">
                @if(count($producto->imagen)>0)

                <img src="{{ asset('imagenes/productos/'.$producto->imagen[0]->nombre) }}" alt="Imagen del producto" style="width:100%" height="200"
                    class="card-img-top "> @else
                <img src="{{ asset('imagenes/productos/fakeapop_default.png') }}" alt="Imagen del producto" style="width:100%" class="card-img-top "
                    height="200"> @endif
            </div>

            <div class="card-body">
                <h4 class="card-title"> {{ $producto->nombre }} </h4>
                <p class="card-text h3"> {{ $producto->precio }} €</p>
                <a href="{{route('ver_producto',$producto->id)}}" class="btn btn-outline-info"> Más
                                datos </a>
                <p class="card-text h3 text-right"> creado hace {{$producto->diferencia}}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endforeach
<div class="row justify-content-center">{{ $productos->appends(Request::only(['categoriasSeleccionadas','slider','orden', 'buscar']))->links() }}</div>
@endsection


<!-- seccion  de los enlaces de scripts-->


@section('scripts')

<script>
    var elementoPrecio = $("#slider2");
        $(function () {
            let url = new URL(location.href);

            let slider = document.getElementsByName('slider')[0]

            if (url.searchParams.get('slider') !== null) {
                slider.dataset.sliderValue = "[" + url.searchParams.get('slider') + "]";
            }

            elementoPrecio.slider({});

            showPrecioValue();
        });

        function showPrecioValue() {

            precio = elementoPrecio[0].value.split(',');

            $('#sliderValue').html(`Precio entre los ${precio[0]} € y los ${precio[1]} €`)
        }

        function toggleCategorias() {
            $('#listacategorias').toggle();
        }
</script>
@endsection