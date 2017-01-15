<div class="dropzone-container">
    {{ Form::open(array('url' => '/api/file/upload',
    'method' => 'post',
    'class' => 'dropzone needsclick dz-clickable',
    'id'=>'realDropzone'))
    }}
    {{ Form::text('title', $room->title, array('hidden'=>'hidden')) }}

    <div class="dz-message">
        <div class="title-dropzone">
            <span class="flame"></span>
            <h1>Drop it like it's hot!</h1>
        </div>
        <br />
        <span class="note">(Drop your images <span class="text-">here</span>. They are uploaded as soon as you drop them. Max. size 8MB)</span>
    </div>

    {{-- if user has js disabled --}}
    <div class="fallback">
        <input name="file" type="file" multiple/>
    </div>
    {{ Form::close() }}
</div>
