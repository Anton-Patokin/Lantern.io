@extends('layout.app')
@section('content')
    @include('hero.playlist-room-hero')

    <div class="playlist-body">
        @if(!isset($documents))
            @include('room.room-dropzone')
        @else
            @include('room.playlist-dropzone')
        @endif
    </div>
@endsection
