@extends('session')

@section('content')
<span class="text-danger">Weet je zeker dat je deze sessie wilt verwijderen?</span>
<br />
<br />
<form method="POST" action="">
    {{ csrf_field() }}
    <input class="btn btn-danger" type="submit" name="imsure" value="Ja" />
    <a href="/session/<?=$session->id;?>" class="btn btn-success">Nee</a>
</form><br />
    @parent()
@endsection