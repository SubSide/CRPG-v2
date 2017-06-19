@extends('base')

@section('content')
    <div>
        <p><a href="{{ route('characters') }}">Terug naar je character lijst</a></p>
        <form method="POST" action="{{ route('character.create') }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <h2 class="text-bold"><strong>Nieuwe Character</strong></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="name">Character naam:</label>
                        <input class="form-control" type="text" id="name" value="{{ old('name') }}" name="name" placeholder="Naam" required/>
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="class">Class:</label>
                        <input class="form-control" type="text" id="class" value="{{ old('class') }}" name="class" placeholder="Class" required/>
                    </div>
                    @if ($errors->has('class'))
                        <span class="help-block">
                        <strong>{{ $errors->first('class') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="gametype">Gametype:</label>
                        <input class="form-control" type="text" id="gametype" value="{{ old('gametype', '5e') }}" name="gametype" placeholder="Gametype" required/>
                    </div>
                    @if ($errors->has('gametype'))
                        <span class="help-block">
                        <strong>{{ $errors->first('gametype') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="level">Level:</label><small> (Level <span id="dyn_level"></span> kost <span id="dyn_cost"></span> xp)</small>
                        <input class="form-control" name="level" type="number" id="level" value="{{ old('level', '1') }}" min="1" step="1" max="{{ \App\Models\Character::getMaxLevel(Auth::user()->xpLeft()) }}" placeholder="Level" required/>
                    </div>
                    @if ($errors->has('level'))
                        <span class="help-block">
                        <strong>{{ $errors->first('level') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    Je hebt nog <span id="dyn_xp">{{ Auth::user()->xpLeft() }}</span>/{{ Auth::user()->maxXp() }} over!

                </div>
            </div>
            <script type="text/javascript">
                // The amount of XP you can spend
                var xpOver = {{ Auth::user()->xpLeft() }};

                function calculateXpLeft(){
                    // prevent rounding and integer errors
                    var lvl = parseFloat($("#level").val());

                    if(isNaN(lvl)) {
                        // If it is not a number, we want to display the xp left
                        $("#xp").html(xpOver);
                        return;
                    }
                    var xpNeeded = ((lvl * (lvl + 1)) / 2 - 1);
                    $("#dyn_level").html(lvl);
                    $("#dyn_cost").html(xpNeeded);

                    // Use the formula (n*(n+1))/2 - 1 to calculate the xp you need per level
                    $("#dyn_xp").html(Math.floor(xpOver - xpNeeded));
                }

                $("#level").on('change keyup', calculateXpLeft);

                calculateXpLeft();
            </script>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-offset-3 col-md-4">
                    <br/>
                    <input class="btn btn-success" type="submit" value="Create"/>
                </div>
            </div>
        </form>
    </div>
@endsection
