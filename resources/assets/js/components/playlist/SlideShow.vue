<template lang="html">

</template>

<script>
export default {

    data () {
        return {

        }
    },
    mounted () {
        var playlistName = window.location.pathName.split('/');
        playlistName = playlistName[playlistName.length - 1];
        Echo.private('playlist' + playlistName)
            .listen('TestEvent', (e) => {
                console.log(e);
            });
    }

}
</script>
