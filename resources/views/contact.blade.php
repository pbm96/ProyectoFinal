@extends('templates.main')
@section('titulo_pagina', 'contacto')
@section('contenido')
    <h1 class="text-center">Contacto</h1>
    <fieldset class="row justify-content-center">
        <legend>Contacta con nostros</legend>
        <form class="col-lg-6 mx-auto">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" placeholder="Nombre">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="tema">Elija un tema</label>
                <select name="tema" id="tema" class="custom-select">
                    <option value="x" default>--Seleccione una opcion--</option>
                    <option value="x">Opcion 1</option>
                    <option value="x">Opcion 2</option>
                    <option value="x">Opcion 3</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comentario">Deja un comentario</label>
                <textarea name="comentario" id="comentario" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group text-center mt-4">
                <input type="submit" value="Enviar" class="btn btn-primary">
            </div>
        </form>
    </fieldset>
@endsection