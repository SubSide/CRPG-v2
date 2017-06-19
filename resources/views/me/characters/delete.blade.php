@extends('base')

@section('content')
    <span class="text-danger">Weet je zeker dat je deze character wilt verwijderen?</span>
    <br />
    <br />
    <form method="POST" action="{{ route('character.delete', ['id' => $character->id]) }}">
        {{ csrf_field() }}
        <input class="btn btn-danger" type="submit" name="imsure" value="Ja" />
        <a href="{{ $character->getTitleUrl() }}" class="btn btn-success">Nee</a>
    </form><br />
    @parent()
@endsection