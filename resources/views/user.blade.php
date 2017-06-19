@extends('base')

@section('content')
    <h3>{!! $user->getNameFormatted() !!}</h3>
    <br />
    <h4>Characters:</h4>
    <ul>
        @forelse($user->characters()->get() as $character)
            <li><a href="{{ $character->getTitleUrl() }}">{{ $character->name }}</a></li>
        @empty
            <li>Deze persoon heeft nog geen characters aangemaakt!</li>
        @endforelse
    </ul>
    <br />
    <h4>Alle gespeelde sessies:</h4>
    <ul>
        @forelse($sessionsPlayed as $session)
            <li><a href="{{ $session->getTitleUrl() }}">{{ $session->title }}</a></li>
        @empty
            <li>Deze persoon heeft nog geen sessies gespeeld!</li>
        @endforelse
    </ul>
    <br />

    @if(count($sessionsDMd) > 0)
        <h4>Alle geDMde sessies:</h4>
        <ul>
            @foreach($sessionsDMd as $session)
                <li><a href="{{ $session->getTitleUrl() }}">{{ $session->title }}</a></li>
            @endforeach
        </ul>
    @endif

    @if($user->id == 48)
        <audio autoplay>
            <source src="{{ asset('/sounds/intro.ogg') }}" type="audio/ogg">
            Your browser does not support the audio element.
        </audio>
    @endif
@endsection