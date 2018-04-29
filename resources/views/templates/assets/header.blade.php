<nav class="navbar navbar-light bg-primary">
    <a class="navbar-brand text-light" href="/" >
        <!--poner logo--><img src="" width="30" height="30" class="d-inline-block align-top" alt="">
      Fakeapop
    </a>
    <form class="form-inline pull-left">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success text-light my-2 my-sm-0" type="submit">Search</button>
    </form>
</nav>










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
