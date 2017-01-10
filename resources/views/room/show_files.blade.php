<h1>show files</h1>
@foreach($documents as $document)
    <div class="col-md-12">
        {{$document->title}}<div>
            {{Form::open(['url' => '/file/delete'])}}
            {{Form::text('document_title',$document->title,array('hidden'=>'hidden'))}}
            {{Form::text('room_title',$room->title,array('hidden'=>'hidden'))}}
            {{Form::submit('delete')}}
            {{Form::close()}}

    </div>

@endforeach