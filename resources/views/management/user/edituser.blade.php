@extends('base')

@section('content')
<div>
    <p><a href="{{ route('admin.users') }}">Terug naar de user lijst</a></p>

    @if(session('msg'))
        <div class="text-info">
            {{ session('msg') }}
        </div>
    @endif
    <form method="POST" action="">
        {{ csrf_field() }}
        @if($user->access_level >= Auth::user()->access_level)
            <div class="row">
                <h4 class="col-xs-12 text-danger text-center">Let op: Je hebt niet de rechten om deze gebruiker aan te passen!</h4>
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <h2 class="text-bold"><strong>Gebruiker aanpassen</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="username">Gebruikersnaam:</label>
                    <input class="form-control" type="text" id="username" name="username" placeholder="username" value="{{ old('username', $user->username) }}" required {{ ($user->access_level >= Auth::user()->access_level)?"disabled":"" }} />
                </div>
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="fullname">Volledige naam:</label>
                    <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Volledige naam" value="{{ old('fullname', $user->fullname) }}" required {{ ($user->access_level >= Auth::user()->access_level)?"disabled":"" }} />
                </div>
                @if ($errors->has('fullname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('fullname') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label>Geregistreerd op:</label>
                    <input class="form-control" type="text" value="{{ $user->date_registered }}" disabled />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="email">Email adres:</label>
                    <input class="form-control" type="email" id="email" name="email" placeholder="email" value="{{ old('email', $user->email) }}" required {{ ($user->access_level >= Auth::user()->access_level)?"disabled":"" }} />
                </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="email">Wachtwoord (Houd leeg om niet aan te passen):</label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="(Houd deze leeg om niet aan te passen)" {{ ($user->access_level >= Auth::user()->access_level)?"disabled":"" }} />
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="access_level">Access level:</label>
                    <select class="form-control" id="access_level" name="access_level" {{ ($user->access_level >= Auth::user()->access_level)?"disabled":"" }}>
                        <option value="0" {{ ($user->access_level===\App\Models\AccessLevel::USER)?"selected":"" }}>User</option>
                        <option value="1" {{ ($user->access_level===\App\Models\AccessLevel::ADMIN)?"selected":"" }} {{ Auth::user()->hasPermission(\App\Models\AccessLevel::WEBMASTER)?"":"disabled" }}>Admin</option>
                        <option value="2" {{ ($user->access_level===\App\Models\AccessLevel::WEBMASTER)?"selected":"" }} disabled>Webmaster</option>
                    </select>
                </div>
                @if ($errors->has('access_level'))
                    <span class="help-block">
                        <strong>{{ $errors->first('access_level') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <input type="checkbox" id="verified" name="verified" {{ old('verified', $user->verified)?"checked":"" }}  {{ ($user->access_level >= Auth::user()->access_level)?"disabled":"" }}/>
                <label for="verified">geverifieerd</label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-3 col-md-4">
                <br/>
                <input class="btn btn-success" type="submit" value="Update" {{ ($user->access_level >= Auth::user()->access_level)?"disabled":"" }} />
            </div>
        </div>
    </form>
</div>
@endsection