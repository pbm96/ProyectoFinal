@extends('templates.main')
@section('titulo_pagina', 'Registro')
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
                <h3><i class="fa fa-lock"></i> Registro</h3>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="md-form">
                    <i class="fas fa-address-card prefix"></i>
                    <label for="nombre">Nombre*</label>
                    <input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' invalid' : '' }}" name="nombre" value="{{ old('nombre') }}" required autofocus >

                    @if ($errors->has('nombre'))
                        <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="md-form">
                    <i class="fas fa-address-card prefix"></i>
                    <label for="apellido1">Primer Apellido*</label>
                    <input id="apellido1" type="text" class="form-control{{ $errors->has('apellido1') ? ' invalid' : '' }}" name="apellido1" value="{{ old('apellido1') }}" required >

                    @if ($errors->has('apellido1'))
                        <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('apellido1') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="md-form">
                    <i class="fas fa-address-card prefix"></i>
                    <label for="apellido2">Segundo Apellido</label>
                    <input id="apellido2" type="text" class="form-control{{ $errors->has('apellido2') ? ' invalid' : '' }}" name="apellido2" value="{{ old('apellido2') }}"  >

                    @if ($errors->has('apellido2'))
                        <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('apellido2') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="md-form">
                    <i class="fas fa-user prefix"></i>
                    <label for="nombre_usuario">Nombre Usuario*</label>
                    <input id="nombre_usuario" type="text" class="form-control{{ $errors->has('nombre_usuario') ? ' invalid' : '' }}" name="nombre_usuario" value="{{ old('nombre_usuario') }}" required >

                    @if ($errors->has('nombre_usuario'))
                        <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('nombre_usuario') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="md-form">
                    <i class="fa fa-envelope prefix"></i>
                    <label for="email">Email*</label>
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="md-form">
                    <i class="fas fa-lock prefix"></i>
                    <label for="password">Contraseña*</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="md-form">
                    <i class="fas fa-lock prefix"></i>
                    <label for="password-confirm">Confirmar Contraseña*</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
                <div class="md-form">
                    <i class="fas fa-map-marker prefix"></i>
                    <label for="direccion">Direccion*</label>
                        <input id="direccion" type="text" class="form-control{{ $errors->has('Direccion*') ? ' invalid' : '' }}" value="{{ old('direccion') }} " name="direccion" autocomplete="off" required>

                        @if ($errors->has('direccion'))
                            <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('direccion') }}</strong>
                                    </span>
                        @endif
                </div>
                <input type="hidden" id="city2" name="city2" />
                <input type="hidden" id="cityLat" name="cityLat" value="{{ old('cityLat') }} " />
                <input type="hidden" id="cityLng" name="cityLng" value="{{ old('cityLng') }} " />
                <div class="md-form">
                    <i class="fas fa-phone prefix"></i>
                    <label for="telefono">Teléfono</label>
                    <input id="telefono" type="text" class="form-control{{ $errors->has('telefono') ? ' invalid' : '' }}" name="telefono" value="{{ old('telefono') }}" >

                    @if ($errors->has('telefono'))
                        <span class="invalid-feedback ml-5">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="text-center">
                    <button class="btn btn-primary">Registro</button>
                </div>
            </form>
        </div>

        <!--Footer-->
        <div class="modal-footer">
            <div class="options">
                <p>Ya tienes una cuenta?<a href="{{route('login')}}"> Entra</a></p>
            </div>
        </div>

    </div>
</div>

@endsection
@section('scripts')
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCG7G5aANtgkHs8FRZ6kyEsUOCwd4DG5QM&libraries=places" ></script>
    <script type="application/javascript">
            var input=document.getElementById('direccion');
            autocomplete = new google.maps.places.Autocomplete(input);

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                document.getElementById('city2').value = place.name;
                document.getElementById('cityLat').value = place.geometry.location.lat();
                document.getElementById('cityLng').value = place.geometry.location.lng();});



    </script>
    @endsection



