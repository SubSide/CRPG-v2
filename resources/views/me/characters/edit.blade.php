@extends('base')

@section('content')
    <div>
        <p><a href="{{ route('characters') }}">Terug naar je character lijst</a></p>
        <form method="POST" action="{{ route('character.edit', ['id' => $character->id]) }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <h2 class="text-bold"><strong>Character aanpassen</strong></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="name">Character naam:</label>
                        <input class="form-control" type="text" id="name" value="{{ old('name', $character->name) }}" name="name" placeholder="Naam" required/>
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
                        <input class="form-control" type="text" id="class" value="{{ old('class', $character->class) }}" name="class" placeholder="Class" required/>
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
                        <input class="form-control" type="text" id="gametype" value="{{ old('gametype', $character->gametype) }}" name="gametype" placeholder="Gametype" required/>
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
                        <input class="form-control" name="level" type="number" id="level" value="{{ old('level', $character->level) }}" min="1" step="1" max="{{ \App\Models\Character::getMaxLevel($character->user->xpLeft() + \App\Models\Character::getLevelXp($character->level)) }}" placeholder="Level" required/>
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
                    Je hebt nog <span id="dyn_xp">{{ $character->user->xpLeft() }}</span>/{{ $character->user->maxXp() }} over!
                </div>
            </div>
            <script type="text/javascript">
                // The amount of XP you can spend
                var xpOver = {{ $character->user->xpLeft() + \App\Models\Character::getLevelXp($character->level) }};

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
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="preview-input">Character story:</label>
                        <textarea class="form-control" id="preview-input" name="story" placeholder="Character story">{{ old('story', $character->story) }}</textarea>
                    </div>
                    @if ($errors->has('story'))
                        <span class="help-block">
                            <strong>{{ $errors->first('story') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6" id="preview">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-offset-3 col-md-4">
                    <br/>
                    <input class="btn btn-success" type="submit" value="Edit" />
                </div>
            </div>
        </form>
    </div>
@endsection

@section('stylesheets')
    @parent()
    <link rel="stylesheet" href="/scripts/xbbcode/xbbcode.css" />
@endsection

@section('scripts')
    @parent()
    <script type="text/javascript" src="/scripts/xbbcode/xbbcode.js"></script>
    <script type="text/javascript" src="/scripts/preview.js"></script>
@endsection