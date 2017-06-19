<table class="table table-condensed table-bordered responsive-table sessions-table">
    <thead>
        <tr>
            <th colspan="7"><h3 class="text-center">{{ $title }}</h3></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Titel</th>
            <th>Datum</th>
            <th>DungeonMaster</th>
            <th>Game type</th>
            <th>Spelers</th>
            <th>Ronde</th>
            <th>Geschatte tijd</th>
        </tr>
    </tbody>
    <tfoot>
    @forelse($sessions as $session)
        <tr>
            <td><a href="{{ $session->getTitleUrl() }}">{{ $session->title }}</a></td>
            <td>{!! $session->getDateFormatted() !!}</td>
            <td>{!! $session->dungeonMaster()->first()->getNameFormatted() !!}</td>
            <td>{{ $session->gametype }}</td>
            <td>{{ count($session->players()->get()) }}/{{ $session->max_players }}</td>
            <td>{{ $session->round }}</td>
            <td>{{ $session->getApproximateTime() }} uur</td>
        </tr>
    @empty
        <tr>
            <td colspan="7">Er zijn momenteel hier nog geen sessies!</td>
        </tr>
    @endforelse
    </tfoot>
</table>