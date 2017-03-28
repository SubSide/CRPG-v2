@extends('base')

@section('content')
    <form method="POST"  class="container jumbotron login" action="{{ route('login') }}">
        <div class="row">
            <div class="col-xs-12 col-md-offset-2 col-md-8">
                <h2 class="text-bold"><strong>Log in</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-2 col-md-4">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-user"></span>
                        </span>
                        <input class="form-control" type="text" id="username" name="username" placeholder="username"/>
                    </div>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-lock"></span>
                        </span>
                        <input class="form-control" type="password" id="password" name="password" placeholder="password"/>
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-2 col-md-4">
                <input type="checkbox" id="stayLogged" name="stayLogged" value="true" /><label for="stayLogged">Stay logged in</label><br /><br />
            </div>
        </div>
        {{ csrf_field() }}
    </form>
@endsection