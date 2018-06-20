@extends('templates.main') 
@section('titulo_pagina', 'crear-producto') 
@section('contenido') 

@if ($errors->has('imagen[]'))
<span class="invalid-feedback ml-5" style="display:block">
    <strong>{{ $errors->first('imagen[]') }}</strong>
</span> @endif
@if ($errors->has('nombre'))
<span class="invalid-feedback ml-5" style="display:block">
    <strong>{{ $errors->first('nombre') }}</strong>
</span> @endif
@if ($errors->has('precio'))
<span class="invalid-feedback ml-5" style="display:block">
    <strong>{{ $errors->first('precio') }}</strong>
</span> @endif
@if ($errors->has('descripcion'))
<span class="invalid-feedback ml-5" style="display:block">
    <strong>{{ $errors->first('descripcion') }}</strong>
</span> @endif

{!! Form::Open(['route' => 'guardar_producto','method'=>'POST', 'enctype'=> 'multipart/data', 'files' => true ,'class'=>'row
justify-content-center']) !!}
<div class="card col-sm-8 ">
    <div class="card-body">
        <p class="h4 text-center py-4">Crear Producto</p>
        <div class="row justify-content-around">
            <div class="col-sm-12">
                <div class="card contenedorImagenes container p-4">
                    <div class="form-group">
                        <label class="btn btn-outline-info" for="image_uploads">Choose images to upload (PNG, JPG)</label>
                        <input type="file" id="image_uploads" name="imagen[]" accept=".jpg, .jpeg, .png" multiple>
                    </div>
                    <div class="preview">
                        <p>No hay archivos seleccionados</p>
                    </div>
                </div>

            </div>
        </div>
        @if ($errors->has('imagen'))
            <span class="invalid-feedback ">
                                        <strong>{{ $errors->first('imagen') }}</strong>
                                    </span>
        @endif
        <div class="row justify-content-around text-center">
            <div class="md-form col-sm-7  pl-0  ">

            <input type="text" class="form-control {{ $errors->has('nombre') ? ' invalid' : '' }}"  name="nombre" value="{{old('nombre')}}" required>

                {!! Form::label('nombre','Producto') !!}

            @if ($errors->has('nombre'))
                    <span class="invalid-feedback mr-5">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="md-form col-sm-3 offset-1 pl-0">
                <input type="number" class="form-control {{ $errors->has('precio') ? ' invalid' : '' }}" min="0" name="precio" value="{{old('precio')}} " required>
                {!! Form::label('precio','Precio')
               !!}
                @if ($errors->has('precio'))
                    <span class="invalid-feedback  ">
                                        <strong>{{ $errors->first('precio') }}</strong>
                                    </span>
                @endif
            </div>

        </div>
        <div class="form-group form-row mt-4 ">
            <div class="col-sm-4 ">
                {!! Form::select('categoria_id',$categorias,null,['class'=>'form-control mt-2','required'])
                !!}
            </div>
            @if ($errors->has('categoria'))
                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('categoria') }}</strong>
                                    </span>
            @endif
        </div>


        <div class="md-form">
            <div class="form-group shadow-textarea">
                <textarea class="form-control z-depth-1 {{ $errors->has('descripcion') ? ' invalid' : '' }}" id="descripcion" required rows="8" placeholder="Escribir descripción del producto"
                    name="descripcion">{{ old('descripcion') }}</textarea>
            </div>
            @if ($errors->has('descripcion'))
                <span class="invalid-feedback ">
                                        <strong>{{ $errors->first('descripcion') }}</strong>
                                    </span>
            @endif
        </div>

        <div class="text-center py-4 mt-3">
            {!!Form::submit('Agregar articulo',['class'=>'btn btn-outline-primary','id' => 'guardarProducto'])!!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
 
@section('scripts')
    <script>
        $(document).ready(function(){

        var input = $('#image_uploads')[0];
        var preview = document.querySelector('.preview');

        input.style.opacity = 0;

        input.addEventListener('change', updateImageDisplay);function updateImageDisplay() {
            while(preview.firstChild) {
                preview.removeChild(preview.firstChild);
            }

            var curFiles = input.files;
            if(curFiles.length === 0) {
                var para = document.createElement('p');
                para.textContent = 'No hay archivos seleccionados';
                preview.appendChild(para);
            } 
            else {
                var list = document.createElement('ol');
                preview.appendChild(list);
                for(var i = 0; i < curFiles.length; i++) {
                    var listItem = document.createElement('li');
                    var para = document.createElement('p');
                    if(validFileType(curFiles[i])) {
                        para.textContent = 'Nombre del archivo: ' + curFiles[i].name + ', tamaño: ' + returnFileSize(curFiles[i].size) + '.';
                        var image = document.createElement('img');
                        image.src = window.URL.createObjectURL(curFiles[i]);

                        listItem.appendChild(image);
                        listItem.appendChild(para);

                    } else {  
                        para.textContent = 'El archivo: ' + curFiles[i].name + ' no tiene el formato valido. Por favor actualiza el archivo.';
                        listItem.appendChild(para);
                    }

                list.appendChild(listItem);
                }
            }
        }
        var fileTypes = [
            'image/jpeg',
            'image/pjpeg',
            'image/png'
        ]

        function validFileType(file) {
            for(var i = 0; i < fileTypes.length; i++) {
                if(file.type === fileTypes[i]) {
                    return true;
                }
            }
            return false;
        }

        function returnFileSize(number) {
            if(number < 1024) {
                return number + 'bytes';
            } 
            else if(number >= 1024 && number < 1048576) {
                return (number/1024).toFixed(1) + 'KB';
            } 
            else if(number >= 1048576) {
                return (number/1048576).toFixed(1) + 'MB';
            }
        }


    });
    </script>
@endsection