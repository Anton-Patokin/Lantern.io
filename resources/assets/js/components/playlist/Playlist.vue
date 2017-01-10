<template lang="html">
    <div class="playlist-list">
        <button @click="" type="button" name="button">download</button>
        <div class="list">
            <ul>
                <li v-for="file in currentFiles">
                    {{ file.title }} <button @click="deleteFile(file.title)" type="button" name="button">delete</button>
                </li>
            </ul>
        </div>
        <div class="controls">

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentFiles: [],
                roomTitle: "",
                fileDetails: {
                    room_title: "",
                    title: ""
                }
            }
        },
        mounted () {
            this.roomTitle = window.location.pathname.split('/');
            this.roomTitle = this.roomTitle[1];

            this.getAllFiles();
        },
        methods: {
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
            downloadPlaylist: function () {
                this.$http.get('/download/list/'+this.roomTitle).then((success_res) => {
                    
                }, (error_res) => {

                });
            }
        }
    }
</script>
