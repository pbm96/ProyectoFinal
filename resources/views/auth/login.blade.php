@extends('templates.main')
@section('titulo_pagina', 'Login')
@section('estilos')
    <style>
        .card .form-header {
            color: #fff;
            text-align: center;
            margin-top: -40px;
            margin-bottom: 3rem;
            padding: 1rem;
            border-radius: 2px;
        }
        .blue-gradient {
            background: -webkit-linear-gradient(50deg,#45cafc,#303f9f)!important;
            background: -o-linear-gradient(50deg,#45cafc,#303f9f)!important;
            background: linear-gradient(40deg,#45cafc,#303f9f)!important;
        }
        .login{
            margin-top: 6em;
        }
    </style>
@endsection
@section('contenido')


<div class="row justify-content-center login">
    <div class="card col-sm-6 ">
        <div class="card-block ">

            <!--Header-->
            <div class="form-header  blue-gradient ">
                <h3><i class="fa fa-lock"></i> Login</h3>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
            <div class="md-form">
                <i class="fa fa-envelope prefix"></i>

                <input id="form2" type="email"
                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                       name="email" value="{{ old('email') }}" required autofocus>

                <label for="form2">Your email</label>
                @if ($errors->has('email'))
                    <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="md-form">
                <i class="fa fa-lock prefix"></i>

                <input id="form4" type="password"
                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                       name="password" required>
                <label for="form4">password</label>

                @if ($errors->has('password'))
                    <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>

            <div class="text-center">
                <button class="btn btn-primary">Login</button>
            </div>
            </form>
        </div>

        <!--Footer-->
        <div class="modal-footer">
            <div class="options">
                <p>No estás Registrado?<a href="{{route('register')}}"> Registrate</a></p>
            </div>
        </div>

    </div>
</div>
    <!--/Form with header-->
@endsection
