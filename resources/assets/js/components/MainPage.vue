<template lang="html">
    <div id="page-content">
        <hero></hero>
        <main-body></main-body>
    </div>
</template>

<script>
    import Hero from '../components/Hero.vue';
    import MainBody from '../components/MainBody.vue';

    export default {
        data () {
            return {

            }
        },
        mounted () {

        },
        components: {
            'hero': Hero,
            'main-body': MainBody
        }
    }
</script>

<style lang="css">
</style>
