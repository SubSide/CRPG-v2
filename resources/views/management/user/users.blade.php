@extends('base')

@section('content')
<p><a href="{{ route('admin') }}">Terug naar het admin menu</a></p>
<table class="table table-condensed table-bordered responsive-table admin-user-table">
    <thead>
    <tr>
        <th colspan="4"><h4 class="text-center">Gebruikers</h4></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>Naam</th>
        <th>Gebruikersnaam</th>
        <th>Access level</th>
        <th>Edit</th>
    </tr>
    </tbody>
    <tfoot>
    @foreach($users as $user)
    <tr>
        <td>{!! $user->getNameFormatted() !!}</td>
        <td>{{ $user->username }}</td>
        <td>{!! \App\Models\AccessLevel::getLevelFormatted($user->access_level) !!}</td>
        <td><a href="{{ route('admin.users.edit', ['username' => $user->username]) }}">Edit</a></td>
    </tr>
    @endforeach
    </tfoot>
</table>
@endsection