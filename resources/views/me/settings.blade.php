@extends('base')

@section('content')
    <form method="POST" action="{{ route('settings') }}">
        {{ csrf_field() }}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (!empty($msg))
            <div class="alert alert-info">
                {{ $msg }}
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <h2 class="text-bold"><strong>Instellingen</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="username">Gebruikersnaam:</label>
                    <input class="form-control" type="text" value="{{ Auth::user()->username }}" disabled />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="fullname">Volledige naam:</label>
                    <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Volledige naam" value="{{ old('fullname', Auth::user()->fullname) }}" title="Name must be at least 5 characters" pattern=".{5,}" required />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="password">Nieuw wachtwoord:</label>
                    <div class="input-group">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-lock"></span>
                    </span>
                        <input class="form-control" type="password" id="password" name="password" pattern=".{6,}" title="Must be at least 6 characters" placeholder="password" />
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="password2">Herhaal nieuw wachtwoord:</label>
                    <div class="input-group">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-lock"></span>
                    </span>
                        <input class="form-control" type="password" id="password" name="password_confirmation" pattern=".{6,}" title="Must be at least 6 characters" placeholder="password" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-3 col-md-4">
                <br/>
                <input class="btn btn-success" type="submit" value="Update"/>
            </div>
        </div>
    </form>
@endsection