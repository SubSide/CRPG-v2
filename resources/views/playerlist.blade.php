@extends('base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/responsive-tables.css') }}" />
@endsection

@section('content')
    <table class="table table-condensed table-bordered responsive-table players-table">
        <thead>
            <tr>
                <th colspan="4"><h3 class="text-center">Spelers</h3></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Naam</th>
                <th>Laatstgespeelde Sessie</th>
                <th>Volgende Sessie</th>
                <th>Meestgespeelde character</th>
            </tr>
        </tbody>
        <tfoot>
            @foreach($users as $user)
                <tr>
                    <td>{!! $user->getNameFormatted() !!}</td>
                    <td>{!! (array_key_exists($user->id, $lastPlayed)) ? '<a href="'. route('session', ['id' => $lastPlayed[$user->id][0] . '-'.str_replace('+', '-', urlencode(preg_replace("/[^a-zA-Z0-9\\ ]+/", "", $lastPlayed[$user->id][1])))]) .'">'.$lastPlayed[$user->id][1].'</a>' : 'Geen' !!}</td>
                    <td>{!! (array_key_exists($user->id, $nextPlaying)) ? '<a href="'. route('session', ['id' => $nextPlaying[$user->id][0] . '-'.str_replace('+', '-', urlencode(preg_replace("/[^a-zA-Z0-9\\ ]+/", "", $nextPlaying[$user->id][1])))]) .'">'.$nextPlaying[$user->id][1].'</a>' : 'Geen' !!}</td>
                    <td>{!! (array_key_exists($user->id, $mostPlayedCharacter)) ? '<a href="'. $mostPlayedCharacter[$user->id]->getTitleUrl() . '">'.$mostPlayedCharacter[$user->id]->name.'</a>' : 'Geen' !!}</td>
                </tr>
            @endforeach
        </tfoot>
    </table>
@endsection