@extends('layout.app')
@section('content')
    @include('hero.playlist-room-hero')
    <div class="playlist-body">
        @include('room.playlist-dropzone')
    </div>
@endsection
