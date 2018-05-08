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
                {!! Form::text('nombre_usuario',null,['class'=>'form-control','required']) !!}
            </div>
            <div class="md-form">
                    {!! Form::label('precio','Valoracion Venta') !!}
                    {!! Form::number('valoracion_venta',null,['class'=>'form-control','required','max'=>5]) !!}
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


@endsection