<!-- include del nav y de los enlaces de estilos-->
@extends('templates.main')

@section('titulo_pagina', 'ver-'.$producto->nombre)

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
        {!! Form::Open(['route'=>['modificar_producto',$producto->id],'method'=>'PUT','files'=>true, 'class'=>'row justify-content-center']) !!}
        <div class="col-lg-8">
            <div class="md-form">
                {!! Form::label('nombre','Nombre') !!}
                {!! Form::Text('nombre',$producto->nombre,['class'=>'form-control','required','placeholder'=>'']) !!}
            </div>
            <div class="md-form">
                {!! Form::label('precio','Precio') !!}
                {!! Form::number('precio',$producto->precio,['class'=>'form-control','required','placeholder'=>'','min'=>0]) !!}
            </div>
            <div class="form-group form-row">
                <div class="col-2">
                    {!! Form::label('categoria_id','Categoria') !!}
                </div>
                <div class="col-3">
                    {!! Form::select('categoria_id',$categorias,$producto->categoria->nombre,['class'=>'form-control','required']) !!}
                </div>
            </div>
            <div class="md-form">
                {!! Form::textarea('descripcion',$producto->descripcion,['class'=>'form-control md-textarea','required','placeholder'=>'Descripcion Producto']) !!}
            </div>
            {{--<div class="form-group">--}}
                {{--{!! Form::label('imagen','Imagen') !!}--}}
                {{--{!! Form::File('imagen[]',['class'=>'btn btn-outline-primary','multiple'=>'multiple']) !!}--}}
            {{--</div>--}}
            <div class="md-form text-center">
                {!!Form::submit('Modificar articulo',['class'=>'btn btn-outline-primary'])!!}
            </div>
            {!! Form::close() !!}
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


@endsection