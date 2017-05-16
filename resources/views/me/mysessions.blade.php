@extends('base')

@section('content')
    @include('macros.sessiontable', ['title' => 'Jouw sessies', 'sessions' => $sessions])

    <a href="{{ route('session.create') }}" class="btn btn-default">Maak een nieuwe sessie</a>
@endsection