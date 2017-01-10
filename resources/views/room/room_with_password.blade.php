@extends('layout.app')
@section('content')

    @include('hero.playlist-room-hero')

    <div class="playlist-body">
        @include('room.room-dropzone')
        <div class="playlist-password-wrap">
            <label for="playlist-password">password:</label>
            <div class="input-wrap">
                <span class="flame"></span>
                <input id="playlist-password" type="password" name="playlist-password" value="">
            </div>
        </div>
        <div class="explanation-password">
            <p></p>
        </div>
    </div>

    {{-- <h1>hallo</h1>
    <div class="container-fluid">
        @if(Session::has('error'))
            <h1>{{ Session::get('error')}}</h1>
            {{Session::forget('error')}}
        @endif
        <h1>show drop zone</h1>
        <br>
        @if(!isset($documents))
            {{Form::open(['url' => '/password'])}}
            {{Form::label('password','password',array('class'=>'label-control'))}}{{Form::text('password','',array('class'=>'form-control'))}}
            {{Form::text('title',$room->title,array('hidden'=>'hidden'))}}
            {{Form::submit('Send',['class'=>'btn btn-default'])}}
            {{Form::close()}}
        @else
            @include('room.show_files')
        @endif
    </div> --}}
@endsection
