
/**
* First we will load all of this project's JavaScript dependencies which
* include Vue and Vue Resource. This gives a great starting point for
* building robust, powerful web applications using Vue and Laravel.
*/

require('./bootstrap');
require('./DropzoneConfig.js');
require('./typed.min.js');

$(document).ready(function () {
    // home page password active on focus.
    $('#password').focus(function () {
        $(this).parent().addClass('active');
    }).blur(function() {
        $(this).parent().removeClass('active');
    });
});


/**
* Next, we will create a fresh Vue application instance and attach it to
* the page. Then, you may begin adding components to this application
* or customize the JavaScript scaffolding to fit your unique needs.
*/

Vue.component("MainPage", require('./components/MainPage.vue'));
Vue.component("Playlist", require('./components/playlist/Playlist.vue'));
Vue.component("PlaylistCookie", require('./components/playlist/PlaylistCookie.vue'));
Vue.component("SlideShow", require('./components/playlist/SlideShow.vue'));
Vue.component("MainFooter", require('./components/Footer.vue'));

const app = new Vue({
    el: '#root',
});
