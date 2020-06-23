<template>
    <div id="app">
        <div class="border overflow-hidden m-4" style="">
            <iframe style="border: 0px none; margin-left: 0px; height: 500px; margin-top: -60px; width: 100%;"
                    :src="'https://www.youtube.com/embed/' + id + '?autoplay=0&amp;enablejsapi=1&amp;rel=0;modestbranding=1&amp;showsearch=0'" scrolling="yes">
            </iframe></div>
    </div>
</template>

<script>
    export default {
        name: 'youtube',
        props: ['id'],
        data() {
            return {
            };
        },
    }
</script>
