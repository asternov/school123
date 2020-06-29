<template>
    <i :class="'fa fa-' + icon" aria-hidden="true"></i>
</template>

<script>
    export default {
        name: 'fa',
        props: ['icon'],
        data() {
            return {
            };
        },
    }
</script>
