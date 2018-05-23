<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'vender-'.$producto->nombre)

@section('estilos')
    <style>
        .carousel{
            box-shadow: #aeb9cc 5px 5px 5px;
        }
        h4{
            display: inline;
        }

        .rating-stars ul {
            list-style-type:none;
            padding:0;

            -moz-user-select:none;
            -webkit-user-select:none;

            cursor: pointer;
        }
        .rating-stars ul > li.star {
            display:inline-block;

        }

        /* Idle State of the stars */
        .rating-stars ul > li.star > i.fa {
            font-size:1.5em; /* Change the size of the stars */
            color:#ccc; /* Color on idle state */
        }

        /* Hover state of the stars */
        .rating-stars ul > li.star.hover > i.fa {
            color:#FFCC36;
        }

        /* Selected state of the stars */
        .rating-stars ul > li.star.selected > i.fa {
            color:#FF912C;
        }
        .ui-menu .ui-widget {
            overflow: auto;
            max-height: 10em;
        }




    </style>

@endsection


@section('contenido')

    @if($producto!=null)
        <h2> venta de {{$producto->nombre}}</h2>
        {!! Form::Open(['route'=>['guardar_venta_producto',$producto->id],'method'=>'POST', 'class'=>'row justify-content-center']) !!}
        <div class="col-lg-8">
            <div class="md-form">
                {!! Form::label('precio','Precio de venta final') !!}
                {!! Form::number('precio_venta',null,['class'=>'form-control','required','placeholder'=>$producto->precio,'min'=>0]) !!}
            </div>
            <div class="md-form">
                {!! Form::label('usuario','Usuario al que se lo vendiste') !!}
                <input type="text" class="form-control" required id="usuarios" autocomplete="on">
            </div>

            <div class="md-form">
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
            <div class="md-form">
                {!! Form::textarea('comentario_venta',null,['class'=>'form-control md-textarea','required','placeholder'=>'Comentario Venta']) !!}
            </div>

            <div class="md-form text-center">
                {!!Form::submit('Confirmar Venta',['class'=>'btn btn-outline-primary'])!!}
            </div>
            {!! Form::close() !!}
        </div>
    @else
        <div class="alert-danger h-50 text-center">
            <h3>No se ha encontrado el  producto</h3>
        </div>

    @endif
@endsection


<!-- seccion  de los enlaces de scripts-->
@section('scripts')
<script>
    $(document).ready(function(){

        /* 1. Visualizing things on Hover - See next part for action on click */
        $('#stars li').on('mouseover', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e){
                if (e < onStar) {
                    $(this).addClass('hover');
                }
                else {
                    $(this).removeClass('hover');
                }
            });

        }).on('mouseout', function(){
            $(this).parent().children('li.star').each(function(e){
                $(this).removeClass('hover');
            });
        });


        /* 2. Action to perform on click */
        $('#stars li').on('click', function(){
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
            source: function( request, response ) {
                $.ajax({
                    type: "GET",
                    data: {usuario: $('#usuarios').val()},
                    url: route_autocomplete,
                    success: function (data) {
                     response(data)
                    }
                })
            }

    })







</script>

@endsection