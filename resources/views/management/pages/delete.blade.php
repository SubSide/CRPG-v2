@extends('management.pages.form')

@section('content')
    <span class="text-danger">Weet je zeker dat je deze pagina wilt verwijderen?</span>
    <br />
    <br />
    <form method="POST" action="">
        {{ csrf_field() }}
        <input class="btn btn-danger" type="submit" name="imsure" value="Ja" />
        <a href="{{ route('admin.pages') }}" class="btn btn-success">Nee</a>
    </form><br /><br />
    @parent
@endsection