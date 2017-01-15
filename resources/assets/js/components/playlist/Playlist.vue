<template lang="html">
    <div class="playlist-wrap">
        <!-- slideshow -->
        <slide-show
            v-if="pusherRes.slideShowActive"
            :room-title="roomTitle"
            :current-files="currentFiles"
            :current-file="pusherRes.url"
            :duration="duration"
            :auto-play="autoplayEnabled"
            :owner-id="ownerID">
        </slide-show>
        <!-- slideshow -->

        <!-- playlist list -->
        <div class="playlist-list">
            <!-- header -->
            <div class="playlist-head">
                <div class="controls" v-if="!showOptions">
                    <a :href="'/download/list/' + roomTitle" class="download">
                        <i class="fa fa-download"></i>
                        download zip
                    </a>
                    <a class="options" @click.prevent="showOptions = !showOptions">
                        <i class="fa fa-cog"></i>
                        playlist options
                    </a>
                    <a class="play" @click.prevent="startNewSlideshow">
                        <i class="fa fa-play"></i>
                        start playlist
                    </a>
                </div>
                <div class="controls option-menu" v-else>
                    <div class="duration tooltip" title="This is my image's tooltip message!">
                        <i class="fa fa-clock-o"></i>
                        <input type="text" name="duration" id="duration" v-model="durationInput">
                        <label for="duration">seconds</label>
                    </div>

                    <div class="autoplay">
                        <input type="checkbox" name="autoplay" id="autoplay" v-model="autoplayEnabled">
                        <label for="autoplay">autoplay</label>
                    </div>

                    <a class="confirm" @click.prevent="confirmOptions">
                        <i class="fa fa-check-circle-o"></i>
                        confirm
                    </a>

                </div>
            </div>
            <!-- header -->

            <!-- list -->
            <div v-if="slideShowNoFiles" class="error-list">
                <p>No files added.</p>
            </div>
            <ul v-else class="list">
                <li class="playlist-item" v-for="file in currentFiles">
                    <div class="thumbnail">
                        <span class="overlay"><i class="fa fa-trash fa-3x" @click="deleteFile(file.title)"></i></span>
                        <img :src="'/' + file.url" alt="">
                    </div>
                </li>
            </ul>
            <!-- list -->
        </div>
        <!-- playlist list -->
    </div>
</template>

<script>
    export default {
        props: {
            roomTitle: {
                type: String
            }
        },
        data() {
            return {
                currentFiles: [],
                fileDetails: {
                    room_title: "",
                    title: ""
                },
                slideShowStarted: false,
                slideShowNoFiles: true,
                durationInput: 5,
                autoplayEnabled: true,
                showOptions: false,
                pusherRes: {
                    slideShowActive: false,
                    url: ""
                },
                canStartSlideShow: true,
                ownerID: ""
            }
        },
        mounted () {
            window.addEventListener('successfull-upload', this.addNewFile);
            window.addEventListener('successfull-delete', this.deleteFileFromList);

            this.makeOwnerId();

            this.openChannelListener();
            this.getAllFiles();


        },
        computed: {
            duration: function () {
                var temp = parseInt(this.durationInput);

                if (temp < 0) {
                    temp * -1;
                }

                return temp * 1000;
            }
        },
        watch: {
            currentFiles: function (val) {
                if (val.length > 0) {
                    this.slideShowNoFiles = false;
                }
                else {
                    this.slideShowNoFiles = true;
                }
            }
        },
        methods: {
            makeOwnerId: function () {
                if( !JSCookie.get('ownerID') ) {
                    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

                    for( var i=0; i < 20; i++ ) {
                        this.ownerID += possible.charAt(Math.floor(Math.random() * possible.length));
                    }

                    JSCookie.set('ownerID', this.ownerID, { expires: 7 });
                }
                else {
                    this.ownerID = JSCookie.get('ownerID');
                }
            },
            openChannelListener: function () {
                var app = this;
                var channel = window.pusher.subscribe(this.roomTitle);

                channel.bind('slide-show-active', (data) => {
                    app.pusherRes.slideShowActive = data.slide_show_started;
                });

                channel.bind('slide-show-move', (data) => {
                    app.pusherRes.url = data.url;
                });

                channel.bind('slide-show-settings-changed', (data) => {
                    app.autoplayEnabled = data.autoplay_enabled;
                    app.durationInput = data.autoplay_timer;
                });

                channel.bind('upload-file', (data) => {
                    console.log(data);
                    if(data.file_updated) {
                        app.getAllFiles();
                    }
                });

                channel.bind('delete-file', (data) => {
                    console.log(data);
                    if(data.file_deleted) {
                        app.getAllFiles();
                    }
                });
            },
            confirmOptions: function () {
                var data = {
                    'roomTitle': this.roomTitle,
                    'autoplay_enabled': this.autoplayEnabled,
                    'autoplay_timer': this.durationInput
                }

                this.$http.post('/bridge/pusher/slideshow/options', data).then((success_res) => {
                    this.showOptions = false;
                }, (error_res) => {
                    this.showOptions = false;
                    alert('Something went wrong! Try again later.');
                })
            },
            addNewFile: function (e) {
                var file = {
                    title: e.detail.filename,
                    url: 'uploads/' + this.roomTitle + '/' + e.detail.filename
                };
                this.currentFiles.push(file);
            },
            deleteFileFromList: function (e) {
                if (e.detail.isDeleted) {
                    this.currentFiles = this.currentFiles.filter(function (el) {
                        if(el.title !== e.detail.file.filename) {
                            return el;
                        }
                    });
                }
            },
            getAllFiles: function () {
                this.$http.get('/api/' + this.roomTitle + '/get-files' ).then((success_res) => {
                    this.currentFiles = success_res.body;
                    // this.pusherRes.url = this.currentFiles[0].url;
                }, (error_res) => {
                    console.log("error");
                });
            },
            deleteFile: function (name) {
                this.fileDetails = {
                    room_title: this.roomTitle,
                    title: name
                }
                this.$http.post('/file/delete', this.fileDetails).then((success_res) => {
                    console.log(success_res);
                    this.getAllFiles()
                }, (error_res) => {
                    console.log(error_res);
                });
            },
            startNewSlideshow: function () {
                var app = this;
                if( this.canStartSlideShow ) {
                    if( this.currentFiles.length > 0 ) {

                        this.pusherRes.url = this.currentFiles[0].url;

                        var data = {
                            'roomTitle': this.roomTitle,
                            'owner_id': this.ownerID
                        };

                        this.$http.post('/bridge/pusher/slideshow/start', data).then((success_res)=> {
                            app.canStartSlideShow = false;
                            setTimeout(() => {
                                app.canStartSlideShow = true;
                            }, 5000);
                        }, (error_res) => {
                            console.log(error_res);
                        });

                    }
                }
            }
        }
    }
</script>
