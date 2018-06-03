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
        <div class="card col-sm-8 ">
            <div class="card-body">

                <p class="h4 text-center py-4">Editar Producto</p>
                <div class="row">
                    <div class="md-form col-sm-8 pl-0">
                        <i class="fas fa-mobile-alt prefix grey-text pl-2"></i>

                        {!! Form::Text('nombre',$producto->nombre,['class'=>'form-control','required']) !!}
                        {!! Form::label('nombre','Nombre Producto') !!}
                    </div>

                    <div class="md-form col-sm-3 offset-1 pl-0">
                        <i class="fa fa-euro-sign prefix grey-text"></i>
                        {!! Form::number('precio',$producto->precio,['class'=>'form-control','required','min'=>0]) !!}
                        {!! Form::label('precio','Precio') !!}
                    </div>
                </div>
                <div class="form-group form-row mt-4">
                    <div class=" col-sm-8">
                        <i class="fas fa-images fa-2x prefix grey-text pl-2"></i>
                        {!! Form::File('imagen[]',['class'=>'btn btn-outline-primary','multiple'=>'multiple']) !!}
                    </div>
                    <div class="col-sm-4 ">
                        {!! Form::select('categoria_id',$categorias,$producto->categoria->nombre,['class'=>'form-control h-75 mt-2','required']) !!}
                    </div>
                </div>

                <div class="md-form">

                    <div class="form-group shadow-textarea">
                        <i class=" fas fa-pencil-alt prefix grey-text"></i>
                        {!! Form::textarea('descripcion',$producto->descripcion,['class'=>'form-control z-depth-1','required','placeholder'=>'Escribir descripción del producto...','rows'=>'8']) !!}
                    </div>
                </div>

                <div class="text-center py-4 mt-3">
                    {!!Form::submit('Editar Producto',['class'=>'btn btn-outline-primary'])!!}
                </div>

            </div>
        </div>


        {!! Form::close() !!}
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

