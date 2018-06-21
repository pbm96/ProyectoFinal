@extends('templates.main')
@section('titulo_pagina', 'escribir-mensaje')
@section('estilos')
@endsection
@section('contenido')

    <div class="container-fluid">
        <h1 class="h1 text-center"> Mis conversaciones</h1>
        @if(count($conversaciones)>0)
            <section class="section">
                <div class="row">
                    <div class="col-md-4  col-sm-12 usuarios">
                        <div class="list-group" role="tablist">
                            @foreach($conversaciones as $conversacion)
                                @if(!isset($conversacion->borrada))
                                    <a data-toggle="tab" role="tab"
                                       href="#conversacion{{$conversacion->id}}"
                                       class="list-group-item list-group-item-action media @if(isset($conversacion->activo)) active @endif"
                                       id="tab_{{$conversacion->id}}">
                                        <img class="mr-3 avatar float-left " width="60" height="60"
                                             style="border-radius: 50%"
                                             @if($conversacion->hablando_con_user_datos->imagen !=null)
                                             src="{{asset('imagenes/perfil/'.$conversacion->hablando_con_user_datos->imagen)}}"
                                             @else
                                             src="{{asset('imagenes/perfil/user-default.png')}}"
                                                @endif
                                        >
                                        <div class="d-flex justify-content-between mb-1 ">
                                            <p class="mb-1">
                                                <strong>{{$conversacion->hablando_con_user_datos->nombre}} {{$conversacion->hablando_con_user_datos->apellido1}}</strong>
                                            </p>
                                            <small>{{$conversacion->ultimo_mensaje_dia}} {{$conversacion->ultimo_mensaje_mes}}</small>
                                        </div>
                                        @if(count($conversacion->mensajes)>0)
                                            <p class="text-truncate" id="ultimo_mensaje_user_{{$conversacion->id}}">
                                                <strong>
                                                    @if($conversacion->mensajes->sortBy('created_at')->last()->enviado_por != $user->id)
                                                        {{$conversacion->hablando_con_user_datos->nombre}}:
                                                    @else
                                                        Tú:
                                                    @endif</strong> {{htmlspecialchars_decode($conversacion->mensajes->sortBy('created_at')->last()->cuerpo_mensaje)}}
                                            </p>
                                        @else
                                            <p class="text-truncate" id="ultimo_mensaje_user_{{$conversacion->id}}">
                                                <strong></strong></p>
                                        @endif

                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-8 mt-lg-0 col-sm-12 mt-5 tab-content">
                        @foreach($conversaciones as $conversacion)
                            @if(!isset($conversacion->borrada))
                                <div class="fade tab-pane  @if(isset($conversacion->activo))in show  active @endif"
                                     role="tabpanel" id="conversacion{{$conversacion->id}}">
                                    <div class="row justify-content-end mr-1 mb-0">
                                        <a id="borrar_conversacion_{{$conversacion->id}}" data-toggle="popover" data-trigger="hover"
                                           data-placement="right" data-content="Borrar conversacion"
                                           href="{{route('eliminar_conversacion',$conversacion->id)}}"
                                           onclick="borrar_conversacion({{$conversacion->id}})" class="text-danger "  ><i
                                                    class="fas fa-2x fa-window-close "   ></i></a>
                                    </div>
                                    <div class="border border-dark border-bottom-0 p-4 mt-0 chat"
                                         id="chat_{{$conversacion->id}}">
                                        @if(count($conversacion->mensajes)>0)
                                            @foreach($conversacion->mensajes as $mensaje)
                                                @if($mensaje->enviado_por == auth()->user()->id)
                                                    <div class="d-flex justify-content-end">
                                                        <p class="primary-color rounded p-3 text-white w-75 mb-0">{{htmlspecialchars_decode($mensaje->cuerpo_mensaje)}}</p>
                                                    </div>
                                                    <div class="text-right mr-4">
                                                        <p>
                                                            <small>{{$mensaje->fecha_mensaje}}</small>
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-start media">

                                                        <img class="mr-3 avatar float-left " width="65" height="65"
                                                             style="border-radius: 50%"
                                                             @if($conversacion->hablando_con_user_datos->imagen !=null)
                                                             src="{{asset('imagenes/perfil/'.$conversacion->hablando_con_user_datos->imagen)}}"
                                                             @else
                                                             src="{{asset('imagenes/perfil/user-default.png')}}"
                                                                @endif
                                                        >
                                                        <p class="grey lighten-3 rounded p-3 w-75 mb-0">{{htmlspecialchars_decode($mensaje->cuerpo_mensaje)}} </p>

                                                    </div>
                                                    <div class="fecha_recibidos text-center">
                                                        <p>
                                                            <small>{{$mensaje->fecha_mensaje}}</small>
                                                        </p>
                                                    </div>

                                                @endif

                                            @endforeach


                                        @endif

                                    </div>
                                    <div class="border border-dark border-top-0 p-4">
                                        <div class="row">
                                            <div class="md-form col-sm-9 ">
                                                <div class="form-group shadow-textarea mensaje">
                                                    <i class=" fas fa-comments prefix grey-text"></i>
                                                    <textarea class="form-control z-depth-1"
                                                              id="mensaje_{{$conversacion->id}}" rows="1"
                                                              placeholder="Escribir mensaje..." name="cuerpo_mensaje"
                                                              oninput="cuerpo_mensaje({{$conversacion->id}})"></textarea>
                                                </div>
                                            </div>
                                            <div class=" col-xs-3  offset-sm-0 col-md-3 mt-3  ">

                                                <button class="btn btn-outline-primary"
                                                        id="enviar_{{$conversacion->id}}" disabled
                                                        onclick="enviar_mensaje({{$conversacion->id}}, {{$conversacion->hablando_con}})">
                                                    Enviar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>

        @endif
    </div>


