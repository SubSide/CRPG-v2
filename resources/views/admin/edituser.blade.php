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
        @if($user->accessLevel >= Auth::user()->accessLevel)
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
                    <input class="form-control" type="text" id="username" name="username" placeholder="username" value="{{ old('username', $user->username) }}" required {{ ($user->accessLevel >= Auth::user()->accessLevel)?"disabled":"" }} />
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
                    <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Volledige naam" value="{{ old('fullname', $user->fullname) }}" required {{ ($user->accessLevel >= Auth::user()->accessLevel)?"disabled":"" }} />
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
                    <label for="email">Email adres:</label>
                    <input class="form-control" type="email" id="email" name="email" placeholder="email" value="{{ old('email', $user->email) }}" required {{ ($user->accessLevel >= Auth::user()->accessLevel)?"disabled":"" }} />
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
                    <label for="accesslevel">Access level:</label>
                    <select class="form-control" id="accesslevel" name="accesslevel" {{ ($user->accessLevel >= Auth::user()->accessLevel)?"disabled":"" }}>
                        <option value="0" {{ ($user->accessLevel==\App\Models\AccessLevel::USER)?"selected":"" }}>User</option>
                        <option value="1" {{ ($user->accessLevel==\App\Models\AccessLevel::ADMIN)?"selected":"" }} {{ Auth::user()->hasPermission(\App\Models\AccessLevel::WEBMASTER)?"":"disabled" }}>Admin</option>
                        <option value="2" {{ ($user->accessLevel==\App\Models\AccessLevel::WEBMASTER)?"selected":"" }} disabled>Webmaster</option>
                    </select>
                </div>
                @if ($errors->has('accesslevel'))
                    <span class="help-block">
                        <strong>{{ $errors->first('accesslevel') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <input type="checkbox" id="verified" name="verified" {{ old('verified', $user->verified)?"checked":"" }}  {{ ($user->accessLevel >= Auth::user()->accessLevel)?"disabled":"" }}/>
                <label for="verified">geverifieerd</label>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-3 col-md-4">
                <br/>
                <input class="btn btn-success" type="submit" value="Update" {{ ($user->accessLevel >= Auth::user()->accessLevel)?"disabled":"" }} />
            </div>
        </div>
    </form>
</div>
@endsection