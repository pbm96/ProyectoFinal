<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
            .btn-outline-primary {
                border: 2px solid #1491e5 !important;
                background-color: #1491e5!important;
                color: #ffffff!important;
                border-radius: 10em
            ;
            }

            .btn {
                padding: .84rem 2.14rem;
                font-size: .81rem;
                -webkit-transition: all .2s ease-in-out;
                transition: all .2s ease-in-out;
                margin: .375rem;
                border: 0;

                cursor: pointer;
                text-transform: uppercase;
                white-space: normal;
                word-wrap: break-word;
            }
            a{
                text-decoration: none !important;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    @yield('message')

                </div>
                <a href="{{route('index')}}" class="btn btn-outline-primary"> Volver a Fakeapop</a>
            </div>
        </div>
    </body>
</html>
