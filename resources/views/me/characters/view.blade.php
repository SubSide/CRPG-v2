@extends('base')

@section('content')
    <h2>{{ $character->name }}</h2>
    <p>
        Speler: {!! $character->user()->first()->getNameFormatted() !!}<br />
        Class: {{ $character->class }}<br />
        Level: {{ $character->level }}
    </p>
    <br />
    <h4>Alle gespeelde sessies:</h4>
    @forelse($character->sessions()->get() as $session)
        <li><a href="{{ $session->getTitleUrl() }}">{{ $session->title }}</a></li>
    @empty
        <li>Er is met deze character nog geen sessie gespeeld!</li>
    @endforelse
@endsection