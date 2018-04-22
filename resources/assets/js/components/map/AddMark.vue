<template>
    <layout :has_menu="false" title="添加标记">
        <div>
            <add-mark-form></add-mark-form>
        </div>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {
            Layout},
        name: "add-mark"
    }
</script>

<style scoped>

</style>