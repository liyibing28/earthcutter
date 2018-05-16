<template>
    <m-transition type="slide">
        <layout title="忘记密码" :has_menu="false">

        </layout>
    </m-transition>
</template>

<script>
    import MTransition from "../base/m-transition";
    import Layout from "../common/Layout";
    export default {
        name: "reset",
        components: {Layout, MTransition}
    }
</script>

<style scoped>

</style>