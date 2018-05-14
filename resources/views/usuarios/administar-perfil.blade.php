@extends('templates.main')
@section('titulo_pagina', 'Editar-datos '.$usuario->nombre_usuario.'-Fakeapop')
@section('contenido')


<div class="container-fluid mt-5">

    <!--Section: Team v.1-->
    <section class="section team-section">

        <!--Grid row-->
        <div class="row text-center">

            <!-- Grid column -->
            <div class="col-md-4 mb-4">

                <!--Card-->
                <div class="card profile-card">

                    <!--Avatar-->
                    <div class=" mt-3 mb-4">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg" class="rounded-circle" alt="First sample avatar image">
                    </div>

                    <div class="card-body pt-0 mt-0">
                        <!--Name-->
                        <h3 class="mb-3 font-weight-bold"><strong>{{$usuario->nombre_usuario}}</strong></h3>
                        <div class="row ">
                            <h6 class="font-weight-bold cyan-text mb-4 ml-3 mr-5">Valoracion</h6>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>

                        <div class="row ">
                            <h6 class="font-weight-bold cyan-text mb-4 ml-3 mr-5">Valoracion</h6>

                        </div>
                        <div class="row ">
                            <h6 class="font-weight-bold cyan-text mb-4 ml-3 mr-5">Valoracion</h6>

                        </div>
                        <div class="row justify-content-end ">

                            {!! Form::Open(['route'=>['borrar_perfil',$usuario->id],'method'=>'DELETE','files'=>true]) !!}

                            {!!Form::submit('Borrar Perfil',['class'=>'btn btn-danger confirm ','data-confirm' => 'Seguro que quieres borrar el Usuario? NO HABRA VUELTA ATRÁS'])!!}

                            {!! Form::close() !!}
                        </div>

                    </div>

                </div>
                <!--Card-->

            </div>
            <div class="col-md-8 mb-4">
            {!! Form::Open(['route'=>['guardar_perfil',$usuario->id],'method'=>'PUT','files'=>true]) !!}
                <!--Card-->
                <div class="card card-cascade cascading-admin-card user-card">

                    <!--Card Data-->
                    <div class="admin-up d-flex justify-content-start">
                        <i class="fa fa-users info-color py-4 col-sm-1 mr-4 ml-3 "></i>
                        <div class="data mt-3 ml-5">
                            <h5 class="font-weight-bold dark-grey-text">Editar Perfil - <span class="text-muted">Completa tu perfil</span></h5>
                        </div>
                    </div>
                    <!--/.Card Data-->

                    <!--Card content-->
                    <div class="card-body">

                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-lg-4">

                                <div class="md-form form-sm mb-0">
                                    {!! Form::label('nombre','Nombre') !!}
                                    {!! Form::Text('nombre',$usuario->nombre,['class'=>'form-control form-control-sm','required','placeholder'=>'Introducir Nombre']) !!}
                                </div>

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-lg-4">

                                <div class="md-form form-sm mb-0">
                                    {!! Form::label('apellido1','Apellido1') !!}
                                    {!! Form::Text('apellido1',$usuario->apellido1,['class'=>'form-control form-control-sm','required']) !!}
                                </div>

                            </div>
                            <!-- Grid column -->

                            <!-- Grid column -->
                            <div class="col-lg-4">

                                <div class="md-form form-sm mb-0">
                                    <div class="form-group">
                                        {!! Form::label('apellido2','Apellido2') !!}
                                        {!! Form::Text('apellido2',$usuario->apellido2,['class'=>'form-control form-control-sm','required','placeholder'=>'Introducir Apellido2']) !!}
                                    </div>
                                </div>

                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->

                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-md-6">

                                <div class="md-form form-sm mb-0">
                                    <div class="form-group">
                                        {!! Form::label('nombre_usuario','Usuario') !!}
                                        {!! Form::Text('nombre_usuario',$usuario->nombre_usuario,['class'=>'form-control form-control-sm ','required','placeholder'=>'Nombre Usuario']) !!}
                                    </div>
                                </div>

                            </div>
                            <!-- Grid column -->




                        </div>
                        <!-- Grid row -->

                        <!-- Grid row -->
                        <div class="row">

                            <!-- Grid column -->
                            <div class="col-md-12">

                                <div class="md-form form-sm mb-0 ">
                                    {!! Form::label('direccion','Direccion') !!}
                                    {!! Form::Text('direccion',isset($direccion->nombre)?$direccion->nombre:null,['id'=>'direccion','class'=>'form-control form-control-sm ','required','placeholder'=>'Introduce Ubicacion']) !!}
                                </div>

                            </div>
                            <!-- Grid column -->

                        </div>
                        <!-- Grid row -->


                        <!-- Grid row -->

                        <!-- Grid row -->

                        <!-- Grid row -->

                    </div>
                    <input type="hidden" id="cityLat" name="cityLat" value="{{isset($direccion->latitud)?$direccion->latitud:null}} " />
                    <input type="hidden" id="cityLng" name="cityLng" value="{{isset($direccion->longitud)?$direccion->longitud:null}}" />
                    <!--/.Card content-->
                    <div class="row justify-content-end mr-5 mb-3">
                    {!!Form::submit('Modificar Perfil',['class'=>'btn btn-primary '])!!}
                    {!! Form::close() !!}
                    </div>
                </div>
                <!--/.Card-->




            </div>

            <!-- Grid column -->

            <!-- Grid column -->

            <!-- Grid column -->

        </div>
        <!--Grid row-->

    </section>
    <!--Section: Team v.1-->

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
