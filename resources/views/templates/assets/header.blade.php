<!--Navbar-->
<nav class="navbar navbar-dark primary-color">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="{{ route('index') }}">Fakeapop</a>
    <ul class="nav navbar-rigth mr-5 list-group-flush">
        <a class="btn-floating btn-lg text-white light-blue darken-4" href="{{route('crear_producto')}}"><i class="fa fa-plus"></i></a>
        <li class="nav-item dropdown">
            @guest
                <a class="text-white nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administrar Usuario</a>
            @else
            <a class="text-white nav-link dropdown-toggle mr-5" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->nombre_usuario}}</a>

                    @endguest
            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                @guest
                <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                <a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                @else
                        <a class="nav-link text-light" href="{{ route('administrar_perfil',auth()->user()->id)}}">Editar Perfil</a>

                        <a href="{{ route('logout')}}"  class="nav-link text-light" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Log Out
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                </a>
                @endguest
            </div>
        </li>
    </ul>
</nav>
