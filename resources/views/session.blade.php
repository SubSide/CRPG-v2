@extends('base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/session.css') }}" />
@endsection

@section('content')
<div class="session">
    @can('update', $session)
    <div class="dropdown pull-right">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Actions
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="{{ route('session.edit', ['id' => $session->id]) }}">Aanpassen</a></li>
            <li><a href="{{ route('session.delete', ['id' => $session->id]) }}">Verwijderen</a></li>
        </ul>
    </div>
    @endcan
    <a class="go-back" href="{{ route('sessions') }}">Ga terug</a>
    @if(session('err'))
        <div class="text-danger">
            {{ session('err') }}
        </div>
    @endif

    <h2>{{ $session->title }}</h2>
    <p>
        Wordt gehouden op: {!! $session->getDateFormatted() !!}<br />
        Geschatte tijdsduur: {{ $session->getApproximateTime() }}<br />
        Dungeon Master: {!! $session->dungeonMaster->getNameFormatted() !!}<br />
        Gametype: <span class="data">{{ $session->gametype }}</span><br />
        Voorgaande session: <span class="data">TODO</span>
    </p>
    <br />
    <h3>Inleiding</h3>
    <p>{{ $session->prologue }}</p>
    <br />
    <h3>Spelers ({{ $session->players->count().'/'.$session->max_players }})</h3>

    @forelse($session->players()->get() as $user)
        <p>
            {!! $user->getNameFormatted() !!}
            @if($character = App\Models\Character::find($user->pivot->character_id))
                &nbsp;&nbsp;<small class="char-desc">(als <a href="{{ $character->getTitleUrl() }}">{{ $character->name }}</a>, de lvl {{ $character->level }} {{ $character->class }})</small>
            @endif
        </p>
    @empty
        <p>Op dit moment heeft nog niemand zich ingeschreven!</p>
    @endforelse

    @if(Auth::check() && strtotime($session->date) > time())
        <br />
        <p>
            @if($session->players->contains(Auth::user()->id))
                Je doet al mee!
            <form method="POST" action="{{ route('session.signout', ['id' => $session->id]) }}">
                {{ csrf_field() }}
                <input class="submit-link" type="submit" name="signout" value="Klik hier om uit te schrijven." />
            </form>
        @elseif($session->dungeonMaster == Auth::user())
            Je bent de Dungeon Master!
        @elseif($session->max_players <= $session->players->count())
            Deze sessie zit vol!
        @else
            Wil je mee doen?<br />
            <a role="button" data-toggle="collapse" href="#signin-form" aria-expanded="false" aria-controls="collapseExample">Klik hier om je in te schrijven</a>
            <form method="POST" class="collapse" id="signin-form" action="{{ route('session.signin', ['id' => $session->id]) }}">
                <br />
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-8 col-sm-5">
                        <select id="character" class="form-control" name="character">
                            <option selected>(Kies een character)</option>
                            @foreach(Auth::user()->characters()->get() as $character)
                                <option value="{{ $character->id }}">{{ $character->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4 col-xs-7">
                        <input class="btn btn-success" type="submit" name="signin" value="Schrijf in" />
                    </div>
                </div>
                <br />
            </form>
        @endif
        </p>
    @endif
</div>
@endsection