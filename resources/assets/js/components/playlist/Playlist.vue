<template lang="html">
    <div class="playlist-wrap">
        <slide-show
            v-if="slideShowStarted"
            :current-files="currentFiles">
        </slide-show>
        <div class="playlist-list">
            <div class="playlist-head">
                <div class="controls">
                    <a :href="'/download/list/' + roomTitle" class="download">
                        <i class="fa fa-download"></i>
                        download zip
                    </a>
                    <a class="play" @click.prevent="startNewSlideshow">
                        <i class="fa fa-play"></i>
                        start playlist
                    </a>
                </div>
            </div>
            <ul class="list">
                <li class="playlist-item" v-for="file in currentFiles">
                    <div class="thumbnail">
                        <span class="overlay" @click="deleteFile(file.title)"><i class="fa fa-trash fa-3x"></i></span>
                        <img :src="'/' + file.url" alt="">
                    </div>
                </li>
            </ul>
        </div>
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
                slideShowStarted: false
            }
        },
        mounted () {
            window.addEventListener('successfull-upload', this.addNewFile);
            window.addEventListener('successfull-delete', this.deleteFileFromList);

            // this.nextFrame();
            this.getAllFiles();
        },
        methods: {
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
            // nextFrame: function () {
            //     this.$http.post('/next/page', {title: this.roomTitle}).then((success) => {
            //         console.log(success);
            //     }, (error) => {
            //         console.log(error);
            //     });
            // },
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
                this.slideShowStarted = true;
            }
        }
    }
</script>
