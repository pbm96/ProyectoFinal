<!--Navbar-->
<nav class="navbar navbar-dark primary-color">
    <span class="text-white" style="font-size:25px;cursor:pointer" onclick="openNav()">&#9776;</span>
    <!-- Navbar brand -->
    <a class="h1 text-white" href="{{ route('index') }}">Fakeapop</a>
    <ul class="nav navbar-rigth mr-5 list-group-flush">
        @guest @else
        <li class="nav-item dropdown notifications-nav show text-white mr-5">
            <a class="nav-link dropdown-toggle waves-effect" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="true">
                    <span class="badge bg-secondary" id="numero_notificaciones"></span>
                    <i class="fa fa-bell"></i>
                </a>
            <div class="dropdown-menu dropdown-info " aria-labelledby="navbarDropdownMenuLink" id="descripcion_notificacion"></div>
        </li>
        <a href="#" style="border-radius:10em; color: black !important" class="bg-white btn"> <span class="text-primary fa fa-plus fa-lg mr-2"></span>Nuevo producto</a>
        @endguest
    </ul>
</nav>