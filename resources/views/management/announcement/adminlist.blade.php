@extends('base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/responsive-tables.css') }}" />
@endsection

@section('content')
    <p><a href="{{ route('admin') }}">Terug naar het admin menu</a></p>
    <table class="table table-condensed table-bordered responsive-table admin-announcements-table">
        <thead>
        <tr>
            <th colspan="4"><h4 class="text-center">Announcements</h4></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Titel</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        </tbody>
        <tfoot>
        @foreach($announcements as $announcement)
        <tr>
            <td>{{ $announcement->title }}</td>
            <td><a href="{{ route('announcement.edit', ['id' => $announcement->id]) }}">Edit</a></td>
            <td><a href="{{ route('announcement.delete', ['id' => $announcement->id]) }}">Delete</a></td>
        </tr>
        @endforeach
        </tfoot>
    </table>
    <a href="{{ route('announcement.create') }}" class="btn btn-default">Maak een nieuwe announcement</a>
@endsection