@extends('templates.main')
@section('titulo_pagina', 'Editar-datos '.$usuario->nombre_usuario.'-Fakeapop')
@section('contenido')


<div class="container-fluid mt-5">
    <div class="row justify-content-end mb-2 mr-3">
        <a href="{{route('perfil_publico',$usuario->id)}}" class='btn btn-primary' >Perfil Publico</a>
    </div>
    <section class="section team-section">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card profile-card">
                    <div class=" mt-3 mb-4 ">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg" class="rounded-circle" alt="First sample avatar image">
                    </div>
                    <div class="card-body pt-0 mt-0">
                        <!--Name-->
                        <h3 class="mb-3 font-weight-bold"><strong>{{$usuario->nombre_usuario}}</strong></h3>
                        <div class="row ">
                            <h6 class="font-weight-bold cyan-text mb-4 ml-3 mr-5">Valoración</h6>
                            @for($i=0;$i<$usuario->valoracion;$i++)
                                <i class="fas fa-star yellow-text"></i>
                            @endfor
                            @for($i=0;$i<5-$usuario->valoracion;$i++)
                                <i class="far fa-star "></i>
                            @endfor
                        </div>

                        <div class="row ">
                            <h6 class="font-weight-bold cyan-text mb-4 ml-3 mr-5 ">Productos Subidos</h6>
                            <h6 class="font-weight-bold ">{{count($productos)}}</h6>

                        </div>
                        <div class="row ">
                            <h6 class="font-weight-bold cyan-text mb-4 ml-3 mr-5">Productos Vendidos</h6>
                            <h6 class="font-weight-bold ">{{count($productos_vendidos)}}</h6>

                        </div>
                        <div class="row justify-content-end ">

                            {!! Form::Open(['route'=>['borrar_perfil',$usuario->id],'method'=>'DELETE','files'=>true]) !!}

                            {!!Form::submit('Borrar Perfil',['class'=>'btn btn-outline-danger   waves-effect confirm ','data-confirm' => 'Seguro que quieres borrar el Usuario? NO HABRA VUELTA ATRÁS'])!!}

                            {!! Form::close() !!}
                        </div>

                    </div>

                </div>
                <!--Card-->

            </div>
            <div class="col-md-8 mb-4">
            {!! Form::Open(['route'=>['guardar_perfil',$usuario->id],'method'=>'PUT','files'=>true]) !!}
                <div class="card card-cascade cascading-admin-card user-card">
                    <div class="admin-up d-flex justify-content-start">
                        <i class="fa fa-users info-color py-4 col-sm-1 mr-4 ml-3 "></i>
                        <div class="data mt-3 ml-5">
                            <h5 class="font-weight-bold dark-grey-text">Editar Perfil - <span class="text-muted">Completa tu perfil</span></h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-sm-4 ">
                                <div class="md-form form-sm mb-2">
                                        {!! Form::label('nombre_usuario','Usuario') !!}
                                        {!! Form::Text('nombre_usuario',$usuario->nombre_usuario,['class'=>'form-control form-control-sm ','required','placeholder'=>'Nombre Usuario']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="md-form form-sm mb-2">
                                    {!! Form::label('nombre_usuario','Email') !!}
                                    {!! Form::Email('email',$usuario->email,['class'=>'form-control form-control-sm ','required','placeholder'=>'Email']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-4 ">
                             <h5 class="text-muted">Cambiar Contraseña</h5>
                            </div>
                        </div>

                        <div class="row mb-1">
                                <div class="col-sm-4 ">
                                    <div class="md-form form-sm mb-2">
                                        {!! Form::label('nombre_usuario','Contraseña Actual') !!}
                                        {!! Form::Text('',null,['class'=>'form-control form-control-sm' ]) !!}
                                    </div>
                                </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-sm-4 ">
                                <div class="md-form form-sm mb-2">
                                    {!! Form::label('nombre_usuario','Contraseña Nueva') !!}
                                    {!! Form::Text('',null,['class'=>'form-control form-control-sm ']) !!}
                                </div>
                            </div>
                            <div class="col-sm-4 ">
                                <div class="md-form form-sm mb-2">
                                    {!! Form::label('nombre_usuario','Confirmar nueva contraseña') !!}
                                    {!! Form::Text('',null,['class'=>'form-control form-control-sm ']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <div class="md-form form-sm mb-2">
                                    {!! Form::label('nombre','Nombre') !!}
                                    {!! Form::Text('nombre',$usuario->nombre,['class'=>'form-control form-control-sm','required','placeholder'=>'Introducir Nombre']) !!}
                                </div>
                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-sm-4">
                                <div class="md-form form-sm mb-2">
                                    {!! Form::label('apellido1','Apellido1') !!}
                                    {!! Form::Text('apellido1',$usuario->apellido1,['class'=>'form-control form-control-sm','required']) !!}
                                </div>

                            </div>
                            <div class="col-sm-4">

                                <div class="md-form form-sm mb-2">
                                    <div class="form-group">
                                        {!! Form::label('apellido2','Apellido2') !!}
                                        {!! Form::Text('apellido2',$usuario->apellido2,['class'=>'form-control form-control-sm','required','placeholder'=>'Introducir Apellido2']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="md-form form-sm mb-2 ">
                                    {!! Form::label('direccion','Direccion') !!}
                                    {!! Form::Text('direccion',isset($direccion->nombre)?$direccion->nombre:null,['id'=>'direccion','class'=>'form-control form-control-sm ','required','placeholder'=>'Introduce Ubicacion']) !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    <input type="hidden" id="cityLat" name="cityLat" value="{{isset($direccion->latitud)?$direccion->latitud:null}} " />
                    <input type="hidden" id="cityLng" name="cityLng" value="{{isset($direccion->longitud)?$direccion->longitud:null}}" />
                    <!--/.Card content-->
                    <div class="row justify-content-end mr-5 mb-3">
                        {!!Form::submit('Modificar Perfil',['class'=>'btn btn-primary '])!!}
                         {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>







@endsection

@section('scripts')

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCG7G5aANtgkHs8FRZ6kyEsUOCwd4DG5QM&libraries=places" ></script>
<script >
    var input=document.getElementById('direccion');
    autocomplete = new google.maps.places.Autocomplete(input);

    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        var place = autocomplete.getPlace();
        document.getElementById('cityLat').value = place.geometry.location.lat();
        document.getElementById('cityLng').value = place.geometry.location.lng();});



    $('.confirm').on('click', function (e) {
        return !!confirm($(this).data('confirm'));
    });
</script>
    @endsection
