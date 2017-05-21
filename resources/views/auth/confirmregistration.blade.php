@extends('base')

@section('content')
    @if(isset($message))
        {{ $message }}
    @else
        Succes! Je kan nu inloggen! :)
    @endif
@endsection