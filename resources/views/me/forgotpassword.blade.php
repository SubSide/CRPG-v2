@extends('base')

@section('content')
    <form method="POST" action="{{ route('forgotpassword') }}">
        {{ csrf_field() }}
        @if (isset($message))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <h2 class="text-bold"><strong>Wachtwoord vergeten</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="text" id="email" name="email" placeholder="Email adres" required />
                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-offset-3 col-md-4">
                <br/>
                <input class="btn btn-success" type="submit" value="Send email request" />
            </div>
        </div>
    </form>
@endsection