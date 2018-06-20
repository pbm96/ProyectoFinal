@extends('templates.main') 
@section('titulo_pagina', 'mapa-web')  
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