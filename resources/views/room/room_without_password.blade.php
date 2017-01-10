@extends('layout.app')
@section('content')
    <div class="container-fluid">
        <h1>evry body has access</h1>
    </div>

    {{Form::open(['url' => '/file/upload', 'files' => true])}}
    {{Form::file('file')}}
    {{Form::text('title',$room->title,array('hidden'=>'hidden'))}}
    {{Form::submit('Send',['class'=>'btn btn-default'])}}
    {{Form::close()}}

    @include('room.show_files')
@endsection