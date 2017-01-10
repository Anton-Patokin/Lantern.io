@extends('layout.app')
@section('content')
    <h1>hallo</h1>
    <div class="container-fluid">
        @if(Session::has('error'))
            <h1>{{ Session::get('error')}}</h1>
            {{Session::forget('error')}}
        @endif

        <h1>show drop zone</h1>
            <br>

        @if(!isset($files))
            {{Form::open(['url' => '/password'])}}
            {{Form::label('password','password',array('class'=>'label-control'))}}{{Form::text('password','',array('class'=>'form-control'))}}
            {{Form::text('title',$room->title,array('hidden'=>'hidden'))}}
            {{Form::submit('Sned',['class'=>'btn btn-default'])}}
            {{Form::close()}}
        @else
            <h1>show files</h1>
            @foreach(documents as $document)
                {{$document}}
            @endforeach
        @endif
    </div>
@endsection