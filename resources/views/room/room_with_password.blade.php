@extends('layout.app')
@section('content')
    <div class="container-fluid">
        @if(Session::has('error'))
            <h1>{{ Session::get('error')}}</h1>
            {{Session::forget('error')}}
        @endif
            {{request()->cookie('acceptCookie')}}
            {{Form::open(['url' => '/password'])}}
            {{Form::label('password','password',array('class'=>'label-control'))}}{{Form::text('password','',array('class'=>'form-control'))}}
            {{Form::text('title',$room->title,array('hidden'=>'hidden'))}}
            {{Form::submit('Sned',['class'=>'btn btn-default'])}}
            {{Form::close()}}
    </div>
@endsection