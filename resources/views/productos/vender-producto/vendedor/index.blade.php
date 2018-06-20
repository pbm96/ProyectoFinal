<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'vender-'.$producto->nombre)

@section('estilos')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet">

    <style>


    </style>

@endsection


@section('contenido')

    @if($producto!=null)


        {!! Form::Open(['route'=>['guardar_venta_producto',$producto->id],'method'=>'POST','class'=>'row justify-content-center' ]) !!}
        <div class="card col-sm-8 ">
            <div class="card-body">

                <p class="h4 text-center py-4">Venta de {{$producto->nombre}}</p>
                <div class="row">
                    <div class="md-form col-sm-8 pl-0">
                        <i class="fa fa-user prefix grey-text pl-2"></i>
                        <input type="text" class="form-control" required id="usuarios" autocomplete="on"
                               name="nombre_usuario" value="{{old('nombre_usuario')}}">
                        {!! Form::label('usuario','Usuario al que se lo vendiste') !!}
                    </div>

                    <div class="md-form col-sm-3 offset-1 pl-0">
                        <i class="fa fa-euro-sign prefix grey-text"></i>

                        {!! Form::number('precio_venta',null,['class'=>'form-control','required','placeholder'=>$producto->precio,'min'=>0]) !!}
                        {!! Form::label('precio','Precio de venta final') !!}

                        @if ($errors->has('precio_venta'))
                            <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('precio_venta') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="mt-3 col-sm-5 ">
                    <h6>Valoracion Venta</h6>
                    <div class='rating-stars '>
                        <ul id='stars'>
                            <li class='star' title=' Muy Mala' data-value='1' onclick="valoracion(1)">
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' title='Mala' data-value='2' onclick="valoracion(2)">
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' title='Buena' data-value='3' onclick="valoracion(3)">
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' title='Muy Buena' data-value='4' onclick="valoracion(4)">
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' title='Excelente' data-value='5' onclick="valoracion(5)">
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                        </ul>
                        {!! Form::hidden('valoracion_venta',null,['id'=>'valoracion_venta']) !!}
                    </div>
                </div>

                <div class="md-form mr-3">

                    <div class="form-group shadow-textarea">
                        <i class=" fas fa-comments prefix grey-text"></i>
                        <textarea class="form-control z-depth-1" id="exampleFormControlTextarea6" rows="3"
                                  placeholder="Escribir comentario venta..." name="comentario_venta">{{old('comentario_venta')}}</textarea>
                    </div>
                    @if ($errors->has('comentario_venta'))
                        <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('comentario_venta') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="text-center py-4 mt-3">
                    {!!Form::submit('Confirmar Venta',['class'=>'btn btn-outline-primary'])!!}
                </div>

            </div>
        </div>


    @else
        <div class="alert-danger h-50 text-center">
            <h3>No se ha encontrado el producto</h3>
        </div>

    @endif
@endsection


<!-- seccion  de los enlaces de scripts-->
@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {

            /* 1. Visualizing things on Hover - See next part for action on click */
            $('#stars li').on('mouseover', function () {
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li.star').each(function (e) {
                    if (e < onStar) {
                        $(this).addClass('hover');
                    }
                    else {
                        $(this).removeClass('hover');
                    }
                });

            }).on('mouseout', function () {
                $(this).parent().children('li.star').each(function (e) {
                    $(this).removeClass('hover');
                });
            });


            /* 2. Action to perform on click */
            $('#stars li').on('click', function () {
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

            });


        });

        function valoracion(valoracion) {
            $('#valoracion_venta').val(valoracion)
        }

        var route_autocomplete = "{{route('buscar_usuario')}}";
        $('#usuarios').autocomplete({
            minLength: 2,
            source: function (request, response) {
                $.ajax({
                    type: "GET",
                    data: {usuario: $('#usuarios').val()},
                    url: route_autocomplete,
                    success: function (item) {

                        response(item);
                    }
                })
            }

        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var img_src;

            img_src = '{{ asset('imagenes/perfil/:imagen') }}';

            img_src = img_src.replace(':imagen', item.imagen);


            return $('<li class="lista_nombres">')
                .data( "ui-autocomplete-item", item )
                .append("<div class=' pl-4 h6 w-100 lista_nombres'><img src='" + img_src + " '  class='avatar rounded-circle mr-1 ' width='50' height='50' ><span class='text-primary '>@</span>" + item.value + "</div>")
                .appendTo(ul);

        };


    </script>

@endsection