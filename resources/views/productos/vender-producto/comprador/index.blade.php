<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'valoracion-compra')

@section('estilos')
    <style>
        .carousel {
            box-shadow: #aeb9cc 5px 5px 5px;
        }

        h4 {
            display: inline;
        }

        .rating-stars ul {
            list-style-type: none;
            padding: 0;

            -moz-user-select: none;
            -webkit-user-select: none;

            cursor: pointer;
        }

        .rating-stars ul > li.star {
            display: inline-block;

        }

        /* Idle State of the stars */
        .rating-stars ul > li.star > i.fa {
            font-size: 1.5em; /* Change the size of the stars */
            color: #ccc; /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul > li.star.hover > i.fa {
            color: #FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul > li.star.selected > i.fa {
            color: #FF912C;
        }


    </style>

@endsection


@section('contenido')
    <div class="row justify-content-end mb-2" style="margin-right: 16%" >
        <a href="{{route('cancelar_valoracion',$venta->id)}}" class="btn btn-warning">No valorar</a>
    </div>

    {!! Form::Open(['route'=>['guardar_valoracion_comprador',$venta->id],'method'=>'POST', 'class'=>'row justify-content-center']) !!}

    <div class="card col-sm-8 ">
        <div class="card-body">

            <p class="h4 text-center py-4">Compra de {{$producto->nombre}}</p>

            <div class="mt-3 col-sm-5 ml-4 ">
                <h6>Valoracion Compra</h6>
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
                    {!! Form::hidden('valoracion_compra',null,['id'=>'valoracion_venta']) !!}
                </div>
            </div>

            <div class="md-form ">

                <div class="form-group shadow-textarea">
                    <i class=" fas fa-comments prefix grey-text"></i>
                    <textarea class="form-control z-depth-1" id="exampleFormControlTextarea6" rows="3"
                              placeholder="Escribir comentario compra..." name="comentario_compra"></textarea>
                </div>
            </div>

            <div class="text-center py-4 mt-3">
                {!!Form::submit('Valorar',['class'=>'btn btn-outline-primary'])!!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>


@endsection


<!-- seccion  de los enlaces de scripts-->
@section('scripts')
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


    </script>

@endsection