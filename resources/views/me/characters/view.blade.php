@extends('base')

@section('content')
    @can('update', $character)
        <div class="dropdown pull-right">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Actions
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="{{ route('character.edit', ['id' => $character->id]) }}">Aanpassen</a></li>
                <li><a href="{{ route('character.delete', ['id' => $character->id]) }}">Verwijderen</a></li>
            </ul>
        </div>
    @endcan
    @if(Auth::check())
        <a class="go-back" href="{{ route('characters') }}">Jouw characters</a>
    @endif
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