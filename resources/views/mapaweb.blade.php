@extends('templates.main')
@section('contenido')
    <h1 class="text-center mb-5">Mapa web</h1>
    <div class="row text-center mb-5">
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="list-group">
                <h3 class="">Productos</h3>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Index</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="list-group">
                <h3 class="">Personal</h3>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Tus productos</a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Administrar perfil</a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Mensajería</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="list-group">
                <h3 class="">Gestión de usuarios</h3>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Registro</a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Log in</a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-2">
            <div class="list-group">
                <h3 class="">Informacion</h3>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Contacto</a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Sobre nosotros</a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Aviso legal</a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">Cookies</a>
            </div>
        </div>
    </div>
@endsection