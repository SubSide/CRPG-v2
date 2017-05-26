@extends('base')

@section('content')
    @if(count($thisWeek) > 0)
        @include('macros.sessiontable', ['title' => 'Sessies deze week', 'sessions' => $thisWeek])
        <br />
    @endif

    @if(count($nextWeek) > 0)
        <br />
        @include('macros.sessiontable', ['title' => 'Sessies volgende week', 'sessions' => $nextWeek])
        <br />
    @endif

    @if(count($future) > 0)
        <br />
        @include('macros.sessiontable', ['title' => 'Toekomstige sessies', 'sessions' => $future])
    @endif

    @if(count($thisWeek) < 1 && count($nextWeek) < 1 && count($future) < 1)
        Er zijn nog geen sessies gepland!
    @endif

    <br />
    Wil je zelf een sessie runnen?
    {!! Auth::check() ? '<a href="' . route('me.sessions') . '">Klik hier!</a>' : 'Registreer of log in!' !!}
@endsection