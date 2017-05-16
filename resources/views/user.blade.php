@extends('base')

@section('content')
    <h3>{!! $user->getNameFormatted() !!}</h3>
    <br />
    <h4>Characters:</h4>
    <ul>
        <li>TODO</li>
    </ul>
    <br />
    <h4>Alle gespeelde sessies:</h4>
    <ul>
        @forelse($sessionsPlayed as $session)
            <li><a href="{{ route('session', ['id' => $session->id]) }}">{{ $session->title }}</a></li>
        @empty
            <li>Deze persoon heeft nog geen sessies gespeeld!</li>
        @endforelse
    </ul>
    <br />

    @if(count($sessionsDMd) > 0)
        <h4>Alle geDMde sessies:</h4>
        <ul>
            @foreach($sessionsDMd as $session)
                <li><a href="{{ route('session', ['id' => $session->id]) }}">{{ $session->title }}</a></li>
            @endforeach
        </ul>
    @endif
@endsection