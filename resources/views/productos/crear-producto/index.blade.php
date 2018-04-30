
@extends('templates.main')
@section('estilos')
<style>
    
</style>
@endsection
@section('contenido')
{!! Form::Open(['route'=>'guardar_producto','method'=>'POST','files'=>true, 'class'=>'row justify-content-center']) !!}
    <div class="col-lg-8">
        <div class="md-form">
            {!! Form::label('nombre','Nombre') !!}
            {!! Form::Text('nombre',null,['class'=>'form-control','required','placeholder'=>'']) !!}
        </div>
        <div class="md-form">
            {!! Form::label('precio','Precio') !!}
            {!! Form::number('precio',null,['class'=>'form-control','required','placeholder'=>'','min'=>0]) !!}
        </div>
        <div class="form-group form-row">
            <div class="col-2">
                {!! Form::label('categoria_id','Categoria') !!}
            </div>
            <div class="col-3">
                {!! Form::select('categoria_id',$categorias,null,['class'=>'form-control','required']) !!}
            </div>
        </div>
        <div class="md-form">
            {!! Form::textarea('descripcion',null,['class'=>'form-control md-textarea','required','placeholder'=>'Descripcion Producto']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('imagen','Imagen') !!}
            {!! Form::File('imagen[]',['class'=>'btn btn-outline-primary','multiple'=>'multiple']) !!}
        </div>
        <div class="md-form text-center">
            {!!Form::submit('Agregar articulo',['class'=>'btn btn-outline-primary'])!!}
        
        </div>
        {!! Form::close() !!}
    </div>
@endsection

