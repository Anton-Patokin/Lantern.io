<template lang="html">
    <div id="slideShow">
        <div v-if="!isFullscreen" id="go-fullscreen" @click="goFullScreen">
            <i class="fa fa-arrows-alt fa-2x"></i>
        </div>

        <div v-if="isFullscreen" id="exit-fullscreen" @click="exitFullScreen">
            <i class="fa fa-times fa-2x"></i>
        </div>

        <div id="prev-file" @click="moveShow('prev', 'user')">
            <i class="fa fa-arrow-circle-o-left fa-2x"></i>
        </div>

        <div id="next-file" @click="moveShow('next', 'user')">
            <i class="fa fa-arrow-circle-o-right fa-2x"></i>
        </div>

        <div id="enable-disable-autoplay">
            <i class="fa fa-play fa-2x"></i>
        </div>

        <ul class="slide-show-list">
            <li class="slide-show-item" v-for="file in currentFiles">
                <img :src="'/' + file.url">
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        currentFiles: {
            type: Array
        }
    },
    data () {
        return {
            slideShowItems: "",
            currentItemShowing: 1,
            slideShowLength: 0,
            isFullscreen: false
        }
    },
    mounted () {
        this.$nextTick(function () {
            this.init();
        });
    },
    methods: {
        init: function () {
            this.slideShowItems = document.querySelectorAll('.slide-show-item');
            this.slideShowLength = this.slideShowItems.length;
            this.slideShowItems[0].className = 'slide-show-item active';
        },
        goFullScreen: function () {
            if(document.getElementById("slideShow").requestFullscreen) {
                document.getElementById("slideShow").requestFullscreen();
                this.isFullscreen = true;
            } else if (document.getElementById("slideShow").webkitRequestFullscreen) {
                document.getElementById("slideShow").webkitRequestFullscreen();
                this.isFullscreen = true;
            } else if (document.getElementById("slideShow").mozRequestFullScreen) {
                document.getElementById("slideShow").mozRequestFullScreen();
                this.isFullscreen = true;
            }
        },
        exitFullscreen: function () {
            if(document.exitFullscreen){
                document.requestFullscreen();
                this.isFullscreen = false;
            } else if (document.webkitRequestFullscreen) {
                document.webkitRequestFullscreen();
                this.isFullscreen = false;
            } else if (document.mozRequestFullScreen) {
                document.mozRequestFullScreen();
                this.isFullscreen = false;
            }
        },
        moveShow: function (direction, trigger) {
            switch (direction) {
                case "prev":
                    if (this.currentItemShowing > 1)
                        this.currentItemShowing--;
                        this.slideShowItems[this.currentItemShowing].classList.remove('active');
                        this.slideShowItems[this.currentItemShowing-1].classList.add('active');
                    break;
                case "next":
                    if (this.currentItemShowing < this.slideShowLength)
                        this.currentItemShowing++;
                        this.slideShowItems[this.currentItemShowing-2].classList.remove('active');
                        this.slideShowItems[this.currentItemShowing-1].classList.add('active');
                    break;
                default:
                    console.log('default');
            }
        },
        autoMoveShow: function () {
            this.moveShow("next");
        }
    }
}
</script>
