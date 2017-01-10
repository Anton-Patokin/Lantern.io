<template lang="html">
    <div id="page-content">
        <playlist></playlist>
        <playlist-dropzone></playlist-dropzone>
    </div>
</template>

<script>
    import Playlist from '../components/Playlist.vue';
    import PlaylistDropzone from '../components/playlist/PlaylistDropzone.vue';

    export default {
        components: {
            'playlist': Playlist,
            'playlist-dropzone': PlaylistDropzone
        }
    }
</script>

<style lang="css">
</style>
