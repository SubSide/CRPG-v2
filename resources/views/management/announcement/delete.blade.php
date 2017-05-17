@extends('base')

@section('content')
    <span class="text-danger">Weet je zeker dat je deze announcement wilt verwijderen?</span>
    <br />
    <br />
    <form method="POST" action="{{ route('announcement.delete', ['id' => $announcement->id]) }}">
        {{ csrf_field() }}
        <input class="btn btn-danger" type="submit" name="imsure" value="Ja" />
        <a href="{{ route('announcement.list') }}" class="btn btn-success">Nee</a>
    </form><br />
    @parent()
@endsection