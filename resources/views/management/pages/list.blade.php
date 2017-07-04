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
            <th colspan="6"><h4 class="text-center">Pages</h4></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Titel</th>
            <th>Last aangepast door</th>
            <th>Type</th>
            <th>Alleen voor ingelogde?</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        </tbody>
        <tfoot>
        @foreach($pages as $page)
            <tr>
                <td><a href="{{ $page->getTitleUrl() }}">{{ $page->title }}</a></td>
                <td>{!! $page->lastEditedBy->getNameFormatted() !!}</td>
                <td>{{ \App\Models\PageType::getString($page->type) }}</td>
                <td>{{ $page->logged_in ? 'Ja' : 'Nee' }}</td>
                <td><a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}">Edit</a></td>
                <td><a href="{{ route('admin.pages.delete', ['id' => $page->id]) }}">Delete</a></td>
            </tr>
        @endforeach
        </tfoot>
    </table>
    <a href="{{ route('admin.pages.edit') }}" class="btn btn-default">Maak een nieuwe pagina</a>
@endsection