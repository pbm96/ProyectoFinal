
@extends('templates.main')
@section('titulo_pagina', 'crear-producto')
@section('estilos')
<style>
    
</style>
@endsection
@section('contenido')


    {!! Form::Open(['route'=>'guardar_producto','method'=>'POST','files'=>true, 'class'=>'row justify-content-center']) !!}
<div class="card col-sm-8 ">
    <div class="card-body">

        <p class="h4 text-center py-4">Crear Producto</p>
        <div class="row">
            <div class="md-form col-sm-8 pl-0">
                <i class="fas fa-mobile-alt prefix grey-text pl-2"></i>

                {!! Form::Text('nombre',null,['class'=>'form-control','required']) !!}
                {!! Form::label('nombre','Nombre Producto') !!}
            </div>

            <div class="md-form col-sm-3 offset-1 pl-0">
                <i class="fa fa-euro-sign prefix grey-text"></i>
                {!! Form::number('precio',null,['class'=>'form-control','required','min'=>0]) !!}
                {!! Form::label('precio','Precio') !!}
            </div>
        </div>
        <div class="form-group form-row mt-4">
            <div class=" col-sm-8">
                <i class="fas fa-images fa-2x prefix grey-text pl-2"></i>
                {!! Form::File('imagen[]',['class'=>'btn btn-outline-primary','multiple'=>'multiple']) !!}
            </div>
            <div class="col-sm-4 ">
                {!! Form::select('categoria_id',$categorias,null,['class'=>'form-control h-75 mt-2','required']) !!}
            </div>
        </div>

        <div class="md-form">

            <div class="form-group shadow-textarea">
                <i class=" fas fa-pencil-alt prefix grey-text"></i>
                <textarea class="form-control z-depth-1" id="exampleFormControlTextarea6" rows="8"
                          placeholder="Escribir descripción del producto" name="descripcion"></textarea>
            </div>
        </div>

        <div class="text-center py-4 mt-3">
            {!!Form::submit('Agregar articulo',['class'=>'btn btn-outline-primary'])!!}
        </div>

    </div>
</div>
@endsection

