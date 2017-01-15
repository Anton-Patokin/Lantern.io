<template lang="html">
    <div id="slideShow">
        <div id="quit-slideshow">
            <i class="fa fa-times-circle-o fa-2x" @click="quitSlideShow"></i>
        </div>

        <div v-if="!isFullscreen" id="go-fullscreen">
            <i class="fa fa-arrows-alt fa-2x" @click="goFullScreen"></i>
        </div>

        <div v-if="isFullscreen" id="exit-fullscreen">
            <i class="fa fa-times fa-2x" @click="exitFullScreen"></i>
        </div>

        <div id="prev-file" @click="moveShow('prev', 'user')">
            <i class="fa fa-arrow-circle-o-left fa-2x"></i>
        </div>

        <div id="next-file" @click="moveShow('next', 'user')">
            <i class="fa fa-arrow-circle-o-right fa-2x"></i>
        </div>

        <!-- <div id="enable-disable-autoplay">
            <i class="fa fa-play fa-2x"></i>
        </div> -->

        <ul class="slide-show-list">
            <li class="slide-show-item active">
                <img :src="'/' + currentFile">
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        currentFiles: {
            type: Array
        },
        currentFile: {
            type: String
        },
        duration: {
            type: Number
        },
        autoPlay: {
            type: Boolean
        },
        roomTitle: {
            type: String
        },
        ownerId: {
            type: String
        }
    },
    data () {
        return {
            slideShowItems: "",
            currentItemShowing: 1,
            slideShowLength: 0,
            isFullscreen: false,
            slideShowEl: null,
            autoSliding: null,
            canClick: true,
            apiPrefix: '/api/'
        }
    },
    mounted () {
        // start the component setup.
        this.$nextTick(function () {
            this.init();
        });
    },
    methods: {
        init: function () {
            // initialize the component.
            this.slideShowEl = document.getElementById("slideShow");


            this.initSlideShow(); //setup slideshow first img
            this.bindEventListeners(); // listen for key presses: left, right, esc
            if(this.autoPlay) {
                this.autoMoveShow(this.duration); //init auto scrolling in slideshow
            }
        },
        bindEventListeners: function () {
            var app = this;
            document.onkeydown = function(e) {
                e = e || window.event;
                switch(e.which || e.keyCode) {
                    case 37: // left
                        app.moveShow('prev');
                        break;

                    case 39: // right
                        app.moveShow('next');
                        break;

                    default: return; // exit this handler for other keys
                }
                e.preventDefault();
            };
            $(document).keyup(function (e) {
                if(e.keyCode === 27)
                    app.quitSlideShow();
            });

            window.onbeforeunload = this.quitSlideShow();


        },
        initSlideShow: function () {
            // setup the slideshow first item
            //and the slideshow Length variable so we can work with it later.
            if( this.slideShowItems.length > 0) {
                this.slideShowLength = this.slideShowItems.length;
                this.slideShowItems[0].className = 'slide-show-item active';
            }
            else {
                this.slideShowLength = 0;
            }
        },
        quitSlideShow: function () {
            var data = {
                'roomTitle': this.roomTitle,
                'owner_id': this.ownerId
            };

            this.$http.post(this.apiPrefix + 'bridge/pusher/slideshow/stop', data).then((success_res) => {
                clearInterval(this.autoSliding);
            }, (error_res) => {
                alert("Can't stop the slideshow");
            });

        },
        goFullScreen: function () {
            // go full screen, browser support for: IE, Moz, WebKit, others...
            if(this.slideShowEl.requestFullscreen) {
                this.slideShowEl.requestFullscreen();
                this.isFullscreen = true;
            } else if (this.slideShowEl.webkitRequestFullscreen) {
                this.slideShowEl.webkitRequestFullscreen();
                this.isFullscreen = true;
            } else if (this.slideShowEl.mozRequestFullScreen) {
                this.slideShowEl.mozRequestFullScreen();
                this.isFullscreen = true;
            } else if (this.slideShowEl.msRequestFullscreen) {
                this.slideShowEl.msRequestFullscreen();
                this.isFullscreen = true;
            }
        },
        exitFullScreen: function () {
            // exit full screen, browser support for: IE, Moz, WebKit, others...
            if(document.exitFullscreen){
                document.exitFullscreen();
                this.isFullscreen = false;
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
                this.isFullscreen = false;
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
                this.isFullscreen = false;
            } else if (document.msExitFullscreen) {
                document.msRequestFullscreen();
                this.isFullscreen = false;
            }
        },
        moveShow: function (direction, trigger) {
            // determine direction.
            switch (direction) {
                case "prev":
                    if( this.canClick) {
                        if (this.currentItemShowing > 1)
                            this.currentItemShowing--;
                            var data = {
                                "owner_id": this.ownerId,
                                "roomTitle": this.roomTitle,
                                "url": this.currentFiles[this.currentItemShowing-1].url,
                                "direction": "prev"
                            }

                            this.$http.post(this.apiPrefix + 'bridge/pusher/slideshow/move', data).then((success_res) => {
                                console.log(success_res);
                            }, (error_res) => {
                                console.log(error_res);
                            });

                    }
                    break;
                case "next":
                    if ( this.canClick ) {
                        if (this.currentItemShowing < this.currentFiles.length) {
                            this.currentItemShowing++;
                            // this.slideShowItems[this.currentItemShowing-2].classList.remove('active');
                            // this.slideShowItems[this.currentItemShowing-1].classList.add('active');

                            var data = {
                                "owner_id": this.ownerId,
                                "roomTitle": this.roomTitle,
                                "url": this.currentFiles[this.currentItemShowing-1].url,
                                "direction": "next"
                            }

                            this.$http.post(this.apiPrefix + 'bridge/pusher/slideshow/move', data).then((success_res) => {
                                console.log(success_res);
                            }, (error_res) => {
                                console.log(error_res);
                            });
                        }
                        else {
                            clearInterval(this.autoSliding); // clear interval when end of slideshow was reached.
                        }
                    }
                    break;
                default:
                    console.log('default');
            }

            if(trigger === "user") {
                var app = this;
                this.canClick = false;
                setTimeout(function() {
                    app.canClick = true;
                }, 1000);
            }
        },
        autoMoveShow: function (duration) {
            // auto move slide show function.
            var app = this;
            this.canClick = true;
            clearInterval(this.autoSliding ); // clear interval to make sure it's not running anymore.
            this.autoSliding = setInterval(function () {
                app.moveShow("next", "auto"); // call moveShow next, to go to the next slide.
            }, duration);
        }
    }
}
</script>
