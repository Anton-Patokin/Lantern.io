<template lang="html">
    <div class="playlist-wrap">
        <!-- slideshow -->
        <slide-show
            v-if="slideShowStarted"
            :current-files="currentFiles"
            :duration="duration"
            :auto-play="autoplayEnabled">
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

                    <a class="confirm" @click.prevent="showOptions = !showOptions">
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
                showOptions: false
            }
        },
        mounted () {
            window.addEventListener('successfull-upload', this.addNewFile);
            window.addEventListener('successfull-delete', this.deleteFileFromList);
            // this.listenToEvent();
            this.getAllFiles();
        },
        computed: {
            duration: function () {
                return parseInt(this.durationInput) * 1000;
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
            // listenToEvent: function () {
            //     console.log('im listening');
            //     console.log(Echo);
            //     window.Echo.channel('test-channel')
            //         .listen('test-event', (e) => {
            //             console.log(e.text);
            //         });
            // },
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
                this.$http.post('/bridge/pusher/slideshow', {'roomTitle': this.roomTitle, 'url': this.currentFiles[0]}).then((success_res)=> {
                    console.log(success_res);
                }, (error_res) => {
                    console.log(error_res);
                });
                if( this.currentFiles.length > 0 ) {
                    this.slideShowStarted = true;
                }
            }
        }
    }
</script>
