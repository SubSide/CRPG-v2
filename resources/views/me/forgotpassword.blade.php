@extends('base')

@section('content')
    <form method="POST" action="{{ route('forgotpassword') }}">
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
                <h2 class="text-bold"><strong>Wachtwoord vergeten</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-offset-3 col-md-6">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="text" id="email" name="email" placeholder="Email adres" required />
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