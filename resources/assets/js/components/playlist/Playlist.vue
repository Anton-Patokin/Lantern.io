<template lang="html">
    <div class="playlist-list">
        <div class="list">
            <ul>
                <li v-for="file in currentFiles">{{ file.title }}</li>
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
                roomTitle: ""
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
            }
        }
    }
</script>
