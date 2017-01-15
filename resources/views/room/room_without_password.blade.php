@extends('layout.app')
@section('content')
    @include('hero.playlist-room-hero')
    <div class="playlist-body">
        <playlist-cookie
            :csrf-token="'{{ csrf_token() }}'">
        </playlist-cookie>
        @include('room.playlist-dropzone')
    </div>
@endsection
