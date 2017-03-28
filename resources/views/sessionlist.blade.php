@extends('base')

@section('content')
    @include('macros.sessiontable', ['title' => 'Sessies deze week', 'sessions' => $thisWeek])
    <br /><br />
    @include('macros.sessiontable', ['title' => 'Sessies volgende week', 'sessions' => $nextWeek])
    <br /><br />
    @include('macros.sessiontable', ['title' => 'Toekomstige sessies', 'sessions' => $future])
@endsection