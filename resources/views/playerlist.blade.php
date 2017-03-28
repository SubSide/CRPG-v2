@extends('base')

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
                    <td>Todo</td>
                    <td>Todo</td>
                    <td>Todo</td>
                </tr>
            @endforeach
        </tfoot>
    </table>
@endsection