@endsection


@section('scripts')
    <script>
        function cuerpo_mensaje(id) {
            console.log($('#mensaje_' + id).val() !== '');
            if ($('#mensaje_' + id).val() !== '') {
                $('#enviar_' + id).prop("disabled", false);
                $('#mensaje_' + id).prop("rows", "3")
            } else {
                $('#enviar_' + id).prop("disabled", true);
                $('#mensaje_' + id).prop("rows", "1")
            }


        }

        function enviar_mensaje(id, id_2) {
            var route = "{{route('enviar_mensaje',[':id',':conversacion_id'])}}";

            route = route.replace(':id', id_2);
            route = route.replace(':conversacion_id', id);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                data: {cuerpo_mensaje: $('#mensaje_' + id).val()},
                url: route,
                success: function (data) {

                    if (data.respuesta === true && data.mensaje !== '') {
                        $('#mensaje_' + id).val('');
                        $('#mensaje_' + id).prop("rows", "1");
                        $('#enviar_' + id).prop("disabled", true);
                        $('#ultimo_mensaje_user_' + data.conversacion).text('Tú: ' + data.mensaje);

                        $('#chat_' + id).append(" <div class='d-flex justify-content-end'><p class='primary-color rounded p-3 text-white w-75 mb-0 '>" + data.mensaje + "</p></div><div class='text-right mr-4'><p><small>" + data.dia+ " " + data.mes + "," + data.hora + ":" + data.minutos + "</small></p></div>");

                        $('#chat_' + id).scrollTop($('#chat_' + id)[0].scrollHeight);
                    } else {
                        $('.mensaje').append("<p class='text-danger text-center error-mensaje'>Ha ocurrido un error al enviar el mensaje</p>")
                        setTimeout(function () {
                            $(".error-mensaje").remove();
                        }, 3000);
                    }

                }
            })

        }

        @if(count($conversaciones)>0)
        $(document).ready(function () {
            if ( $('.chat'))
            $('.chat').scrollTop($('.chat')[0].scrollHeight);

        });
        @endif

        setInterval(function () {
            recibir_mensaje();
        }, 5000);

        function recibir_mensaje() {


            var route = "{{route('recibir_mensaje')}}";

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "json",
                url: route,
                success: function (data) {
                    console.log()
                    for (i = 0; i < data.mensajes.length; i++) {

                        $('#ultimo_mensaje_user_' + data.mensajes[i].conversacion_id).text(data.mensajes[i].user_enviado.nombre + ': ' + data.mensajes[i].cuerpo_mensaje);

                        $('#chat_' + data.mensajes[i].conversacion_id).append(" <div class='d-flex justify-content-start media'> <img class='mr-3 avatar float-left' style='border-radius: 50%' src='{{asset('imagenes/perfil')}}/" + data.mensajes[i].user_enviado.imagen + "' width='65' height='65'><p class='grey lighten-3 rounded p-3 w-75 mb-0' >" + data.mensajes[i].cuerpo_mensaje + "</p></div><div class='fecha_recibidos text-center'><p><small>" + data.mensajes[i].dia + " " + data.mensajes[i].mes + "," + data.mensajes[i].hora + ":" + data.mensajes[i].minutos + "</small></p></div>");
                        $('#chat_' + data.mensajes[i].conversacion_id).scrollTop($('#chat_' + data.mensajes[i].conversacion_id)[0].scrollHeight);
                    }


                }
            })
        }

        $(window).on("unload", function (e) {
            var route = "{{route('eliminar_conversaciones_vacias')}}";

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: route,
                async: false,
            })
        });


    </script>

@endsection