<div>
    <div id="error"></div>
    {{ Form::open(array('url' => 'file/upload', 'method' => 'post', 'class' => 'dropzone','id'=>'realDropzone')) }}
        {{ Form::text('title', $room->title, array('hidden'=>'hidden')) }}

        <div class="dz-message">
            <div class="title-dropzone">
                <span class="flame"></span>
                <h1>Drop it like it's hot!</h1>
            </div>
            <span id="photoCounter"></span>
            <br />
            <span class="note">(Your images are uploaded as soon as you drop them. Max. size 8MB)</span>
        </div>

        {{-- if user has js disabled --}}
        <div class="fallback">
            <input name="file" type="file" multiple/>
        </div>

        <div class="dropzone-previews" id="dropzonePreview"></div>

        {{-- send hiddenfield token with upload --}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrf-token">
    {{ Form::close() }}
</div>
