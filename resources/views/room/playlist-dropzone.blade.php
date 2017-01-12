<div class="playlist-dropzone-wrapper">
    @include('room.dropzone')
    <playlist
        :room-title="'{{ $room->title }}'">
    </playlist>
</div>
