<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo_pagina') -Fakeapop</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9"
        crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/css/mdb.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.2/css/bootstrap-slider.min.css">

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> @yield('estilos')

</head>
<style>
    body {
        font-family: Roboto;
    }

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 2;

        left: 0;
        background-color: white;
        overflow-x: hidden;
        /*transition: 0.5s;*/
        padding-top: 60px;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    #notificaciones::after {
        display: none
    }

    #descripcion_notificacion {
        left: -120%;
       width: 16rem;

    }
</style>

<body>
    <header>
    @include('templates.assets.header')
    @include('templates.assets.sidenav')

        <div class="container mt-4 text-center">
            <div class="row justify-content-sm-center">
    @include('flash::message')
            </div>
        </div>


    </header>

    <main class="container mt-4">

        @yield('contenido')
    </main>
    @include('templates.assets.footer')

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/js/mdb.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.2/bootstrap-slider.min.js"></script>

    <script>
        @auth()
    $(document).ready(function ()
    {

        var route= "{{route('notificaciones')}}";

        $.ajax({
            type: "GET",
            dataType: "json",
            url: route,
            success: function(data) {

                if(data.mensajes !=='' || data.notificaciones !=='' ) {

                    var cont = 0;
                    var url = '{{ route("valoracion_compra",":id") }}';
                    var url_mensaje = '{{route("mis_mensajes",auth()->user()->id)}}';
                    $('#descripcion_notificacion').append("<h6 class='text-center mt-2'><strong>Notificaciones</strong></h6>")
                    if(data.mensajes !== ''){
                        for (i = 0; i < data.mensajes.length; i++) {
                            cont++;
                            /*url = url.replace(':id', data[i].id);*/

                            $('#descripcion_notificacion').append("<a class='dropdown-item waves-effect waves-light ' href= '" + url_mensaje + "' ><i class='fas fa-comment comentario mr-2 text-primary   text-center  '></i><span class='mt-0'><strong>"+data.mensajes[i].user+"</strong> te ha enviado un mensaje:<p class='text-truncate ml-4 text-muted mb-0'>" + data.mensajes[i].cuerpo_mensaje + "</p></span></a><hr class='text-muted mb-0 mt-0'>");

                            {{--}}url = '{{ route("valoracion_compra",":id") }}';{{--}}
                        }
                    }if (data.notificaciones!== '') {
                        for (i = 0; i < data.notificaciones.length; i++) {
                            cont++;
                            url = url.replace(':id', data.notificaciones[i].id);

                            $('#descripcion_notificacion').append("<a class='dropdown-item waves-effect waves-light ' href= '" + url + "' ><i class='fa fa-star mr-2 text-primary  text-center  mb-0'></i><span>Valora la compra de <strong>" + data.notificaciones[i].nombre_producto + "</strong></span></a><hr class='text-muted mb-0 mt-0'>");

                            url = '{{ route("valoracion_compra",":id") }}';
                        }
                    }

                    $('#numero_notificaciones').text(cont)
                }else{
                    $('#descripcion_notificacion').append(" <span class='text-light  row justify-content-center '>No tienes notificaciones</span>")

                }
            }
        })
    })
@endauth
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    </script>

    @yield('scripts')


</body>

</html>