<div id="mySidenav" class="sidenav card  ">
    <div class="container">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a> 
        @guest
            <h2 class="text-center mb-5">Bienvenido</h2>
            ¿Ya estas registrado?<a href="{{route('login')}}">Entra</a>
            <hr> ¿No tienes una cuenta?<a href="{{route('register')}}">Regístrate</a>
        @else
            <div class="row justify-content-sm-center">
                @if(auth()->user()->imagen!=null)
                <img class="d-flex rounded-circle z-depth-1-half mr-3" src="{{asset('imagenes/perfil/'.auth()->user()->imagen)}}" height="200" width="200" alt="Avatar">
                    @else
                    <img class="d-flex rounded-circle z-depth-1-half mr-3" src="{{asset('imagenes/perfil/user-default.png')}}" height="200" width="200" alt="Avatar">
                @endif
            </div>
            <h2 class=" text-center mt-4">{{ Auth::user()->nombre }}</h2>
            <hr class="mb-5">
            <section class="lead">
                <a class="nav-link text-dark" href="{{ route('ver_productos_usuario',auth()->user()->id)}}"> <span class="fa fa-clipboard-list"></span> Mis Productos</a>
                <a class="nav-link text-dark" href="{{ route('ver_productos_usuario_favoritos',auth()->user()->id)}}"> <span class="fa fa-heart"></span> Mis Favoritos</a>
                <a class="nav-link text-dark" href="{{ route('mis_mensajes',auth()->user()->id)}}"> <span class="fa fa-comment"></span> Mis Mensajes</a>
                <a class="nav-link text-dark" href="{{ route('administrar_perfil',auth()->user()->id)}}"> <span class="fa fa-edit"></span> Editar Perfil</a>

                <a href="{{ route('logout')}}" class="nav-link text-dark" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"> <span class="fas fa-sign-out-alt"></span> Log Out
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    </a>
            </section>
        @endguest
    </div>
</div>