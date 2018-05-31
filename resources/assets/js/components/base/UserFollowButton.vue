<template>
    <button
        class="btn btn-default"
        v-bind:class="{'btn-success' : followed }"
        v-text="text"
        v-on:click="follow"
    >

    </button>
</template>

<script>
    export default {
        name: "UserFollowButton"
    }
</script>

<style scoped>

</style>