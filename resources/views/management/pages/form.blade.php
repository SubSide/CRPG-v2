@extends('base')

@section('content')
    <div>
        <p><a href="{{ route('admin.pages') }}">Terug naar de pagina lijst</a></p>
        <form method="POST" action="{{ route('admin.pages.edit', ['id' => $page->id]) }}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <h2 class="text-bold"><strong>Announcement</strong></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="title">Titel:</label>
                        <input class="form-control" type="text" id="title" value="{{ old('title', $page->title) }}" name="title" placeholder="Titel" required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <input type="checkbox" id="logged_in" name="logged_in" {{ old('logged_in', $page->logged_in)?'checked':'' }} />
                        <label for="logged_in">Check dit als de gebruiker ingelogd moet zijn</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="type">Pagina type:</label>
                        <select class="form-control" id="type" name="type">
                            <option value="{{ App\Models\PageType::PAGE }}" {{ (old('type', $page->type)==\App\Models\PageType::PAGE)?"selected":"" }}>Losse pagina</option>
                            <option value="{{ App\Models\PageType::RESOURCE }}" {{ (old('type', $page->type)==\App\Models\PageType::RESOURCE)?"selected":"" }}>Resource</option>
                        </select>
                    </div>
                    @if ($errors->has('type'))
                        <span class="help-block">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-offset-3 col-md-6">
                    <div class="form-group">
                        <label for="preview-input">Content:</label>
                        <textarea class="form-control" id="preview-input" name="content" placeholder="Mededeling">{{ old('content', $page->content) }}</textarea>
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
                    <input class="btn btn-success" type="submit" value="{{ $page->id == null ? 'Create' : 'Edit' }}"/>
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

@section('styles')
    @parent()
    <link rel="stylesheet" href="/scripts/xbbcode/xbbcode.css" />
@endsection

@section('scripts')
    @parent()
    <script type="text/javascript" src="/scripts/xbbcode/xbbcode.js"></script>
    <script type="text/javascript" src="/scripts/preview.js"></script>
@endsection
