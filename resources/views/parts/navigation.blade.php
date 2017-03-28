@if(!Auth::check())
    <div class="modal fade" id="login" tab-index="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title" id="modalLabel">Login</h3>
                </div>
                <form method="POST" action="{{ route('login') }}" class="modal-body">
                    <div class="form-group">
                        <label for="username">Gebruikersnaam:</label>
                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                            <input class="form-control" type="text" id="username" name="username"
                                   placeholder="username"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Wachtwoord:</label>
                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </span>
                            <input class="form-control" type="password" id="password" name="password"
                                   placeholder="password"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="stayLogged" value="true"/> Blijf ingelogd
                    </div>
                    <div class="form-group">
                        {{ csrf_field() }}
                        <input class="btn btn-success" type="submit" value="Log in"/>
                    </div>
                </form>
                <div class="modal-footer">
                    <a href="{{ route('register') }}" class="pull-left">Heb je nog geen account?</a>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Sluit</button>
                </div>
            </div>
        </div>
    </div>
@endif
<nav class="navbar navbar-default navbar-static-top navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">CRPG</a>
            @if(Auth::check())
                <p class="navbar-text visible-xs pull-right navbar-username-small">{!! Auth::user()->getNameFormatted() !!}</p>
            @endif
        </div>
        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('map') }}">Map</a></li>
                <li><a href="{{ route('sessions') }}">Sessies</a></li>
                <li><a href="{{ route('players') }}">Spelers</a></li>
            </ul>
            <hr class="visible-xs" />
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <p class="navbar-text hidden-xs">{!! Auth::user()->getNameFormatted() !!}</p>
                    <li class="dropdown hidden-xs">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Mijn characters</a></li>
                            <li><a href="{{ route('me.sessions') }}">Mijn sessies</a></li>
                            @if(Auth::user()->hasPermission(App\Models\AccessLevel::ADMIN))
                                <li><a href="{{ route('admin') }}">Adminpanel</a></li>
                            @endif
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('settings') }}">Settings</a></li>
                            <li><a href="{{ route('logout') }}">Log out</a></li>
                        </ul>
                    </li>
                    <li class="visible-xs"><a href="#">Mijn characters</a></li>
                    <li class="visible-xs"><a href="{{ route('me.sessions') }}">Mijn sessies</a></li>
                    @if(Auth::user()->hasPermission(App\Models\AccessLevel::ADMIN))
                        <li class="visible-xs"><a href="{{ route('admin') }}">Adminpanel</a></li>
                    @endif
                    <li class="visible-xs" role="separator" class="divider"></li>
                    <li class="visible-xs"><a href="{{ route('settings') }}">Settings</a></li>
                    <li class="visible-xs"><a href="{{ route('logout') }}">Log out</a></li>
                @else
                    <li><a href="#" data-toggle="modal" data-target="#login">Log in / Register</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>