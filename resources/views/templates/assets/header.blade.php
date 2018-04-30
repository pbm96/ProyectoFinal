<!--Navbar-->
<nav class="navbar navbar-dark primary-color">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="{{ route('index') }}">Fakeapop</a>

    <ul class="nav navbar-rigth mr-3 list-group-flush">
        <li class="nav-item dropdown">
            @guest
                <a class="text-white nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administrar Usuario</a>
            @else
            <a class="text-white nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
            @endguest
            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                @guest
                <a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a>
                <a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                @else
                <a href="{{ route('logout')}}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="icon-key"></i> Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                @endguest
            </div>
        </li>
    </ul>
</nav>
<!--/.Navbar-->









    <!--@guest
        <form class="form-inline my-2 my-lg-0 col-md-4 ">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <ul class=" navbar-nav  ">
            <li><a class="nav-link text-light" href="{{ route('login') }}">{{ __('Login') }}</a></li>
            <li><a class="nav-link text-light" href="{{ route('register') }}">{{ __('Register') }}</a></li>
        </ul>
        @else

            <ul class="navbar-nav ml-auto pull-right">
                <li class="nav-item dropdown text-light">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>

                    logout
                      <a href="{{ route('logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
             <i class="icon-key"></i> Log Out
             </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
                    </form>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @endguest
-->
