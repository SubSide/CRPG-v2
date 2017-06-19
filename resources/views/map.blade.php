@extends('base')

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('css/map.css') }}" />
@endsection

@section('content')
    <div class="playfield">
        <table class="map">
            @php
                $alph = range('A', 'Z');
            @endphp

            @for($y = 8; $y > 0; $y--)
                <tr>
                @for($x = 0; $x < 8; $x++)
                    <td><img src="http://jobrood.nl/CRPG/{{ $alph[$x].$y }}/{{ $alph[$x].$y }}.jpg" /></td>
                @endfor
                </tr>
            @endfor
        </table>
    </div>
    <script type="text/javascript" src="{{ asset('/scripts/mapdrag.js') }}"></script>
@endsection