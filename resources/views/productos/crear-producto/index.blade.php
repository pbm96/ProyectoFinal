@extends('templates.main') 
@section('titulo_pagina', 'crear-producto') 
@section('estilos')
<style>
    .imagenes ol {
        padding-left: 0;
    }

    .imagenes li,
    div.preview>p {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        list-style-type: none;
    }

    .imagenes img {
        height: 64px;
        order: 1;
    }

    .imagenes p {
        line-height: 32px;
        padding-left: 10px;
    }
</style>
@endsection
 
@section('contenido') {!! Form::Open(['route' => 'guardar_producto','method'=>'POST', 'enctype'=> 'multipart/data', 'files' => true ,'class'=>'row justify-content-center'])
!!}
<div class="card col-sm-8 ">
    <div class="card-body">
        <p class="h4 text-center py-4">Crear Producto</p>
        <div class="row justify-content-around">
            <div class="col-sm-12">
                <div class="card imagenes container p-4">
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
        <div class="row justify-content-around text-center">
            <div class="md-form col-sm-8">
                {!! Form::Text('nombre',null,['class'=>'form-control','required','name' => 'nombre']) !!} {!! Form::label('nombre','Nombre
                Producto') !!}
            </div>
            <div class="md-form col-sm-3">
                {!! Form::number('precio',null,['class'=>'form-control','required','min' => 0,'name' => 'precio']) !!} {!! Form::label('precio','Precio')
                !!}
            </div>
        </div>
        <div class="form-group form-row mt-4">
            <div class="col-sm-4 ">
                {!! Form::select('categoria_id',$categorias,null,['class'=>'form-control h-75 mt-2','required','name' => 'categoria_id',
                'id' => 'categoria', 'onchange' => 'mostrar()']) !!}
            </div>
        </div>

        <div class="md-form">
            <div class="form-group shadow-textarea">
                <textarea class="form-control z-depth-1" id="descripcion" required rows="8" placeholder="Escribir descripción del producto"
                    name="descripcion"></textarea>
            </div>
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
        console.log(input);

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