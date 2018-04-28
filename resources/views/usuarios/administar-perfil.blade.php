@extends('templates.main')
@section('titulo_pagina', 'Editar-datos '.$usuario->nombre_usuario)
@section('contenido')

{!! Form::Open(['route'=>['guardar_perfil',$usuario->id],'method'=>'PUT','files'=>true]) !!}

<div class="form-group">
    {!! Form::label('nombre','Nombre') !!}
    {!! Form::Text('nombre',$usuario->nombre,['class'=>'','required','placeholder'=>'Introducir Nombre']) !!}
</div>
<div class="form-group">
    {!! Form::label('apellido1','Apellido1') !!}
    {!! Form::Text('apellido1',$usuario->apellido1,['class'=>'','required','placeholder'=>'Introducir Apellido1']) !!}
</div>
<div class="form-group">
    {!! Form::label('apellido2','Apellido2') !!}
    {!! Form::Text('apellido2',$usuario->apellido2,['class'=>'','required','placeholder'=>'Introducir Apellido2']) !!}
</div>
<div class="form-group">
    {!! Form::label('nombre_usuario','Usuario') !!}
    {!! Form::Text('nombre_usuario',$usuario->nombre_usuario,['class'=>' ','required','placeholder'=>'Nombre Usuario']) !!}
</div>
<div class="form-group">
    {!! Form::label('direccion','Direccion') !!}
    {!! Form::Text('direccion',isset($direccion->nombre)?$direccion->nombre:null,['id'=>'direccion','class'=>' ','required','placeholder'=>'Introduce Ubicacion']) !!}
</div>

<input type="hidden" id="cityLat" name="cityLat" value="{{isset($direccion->latitud)?$direccion->latitud:null}} " />
<input type="hidden" id="cityLng" name="cityLng" value="{{isset($direccion->longitud)?$direccion->latitud:null}} " />



<div class="form-group">
    {!!Form::submit('Modificar Perfil',['class'=>'btn btn-primary'])!!}
</div>
{!! Form::close() !!}

{!! Form::Open(['route'=>['borrar_perfil',$usuario->id],'method'=>'DELETE','files'=>true]) !!}
<div class="form-group">
    {!!Form::submit('Borrar Perfil',['class'=>'btn btn-danger confirm','data-confirm' => 'Seguro que quieres borrar el Usuario? NO HABRA VUELTA ATRÁS'])!!}

</div>
{!! Form::close() !!}
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
