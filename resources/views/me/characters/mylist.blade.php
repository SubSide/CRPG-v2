@extends('base')

@section('content')
    <table class="table table-condensed table-bordered responsive-table admin-announcements-table">
        <thead>
        <tr>
            <th colspan="5"><h4 class="text-center">Mijn characters</h4></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Name</th>
            <th>Class</th>
            <th>Level</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        </tbody>
        <tfoot>
        @foreach($characters as $character)
        <tr>
            <td>{{ $character->name }}</td>
            <td>{{ $character->class }}</td>
            <td>{{ $character->level }}</td>
            <td><a href="{{ route('character.edit', ['id' => $character->id]) }}">Edit</a></td>
            <td><a href="{{ route('character.delete', ['id' => $character->id]) }}">Delete</a></td>
        </tr>
        @endforeach
        </tfoot>
    </table>
    <a href="{{ route('character.create') }}" class="btn btn-default">Maak een nieuw character</a>
@endsection