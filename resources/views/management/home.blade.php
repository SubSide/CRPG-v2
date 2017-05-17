@extends('base')

@section('content')
    <a class="btn btn-default" href="{{ route('admin.users') }}">User management</a><br /><br />
    <a class="btn btn-default" href="{{ route('admin.announcements') }}">Announcement management</a><br />
@endsection