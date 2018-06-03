<!-- include del nav y de los enlaces de estilos-->

@extends('templates.main') 
@section('titulo_pagina', 'Home') 
@section('estilos')
<style>
    .card-title {
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    . {
        margin: 0;
        padding: 0;
        box-sizing: border-box
    }

    input[type=checkbox],
    input[type=radio] {
        display: none;
    }

    input[type=checkbox]+label:before {
        /*     content: "\2713"; */
        content: " ";
        color: transparent;
        display: inline-block;
        font-size: 20px;
        line-height: 22px;
        margin: -5px 5px 0 0;
        width: 18px;
        height: 18px;
        text-align: center;
        vertical-align: middle;
        transition: color ease .3s;
        border: 2px rgba(0, 0, 0, 0.54) solid;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        -webkit-border-radius: 3px;
        border-radius: 3px;
    }

    input[type=checkbox]:checked+label:before {
        color: #000;

        background-image: url("data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcKICAgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIgogICB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIgogICB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiCiAgIHhtbG5zOnN2Zz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiAgIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIKICAgdmVyc2lvbj0iMS4xIgogICB2aWV3Qm94PSIwIDAgMSAxIgogICBwcmVzZXJ2ZUFzcGVjdFJhdGlvPSJ4TWluWU1pbiBtZWV0Ij4KICA8cGF0aAogICAgIGQ9Ik0gMC4wNDAzODA1OSwwLjYyNjc3NjcgMC4xNDY0NDY2MSwwLjUyMDcxMDY4IDAuNDI5Mjg5MzIsMC44MDM1NTMzOSAwLjMyMzIyMzMsMC45MDk2MTk0MSB6IE0gMC4yMTcxNTcyOSwwLjgwMzU1MzM5IDAuODUzNTUzMzksMC4xNjcxNTcyOSAwLjk1OTYxOTQxLDAuMjczMjIzMyAwLjMyMzIyMzMsMC45MDk2MTk0MSB6IgogICAgIGlkPSJyZWN0Mzc4MCIKICAgICBzdHlsZT0iZmlsbDojZmZmZmZmO2ZpbGwtb3BhY2l0eToxO3N0cm9rZTpub25lIiAvPgo8L3N2Zz4K");
        background-color: #2196F3;
        border-color: #2196F3;
        -webkit-mask-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxIDEiPjx0aXRsZT51bnRpdGxlZDwvdGl0bGU+PHBhdGggZD0iTTAsMFYxSDFWMEgwWk0wLjQ1LDAuNzRsLTAuMDguMDhMMC4yOCwwLjc0LDAuMTQsMC42bDAuMDgtLjA4TDAuMzYsMC42NWwwLjQxLS40MUwwLjg2LDAuMzJaIi8+PC9zdmc+");
        mask-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxIDEiPjx0aXRsZT51bnRpdGxlZDwvdGl0bGU+PHBhdGggZD0iTTAsMFYxSDFWMEgwWk0wLjQ1LDAuNzRsLTAuMDguMDhMMC4yOCwwLjc0LDAuMTQsMC42bDAuMDgtLjA4TDAuMzYsMC42NWwwLjQxLS40MUwwLjg2LDAuMzJaIi8+PC9zdmc+");
    }
</style>
@endsection
 
@section('contenido')

<div class="row justify-content-around mb-4">
    <div class="card col-lg-12" style="padding: 0">
        <div class="card-header text-right" onclick="$('#filtro').slideToggle()">
            <h3>Filtrar productos <span class="fa fa-caret-down"></span></h3>
        </div>
        <div class="card-body collapse" id="filtro">
            {!! Form::Open(['route'=>'index','method'=>'GET']) !!}
            <div class="row justify-content-center">
                <div class="form-group col-lg-4 col-md-5">
                    <h4 onclick="$('#listaCategorias').slideToggle()"><a href="#" class="text-dark">Categorias <span class="fa fa-caret-down"></span></a></h4>
                    <div class="collapse" id="listaCategorias">

                        <?php $cat = \Illuminate\Support\Facades\Input::has('categoriasSeleccionadas') ? \Illuminate\Support\Facades\Input::get('categoriasSeleccionadas'):[] ?> @foreach($listaCategorias as $clave=>$categoria)

                        <input class="checkbox__input" type="checkbox" id="{{ $categoria->nombre }}" name="categoriasSeleccionadas[]" value="{{$categoria->id}}"
                            {{ in_array($categoria->id, $cat) ? 'checked':'' }} />
                        <label class="checkbox__label" for="{{ $categoria->nombre }}"> {{ $categoria->nombre }}</label> <br>                        
                        @endforeach
                    </div>
                </div>
                <div class="form-group col-lg-4 col-md-5">
                    <h4><label for="orden">Orden</label></h4>
                    {!! Form::select('orden',array( 'precio,asc' => 'Precio ascendiente', 'precio,desc' => 'Precio descendente', 'created_at,desc'
                    => 'Más nuevos primero', 'created_at,asc' => 'Más antiguos primero'),null,['class'=>'form-control'])
                    !!}
                    <hr>
                    <label for="slider2" id="sliderValue"></label>
                    <input id="slider2" type="text" name="slider" onchange="showPrecioValue()" class="span2" value="" data-slider-min="0"
                        data-slider-max="10000" data-slider-step="5" data-slider-value="[0,10000]" />
                
                </div>
            </div>
            <input type="hidden" value="{{\Illuminate\Support\Facades\Input::get('buscar')}}" name="buscar" >
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
            <div class="card-header">
                @if(count($producto->imagen)>0)

                <img src="{{ asset('imagenes/productos/'.$producto->imagen[0]->nombre) }}" alt="Imagen del producto" style="width:100%" height="160"
                    class="card-img-top"> @else
                <img src="{{ asset('imagenes/productos/fakeapop_default.png') }}" alt="Imagen del producto" style="width:100%" class="card-img-top">                @endif
            </div>

            <div class="card-body">
                <h4 class="card-title"> {{ $producto->nombre }} </h4>
                <p class="card-text h3"> {{ $producto->precio }} €</p>
                <a href="{{route('ver_producto',$producto->id)}}" class="btn btn-outline-info"> Más datos </a>
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

<script>
    var elementoPrecio = $("#slider2");
        $(function() {
            let url = new URL(location.href);

            let slider = document.getElementsByName('slider')[0]

            if(url.searchParams.get('slider') !== null){
                slider.dataset.sliderValue = "["+url.searchParams.get('slider')+"]";
            }
            
            elementoPrecio.slider({});

            showPrecioValue();
         });

        function showPrecioValue(){
            
            precio = elementoPrecio[0].value.split(',');

            $('#sliderValue').html(`Precio entre los ${precio[0]} € y los ${precio[1]} €`)
        }

        function toggleCategorias(){
            $('#listacategorias').toggle();
        }
</script>

@endsection