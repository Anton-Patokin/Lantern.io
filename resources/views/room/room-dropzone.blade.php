<div class="playlist-dropzone-wrapper">
    @include('room.dropzone')
    <div class="password-container">
        {{Form::open(['url' => '/password'])}}
            {{Form::text('title',$room->title,array('hidden'=>'hidden'))}}
            <div class="playlist-password-wrap">
                <label for="password">Passkey:</label>
                <input id="password" type="password" name="password" value="">
                {{Form::submit('Send',['class'=>'btn btn-default'])}}
            </div>

        {{Form::close()}}
        <div class="explanation-password">
            <p>When you fill in the passkey correctly you will gain full access to the playlist.</p>
        </div>
    </div>
</div>
