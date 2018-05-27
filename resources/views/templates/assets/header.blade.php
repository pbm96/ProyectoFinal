<!--Navbar-->
<nav class="navbar navbar-dark primary-color">
    <span class="text-white" style="font-size:25px;cursor:pointer" onclick="openNav()">&#9776;</span>
    <!-- Navbar brand -->
    <a class="h1 text-white" href="{{ route('index') }}">Fakeapop</a>
    <ul class="nav navbar-rigth mr-5 list-group-flush">

        @guest @else
        <li class="nav-item dropdown notifications-nav show text-white mr-4">
        <a class="nav-link dropdown-toggle  waves-effect   pt-3 " id="notificaciones" title="Notificaciones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <i class=" fa fa-lg  fa-bell p-0"></i>
        <span class="badge amber darken-4  " id="numero_notificaciones"></span>
        </a>
        <div class="dropdown-menu dropdown-info mt-2 border-primary" aria-labelledby="navbarDropdownMenuLink" id="descripcion_notificacion">
        </div>
        </li>
        @endguest
            <a href="{{route('crear_producto')}}" title="Crear Producto" style="border-radius:10em; color: black !important" class="bg-white btn waves-effect"> <span class="text-primary fa fa-plus fa-lg mr-2"></span>Nuevo producto</a>

    </ul>
</nav>