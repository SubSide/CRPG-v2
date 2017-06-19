@extends('base')

@section('content')
    <div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('session.edit', ['id' => $session->id]) }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <h2 class="text-bold"><strong>"{{ $session->title }}" aanpassen</strong></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="title">Titel:</label>
                        <input class="form-control" value="{{ old('title', $session->title) }}" type="text" id="title" name="title" placeholder="Titel" required/>
                    </div>
                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label>Datum (YYYY-MM-DD) en tijd (HH:MM):</label>
                        <div class='input-group'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                            <input type='date' value="{{ old('date', date("Y-m-d", strtotime($session->date))) }}" name="date" class="form-control" placeholder="YYYY-MM-DD" />

                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                            <input type='time' value="{{ old('time', date("H:i",strtotime($session->date))) }}" name="time" class="form-control" step="900" placeholder="HH:MM" />
                        </div>
                        @if ($errors->has('date'))
                            <span class="help-block">
                            <strong>{{ $errors->first('date') }}</strong>
                        </span>
                        @endif
                        @if ($errors->has('time'))
                            <span class="help-block">
                            <strong>{{ $errors->first('time') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label>Geschatte tijdsduur (HH:MM):</label>
                        <div class='input-group'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                            <input type='time' value="{{ old('approxtime', $session->approx_time) }}" name="approxtime" step="900" class="form-control" />
                        </div>
                        @if ($errors->has('approxtime'))
                            <span class="help-block">
                            <strong>{{ $errors->first('approxtime') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="gametype">Gametype:</label>
                        <input class="form-control" value="{{ old('gametype', $session->gametype) }}" type="text" id="gametype" name="gametype" placeholder="Gametype" required />
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
                        <label for="maxplayers">Max players:</label>
                        <input class="form-control" value="{{ old('maxplayers', $session->max_players) }}" type="number" id="maxplayers" name="maxplayers" placeholder="Maximum aantal spelers" min="1" required />
                    </div>
                    @if ($errors->has('maxplayers'))
                        <span class="help-block">
                            <strong>{{ $errors->first('maxplayers') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="maxplayers">Levels toegestaan:</label>
                        <div class="input-group">
                            <span class="input-group-addon">van level</span>
                            <input type="number" value="{{ old('level_from', $session->level_from) }}" class="form-control" name="level_from" />
                            <span class="input-group-addon">tot en met level</span>
                            <input type="number" value="{{ old('level_to', $session->level_to) }}" class="form-control" name="level_to" />
                        </div>
                    </div>
                    @if ($errors->has('level_from'))
                        <span class="help-block">
                        <strong>{{ $errors->first('level_from') }}</strong>
                    </span>
                    @endif
                    @if ($errors->has('level_to'))
                        <span class="help-block">
                        <strong>{{ $errors->first('level_to') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="round">Ronde (bijvoorbeeld 1/4, of bijvoorbeeld oneshot):</label>
                        <input class="form-control" value="{{ old('round', $session->round) }}" type="text" id="round" name="round" placeholder="Ronde" min="1" required />
                    </div>
                    @if ($errors->has('round'))
                        <span class="help-block">
                            <strong>{{ $errors->first('round') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="preview-input">Prologue:</label>
                        <textarea class="form-control" id="preview-input" name="prologue" placeholder="Prologue">{{ old('prologue', $session->prologue) }}</textarea>
                    </div>
                    @if ($errors->has('prologue'))
                        <span class="help-block">
                            <strong>{{ $errors->first('prologue') }}</strong>
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
                    <input class="btn btn-success" type="submit" value="Edit"/> <a href="{{ route('session', ['id' => $session->id]) }}" class="btn btn-danger">Ga terug</a>
                </div>
            </div>
            <div class="row">
                <p class="col-xs-12 col-md-offset-3 col-md-6">
                    <br /><br />
                    Het is mogelijk om je prologue op te maken met BB Code!<br />
                    <a target="_blank" href="http://www.bbcode.org/reference.php">Lijst met BB Tags</a>
                </p>
            </div>
        </form>
    </div>
@endsection

@section('styles')
    @parent()
    <link rel="stylesheet" href="/scripts/xbbcode/xbbcode.css" />
@endsection

@section('scripts')
    @parent()
    <script type="text/javascript" src="/scripts/xbbcode/xbbcode.js"></script>
    <script type="text/javascript" src="/scripts/preview.js"></script>
@endsection

