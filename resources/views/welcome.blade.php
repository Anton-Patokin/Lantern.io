@extends('layout.app')
@section('content')
    {{-- <main-page></main-page> --}}

    @include('hero.hero-main')
    <section class="main-page-body">
        <h1 class="head-title-body">How does it work?</h1>
        <div class="explanation-container">
            <div class="explanation-box">
                <h1 class="sub-title-body">Create a playlist</h1>
                <span class="exp-img click-start"></span>
                <p>By clicking start your playlist gets created immediately.</p>
            </div>
            <div class="explanation-box">
                <h1 class="sub-title-body">Share the playlist link</h1>
                <span class="exp-img copy-paste"></span>
                <p>Copy the link and send it to your friends.</p>
            </div>
            <div class="explanation-box">
                <h1 class="sub-title-body">Start dragging and dropping</h1>
                <span class="exp-img drag-drop"></span>
                <p>Just drag and drop your images to the dropzone.</p>
            </div>
        </div>
    </section>

    {{-- <div class="container-fluid">
        <p>uuid generator 36^28 mogelijke combinaties</p>
        <h1>url : {{$url}}</h1>
        @if(Session::has('error'))
            <h1>{{ Session::get('error')}}</h1>
            {{Session::forget('error')}}
        @endif

        <div class="row">
            <div class="col-md-12">
                {{ Form::open(['url' => '/make/room']) }}
                <div class="col-md-4">
                    <div class="form-group">
                        {{Form::label('url je kunt ook url aanpasen dan heb je list met unic naam? je mag het weg laten gaan niks verande
                         ren aan backend','naam van de list',array('class'=>'label-control'))}}
                        {{Form::text('title',old('title')?old('title'):$url,array('class'=>'form-control'))}}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                        @endif
                        {{Form::label('password ','password',array('class'=>'label-control'))}}
                        {{Form::text('password','',array('class'=>'form-control'))}}
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-12">
                    {{Form::submit('Start',array('class'=>'btn btn-default'))}}
                </div>
                {{Form::close()}}
            </div>
        </div>


    </div> --}}
@endsection
