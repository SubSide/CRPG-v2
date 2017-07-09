@extends('base')

@section('content')
    <div>
        <p><a href="{{ route('admin.announcements') }}">Terug naar de announcement lijst</a></p>
        <form method="POST" action="{{ route('announcement.edit', ['id' => $announcement->id]) }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <h2 class="text-bold"><strong>Edit announcement "{{ $announcement->title }}"</strong></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="title">Titel:</label>
                        <input class="form-control" type="text" id="title" value="{{ old('title', $announcement->title) }}" name="title" placeholder="Titel" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="preview-input">Mededeling:</label>
                        <textarea class="form-control" id="preview-input" name="content" placeholder="Mededeling">{{ old('content', $announcement->content) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6" id="preview">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-offset-3 col-md-4">
                    <br/>
                    <input class="btn btn-success" type="submit" value="Edit"/>
                </div>
            </div>
            <div class="row">
                <p class="col-xs-12 col-md-offset-3 col-md-6">
                    <br /><br />
                    Het is mogelijk om je bericht op te maken met BB Code!<br />
                    <a target="_blank" href="http://www.bbcode.org/reference.php">Lijst met BB Tags</a>
                </p>
            </div>
        </form>
    </div>
@endsection

@section('stylesheets')
    @parent
    <link rel="stylesheet" href="{{ asset('scripts/xbbcode/xbbcode.css') }}" />
@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ asset('scripts/xbbcode/xbbcode.js') }}"></script>
    <script type="text/javascript" src="{{ asset('scripts/preview.js') }}"></script>
@endsection