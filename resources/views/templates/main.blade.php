<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo_pagina') -Fakeapop</title>
    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css" integrity="sha384-G0fIWCsCzJIMAVNQPfjH08cyYaUtMwjJwqiRKxxE/rx96Uroj1BtIQ6MLJuheaO9" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/css/mdb.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    @yield('estilos')
</head>
<style>
    body{
        font-family: Roboto;
    }
</style>
<body >
<header>
    @include('templates.assets.header')
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

<script>
    $(document).ready(function ()
    {
        var route= "{{route('notificaciones')}}";

        $.ajax({
            type: "GET",
            dataType: "json",
            url: route,
            success: function(data) {
                if(data!=='') {
                    var cont = 0;
                    var url = '{{ route("valoracion_compra",":id") }}';

                    for (i = 0; i < data.length; i++) {
                        cont++;
                        url = url.replace(':id', data[i].id);

                        $('#descripcion_notificacion').append("<a class='dropdown-item waves-effect waves-light' href= '"+url+"' ><i class='fa fa-shopping-basket mr-2'></i><span>Valora la compra de <strong>" + data[i].nombre_producto + "</strong></span></a>");

                        url = '{{ route("valoracion_compra",":id") }}';
                    }
                    $('#numero_notificaciones').text(cont)
                }else{
                    $('#descripcion_notificacion').append(" <span class='text-light ml-2 row '>No tienes notificaciones</span>")

                }
            }
        })

    })

</script>

@yield('scripts')


</body>
</html>