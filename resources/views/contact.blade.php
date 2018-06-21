@extends('templates.main')
@section('titulo_pagina', 'contacto')
@section('contenido')
    {!! Form::Open(['route' => 'mensaje_contacto','method'=>'POST']) !!}
    <h1 class="text-center">Contacto</h1>
    <fieldset class="row justify-content-center col-sm-6 offset-3">
        <legend>Contacta con nostros</legend>
        <form class="col-lg-6 mx-auto">
            <div class="md-form">
                <input id="form4" type="text"
                       class="form-control"
                       name="nombre" required>
                <label for="form4">Nombre</label>
            </div>
            <div class="md-form">
                <input id="form4" type="email"
                       class="form-control"
                       name="Email" required>
                <label for="form4">Email</label>
            </div>
            <div class="form-group">
                <label for="tema">Elija un tema</label>
                <select name="tema" id="tema" class="custom-select">
                    <option value="x" default >--Seleccione una opcion--</option>
                    <option value="x">Opcion 1</option>
                    <option value="x">Opcion 2</option>
                    <option value="x">Opcion 3</option>
                </select>
            </div>
            <div class="md-form">
                <div class="form-group shadow-textarea">

                    <textarea class="form-control z-depth-1" id="exampleFormControlTextarea6" rows="6"
                              placeholder="Escribir comentario..." name="comentario_compra"></textarea>
            </div>
            <div class="form-group text-center mt-4">
                <input type="submit" value="Enviar" class="btn btn-primary">
            </div>
        </form>
    </fieldset>
    {!! Form::close() !!}
@endsection