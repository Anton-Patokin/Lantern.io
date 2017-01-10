@extends('layout.app')
@section('content')

    @include('hero.playlist-room-hero')

    <div class="playlist-body">
        @include('room.room-dropzone')
    </div>

    {{-- <div class="container-fluid">
        <h1>evry body has access</h1>
    </div>

    {{Form::open(['url' => '/file/upload', 'files' => true])}}
    {{Form::file('file')}}
    {{Form::text('title',$room->title,array('hidden'=>'hidden'))}}
    {{Form::submit('Send',['class'=>'btn btn-default'])}}

    {{Form::close()}}

    <a href="{{url('/download/list/'.$room->title)}}">zip</a>
    @include('room.show_files') --}}
@endsection
