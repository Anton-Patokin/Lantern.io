<template lang="html">
    <div class="playlist-cookie" v-if="!isCookieSet">
        <div class="playlist-cookie-modal">
            <span class="close-icon"><i class="fa fa-times"></i></span>
            <h1><span class="lantern">lantern.<span class="text-orange">io</span></span> playlists</h1>
            <h2>Overview of all the features:</h2>
            <ul>
                <li>
                    <h3>Private playlists</h3>
                    <ul>
                        <li>Playlist is password protected</li>
                        <li>Start playlist slideshow only with full access to the playlist</li>
                        <li>Every one with the link can drop files in the list</li>
                        <li>Only the owner can modify the list</li>
                    </ul>
                </li>
                <li>
                    <h3>Public playlist</h3>
                    <ul>
                        <li>Realtime playlist updates</li>
                        <li>Realtime playlist slideshow: everyone's screen in the in the playlist is synced</li>
                        <li>Person that started slideshow is the only one in control of the slideshow</li>
                        <li>Different options: autoplay enabled/disabled, autoplay timer, manual sliding through slideshow.</li>
                    </ul>
                </li>
            </ul>
            <div class="button-cookie-modal">
                <button type="button" name="gotit" id="gotit" class="btn btn-default" @click="setCookie">Got it!</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            csrfToken: {
                type: String
            }
        },
        data () {
            return {
                isCookieSet: false
            }
        },
        mounted () {
            this.init();
        },
        methods: {
            init: function () {
                this.checkIfCookieSet();
            },
            checkIfCookieSet: function () {
                if( JSCookie.get('informationPlaylist') ) {
                    this.isCookieSet = true;
                }
            },
            setCookie: function () {
                if( !JSCookie.get('informationPlaylist') ) {
                    JSCookie.set('informationPlaylist', this.csrfToken);
                    this.isCookieSet = true;
                }
            }
        }
    }
</script>

<style lang="css">

</style>
