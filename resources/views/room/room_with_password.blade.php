@extends('layout.app')
@section('content')

    @if(Session::has('error'))
        <h1>{{ Session::get('error')}}</h1>
        {{Session::forget('error')}}
    @endif

    @include('hero.playlist-room-hero')

    <div class="playlist-body">
        @include('room.room-dropzone')
        @if(!isset($documents))
            {{Form::open(['url' => '/password'])}}
                {{Form::text('title',$room->title,array('hidden'=>'hidden'))}}
                <div class="playlist-password-wrap">
                    <label for="password">passkey:</label>
                    <div class="input-wrap">
                        <span class="flame"></span>
                        <input id="password" type="password" name="password" value="">
                    </div>
                    {{Form::submit('Send',['class'=>'btn btn-default'])}}
                </div>

            {{Form::close()}}
            <div class="explanation-password">
                <p></p>
            </div>
        @else
            @include('room.show_files');
        @endif


    </div>
@endsection

@section('javascript')
    <script src="/js/dropzone.js" charset="utf-8"></script>
@endsection
