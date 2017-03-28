@extends('base')

@section('content')
    <div class="playfield">
        <table class="map">
            <?php

            $alph = range('A', 'Z');
            //echo $alphabet[3]; // returns D
            //echo array_search('D', $alphabet); // returns 3

            for($y = 8; $y > 0; $y--){
                echo '<tr>';
                for($x = 0; $x < 8; $x++){
                    echo '<td><img src="http://jobrood.nl/CRPG/'.$alph[$x].$y.'/'.$alph[$x].$y.'.jpg" /></td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
    </div>
    <script type="text/javascript" src="{{ asset('/scripts/mapdrag.js') }}"></script>
@endsection