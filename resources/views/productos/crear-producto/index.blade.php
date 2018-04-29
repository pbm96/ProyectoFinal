
@extends('templates.main')
@section('titulo_pagina', 'Añadir-producto')
@section('contenido')

{!! Form::Open(['route'=>'guardar_producto','method'=>'POST','files'=>true]) !!}
<div class="container">
    <div class="form-row">
        <div class="form-group col-sm-9">
            {!! Form::label('nombre','Nombre') !!}
             {!! Form::Text('nombre',null,['class'=>'form-control','required','placeholder'=>'Nombre Producto']) !!}
        </div>
        <div class="form-group col-sm-3">
            {!! Form::label('precio','Precio') !!}
            <div class="input-group">
             {!! Form::number('precio',null,['class'=>'form-control','required','placeholder'=>'Precio Producto']) !!}
            <div class="input-group-prepend">
                <div class="input-group-text">€</div>
            </div>
            </div>
        </div>
    </div>
<div class="md-form">
    {!! Form::label('categoria_id','Categoria del producto') !!}
    {!! Form::select('categoria_id',$categorias,null,['class'=>'form-control','required']) !!}
</div>
<div class="md-form">
    {!! Form::label('descripcion','Descripcion del producto') !!}
    {!! Form::textarea('descripcion',null,['class'=>'form-control ','required','placeholder'=>'Descripcion Producto']) !!}
</div>
<div class="md-form">
    {!! Form::label('imagen','Imagenes') !!}
    {!! Form::File('imagen[]',['class'=>'form-control','multiple'=>'multiple']) !!}
</div>

    <div class="  mt-5">
         <div class=" row justify-content-end">
             {!!Form::submit('Añadir Producto',['class'=>'btn btn-primary'])!!}
         </div>
    </div>
</div>
{!! Form::close() !!}
    @endsection

