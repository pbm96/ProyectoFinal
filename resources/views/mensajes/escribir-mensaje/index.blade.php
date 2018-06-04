@extends('templates.main')
@section('titulo_pagina', 'escribir-mensaje')
@section('estilos')

@endsection
@section('contenido')

    <div class="container-fluid">
        <section class="section">


            <div class="row">


                <div class="col-sm-4">

                    <div class="list-group">


                        <a href="#" class="list-group-item list-group-item-action media active">

                            <img class="mr-3 avatar float-left " width="60" height="60" style="border-radius: 50%"
                                 src="https://mdbootstrap.com/img/Photos/Avatars/adach.jpg">

                            <div class="d-flex justify-content-between mb-1 ">
                                <hp class="mb-1"><strong>Dawid Adach</strong></hp>
                                <small>13 July</small>
                            </div>


                            <p class="text-truncate"><strong>You: </strong> Donec id elit non mi porta gravida at eget
                                metus. Maecenas
                                sed diam eget risus varius blandit.</p>
                        </a>


                        <a href="#" class="list-group-item list-group-item-action media">

                            <img class="mr-3 avatar float-left" width="60" height="60" style="border-radius: 50%"
                                 src="https://secure.gravatar.com/avatar/8c051fd54e4c811e02bbc78d50549280?s=150&amp;d=mm&amp;r=g">


                            <div class="d-flex justify-content-between mb-1 ">
                                <hp class="mb-1"><strong>Michal Szymanski</strong></hp>
                                <small>14 July</small>
                            </div>


                            <p class="text-truncate"><span class="badge red">MDB Team</span> <strong>Michal: </strong>
                                Donec id elit non
                                mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                        </a>


                    </div>


                </div>

                <div class="col-lg-8 mt-lg-0 mt-5" >


                    <div class="border border-dark border-bottom-0 p-4" id="chat">

                        <div class="text-center">
                            <small>16 July, 23:54</small>
                        </div>
                        <div class="d-flex justify-content-end">
                            <p class="primary-color rounded p-3 text-white w-75 ">Lorem ipsum </p>
                        </div>


                        <div class="text-center">
                            <small>16 July, 23:55</small>
                        </div>
                        <div class="d-flex justify-content-start media">

                            <img class="mr-3 avatar float-left" width="70" height="70" style="border-radius: 50%"
                                 src="https://mdbootstrap.com/img/Photos/Avatars/adach.jpg">

                            <p class="grey lighten-3 rounded p-3 w-75">Lorem ipsum </p>
                        </div>

                    </div>
                    <div class="border border-dark border-top-0 p-4">
                        <div class="row">
                            <div class="md-form col-sm-9 ">
                                <div class="form-group shadow-textarea">
                                    <i class=" fas fa-comments prefix grey-text"></i>
                                    <textarea class="form-control z-depth-1" id="mensaje" rows="1"
                                              placeholder="Escribir mensaje..." name="cuerpo_mensaje"
                                              oninput="cuerpo_mensaje()"></textarea>
                                </div>
                            </div>
                            <div class=" col-sm-3 mt-3  ">
                                {!!Form::button('Enviar',['class'=>'btn btn-outline-primary','id'=>'enviar','disabled'=>'disabled'])!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



@endsection


@section('scripts')
    <script>
        function cuerpo_mensaje() {
            if ($('#mensaje').val() !== '') {
                $('#enviar').prop("disabled", false);
                $('#mensaje').prop("rows", "3")
            } else {
                $('#enviar').prop("disabled", true);
                $('#mensaje').prop("rows", "1")
            }


        }

        $('#enviar').click(function () {
            var route = "{{route('enviar_mensaje',$user->id)}}";

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                data: {cuerpo_mensaje: $('#mensaje').val()},
                url: route,
                success: function (data) {
                    console.log(data);
                    if (data.respuesta === true && data.mensaje !== '') {
                        $('#mensaje').val('');
                        $('#mensaje').prop("rows", "1");
                        $('#enviar').prop("disabled", true);

                        $('#chat').append("  <div class=\"text-center\">\n" +
                            "                            <small>"+data.hora+" "+ data.mes+","+data.hora+":"+data.minutos+"</small>\n" +
                            "                        </div>\n" +
                            "                        <div class=\"d-flex justify-content-end\">\n" +
                            "                            <p class=\"primary-color rounded p-3 text-white w-75 \">"+data.mensaje+"</p>\n" +
                            "                        </div>");


                    } else {

                    }

                }
            })

        })
    </script>

@endsection