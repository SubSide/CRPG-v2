@extends('base')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        <div class="row">
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <h2 class="text-bold"><strong>Register</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <div class="form-group">
                    <label for="username">Gebruikersnaam:</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-user"></span>
                        </span>
                        <input class="form-control" type="text" value="{{ old('username') }}" id="username" name="username" placeholder="Gebruikersnaam" title="Name must be alphanumberic and between 4 and 18 characters" pattern="[a-zA-Z0-9]{4,18}" required/>
                    </div>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <div class="form-group">
                    <label for="fullname">Volledige naam:</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-user"></span>
                        </span>
                        <input class="form-control" type="text" value="{{ old('fullname') }}" id="fullname" name="fullname" placeholder="Volledige naam" title="Name must be at least 5 characters" pattern=".{5,}" required/>
                    </div>
                    @if ($errors->has('fullname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('fullname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-envelope"></span>
                        </span>
                        <input class="form-control" type="email" value="{{ old('email') }}" id="email" name="email" placeholder="email" required />
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-2 col-md-4">
                <div class="form-group">
                    <label for="password">Wachtwoord:</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-lock"></span>
                        </span>
                        <input class="form-control" type="password" id="password" name="password" pattern=".{6,}" title="Must be at least 6 characters" placeholder="password" required/>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group">
                    <label for="password2">Herhaal wachtwoord:</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-lock"></span>
                        </span>
                        <input class="form-control" type="password" id="password" name="password_confirmation" pattern=".{6,}" title="Must be at least 6 characters" placeholder="password" required/>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-2 col-md-4">
                {{ csrf_field() }}
                <br/>
                <input class="btn btn-success" type="submit" value="Register"/>
            </div>
        </div>
    </form>
@endsection