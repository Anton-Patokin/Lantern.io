<template lang="html">
    <div class="hero-wrap">
        <div class="hero-container">
            <div class="logo-wrap">
                <img src="/img/laternio_logo.png" alt="logo">
            </div>
            <div class="slogan-wrap">
                <h1 class="head-title-hero">The magic lantern of the <span class="text-orange">21st century</span>.</h1>
                <h2 class="sub-title-hero">An <span class="text-orange">easy way of sharing</span> pictures and graphic content with each other.</h2>
            </div>
            <div class="playlist-form-container">
                <h1 class="playlist-con-title">Create a playlist and start sharing</h1>
                <form class="playlist-form">
                    <div class="link-wrap">
                        <span class="flame"></span>
                        <input id="playlist-link" type="text" name="playlist-link" value="" autofocus>
                    </div>
                    <div class="password-wrap">
                        <label for="password">password:</label>
                        <input id="password" type="password" name="password" value="" placeholder="optional">
                        <span class="disclaimer-star">*</span>
                    </div>
                    <div class="disclaimer">
                        <span class="disclaimer-star">*</span>
                        <p>creating a playlist with a password gives only YOU delete rights,<br> if you don’t put in a password everyone can delete files.</p>
                    </div>
                    <div class="start-button-wrap">
                        <button class="btn btn-default" id="start-new-list" type="submit" name="start-new-list">start</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
