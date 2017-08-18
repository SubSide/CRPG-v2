@extends('base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/page.css') }}" />
@endsection

@section('content')
    <section class="page">
        @can('update', $page)
            <div class="dropdown pull-right hidden-xs">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Actions
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="{{ route('admin.pages.edit', ['id' => $page->id]) }}">Aanpassen</a></li>
                    @if($page->id != 1)
                        <li><a href="{{ route('admin.pages.delete', ['id' => $page->id]) }}">Verwijderen</a></li>
                    @endif
                </ul>
            </div>
        @endcan
        <h3>{{ $page->title }}</h3>
        <hr />
        <div class="page-content">{!! $page->processedContent() !!}</div>
        <hr />
        @can('update', $page)
            <div class="pull-right visible-xs">
                <a class="page-link-text" href="{{ route('admin.pages.edit', ['id' => $page->id]) }}">Aanpassen</a>
                @if($page->id != 1)
                    | <a class="page-link-text" href="{{ route('admin.pages.delete', ['id' => $page->id]) }}">Verwijderen</a>
                @endif
            </div>
        @endcan
    </section>

@endsection

@section('scripts')
    @parent
    {{--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/jq-2.2.4/dt-1.10.15/r-2.1.1/datatables.min.css"/>--}}

    <script type="text/javascript" src="https://cdn.datatables.net/v/jq-2.2.4/dt-1.10.15/r-2.1.1/datatables.min.js"></script>
    <script type="text/javascript">
        $("table.dttable").addClass("table").dataTable({
            responsive: true
        });
    </script>
@endsection