<!--Navbar-->
<nav class="navbar navbar-dark primary-color">
    <a id="menuIcon" class="menu-icon text-white"> &#9776; </a>
    <a class="navbar-brand " href="{{ route('index') }}"><h2 class="h2">Fakeapop</h2></a> {{ Form::open(['route' => ['buscador'], 'method' => 'GET', 'class' =>
    'form-inline']) }}
    <div class="my-0">
        <ul class="nav navbar-rigth mr-5 list-group-flush">

            @guest @else
            <li class="nav-item dropdown notifications-nav show text-white mr-4">
                <a class="nav-link dropdown-toggle  waves-effect   pt-3 " id="notificaciones"  data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                    <i class=" fa fa-lg  fa-bell p-0"></i>
                    <span class="badge amber darken-4  " id="numero_notificaciones"></span>
                    </a>
                <div class="dropdown-menu dropdown-info mt-2 border-primary" aria-labelledby="navbarDropdownMenuLink" id="descripcion_notificacion">
                </div>
            </li>
            @endguest
        </ul>
    </div>
    <div class="md-form my-0 d-sm-none d-none d-sm-block">
        {{ Form::text('buscar', old('buscar'), array('placeholder'=>'Buscar...','class'=>'form-control mr-sm-2','aria-label'=>'buscar' ,'id'=>'buscador'))
        }}
        <button class="btn btn-outline-light btn-sm" type="submit">Buscar</button>
    </div>
    {{ Form::close() }}


</nav>
<!--/.Navbar-->