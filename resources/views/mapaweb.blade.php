@extends('templates.main') 
@section('titulo_pagina', 'mapa-web') 
@section('estilos')
<style>
    .mapa ul,
    .mapa li {
        margin: 0;
        padding: 0;
    }

    .mapa .sitemap>li>ul {
        margin-top: 1.5rem;
    }

    .mapa ul {
        list-style: none;
    }

    .mapa ul li {
        line-height: 1.5rem;
        vertical-align: top;
        position: relative;
    }

    .mapa ul li a {
        text-decoration: none;
        color: #f80;
        display: inline-block;
    }

    .mapa ul ul {
        margin-left: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .mapa ul ul li {
        position: relative;
    }

    .mapa ul ul li::before {
        content: "";
        display: inline-block;
        width: 3rem;
        height: 100%;
        border-left: 1px #ccc solid;
        position: absolute;
        top: -0.75rem;
    }

    .mapa ul ul li::before {
        content: "";
        display: inline-block;
        width: 3rem;
        height: 1.5rem;
        border-bottom: 1px #ccc solid;
        position: absolute;
        top: -0.75rem;
    }

    .mapa ul ul li a {
        margin-left: 3.75rem;
    }
</style>
@endsection
 
@section('contenido')
<div class="mapa">
    <h1>Mapa web</h1>
    <h2>Mapa web &dash; Version 1.0</h2>
    <ul class="sitemap">
        <li><a href="{{ route('index') }}">Index</a>
            <ul>
                @guest
                <li><a href="">Usuarios</a>
                    <ul>
                        <li><a href=" {{ route('login') }} ">Login</a></li>
                        <li><a href=" {{ route('register') }} ">Registro</a></li>
                    </ul>
                </li>
                @else
                <li><a href="">Personal</a>
                    <ul>
                        <li><a href=" {{ route('ver_productos_usuario',auth()->user()->id) }} ">Tus productos</a></li>
                        <li><a href=" {{ route('crear_producto') }} ">Crear producto</a></li>
                        <li><a href=" {{ route('ver_productos_usuario_favoritos', auth()->user()->id) }} ">Productos favoritos</a></li>
                        <li><a href=" {{ route('administrar_perfil', auth()->user()->id) }} ">Editar perfil</a></li>
                        <li><a href=" {{ route('perfil_publico', auth()->user()->id) }} ">Perfil publico</a></li>
                    </ul>
                </li>
                <li><a href="">Chat</a>
                    <ul>
                        <li><a href=" {{ route('mis_mensajes',auth()->user()->id) }} ">Mensajes</a></li>
                    </ul>
                </li>
                @endguest


                <li><a href="">Otros links</a>
                    <ul>
                        <li><a href=" {{ route('contact') }} ">Contacto</a></li>
                        <li><a href=" {{ route('about') }} ">Sobre nosotros</a></li>
                        <li><a href=" {{ route('mapa') }} ">Mapa web</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
    </li>
    </ul>
</div>
@endsection