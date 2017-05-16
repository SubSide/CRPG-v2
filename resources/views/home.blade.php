@extends('base')

@section('content')
    @foreach($announcements as $announcement)
        <article class="announcement">
            @if(Auth::check() && Auth::user()->hasPermission(\App\Models\AccessLevel::ADMIN))
                <div class="dropdown pull-right hidden-xs">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Actions
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="{{ route('announcement.edit', ['id' => $announcement->id]) }}">Aanpassen</a></li>
                        <li><a href="{{ route('announcement.delete', ['id' => $announcement->id]) }}">Verwijderen</a></li>
                    </ul>
                </div>
            @endif

            <h3>
                <a class="announcement-title" href="{{ route('announcement.show', ['id' => $announcement->id]) }}">{{ $announcement->title }}</a><br />
                <small>Bij {!! $announcement->user->getNameFormatted() !!} op {{ $announcement->getDatePostedFormatted() }}</small>
            </h3>
            <hr />
            <pre>
                {{ strip_tags($announcement->content) }}
            </pre>
            <hr />
            {{--<a href="{{ route('announcement.show', ['id' => $announcement->id]) }}" class="announcement-link-text">{{ $announcement->comments() }} comment{{ ($announcement->getCommentCount()!=1)?"s":"" }}</a>--}}
            @if(Auth::check() && Auth::user()->hasPermission(\App\Models\AccessLevel::ADMIN))
                <div class="pull-right visible-xs">
                    <a class="announcement-link-text" href="/announcement/edit/<?=$announcement->id;?>/">Aanpassen</a> |
                    <a class="announcement-link-text" href="/announcement/<?=$announcement->id;?>/delete">Verwijderen</a>
                </div>
            @endif
        </article>
    @endforeach
@endsection