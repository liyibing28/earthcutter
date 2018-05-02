<template>
    <layout title="关于" :has_menu="false">
        <mu-sub-header>earthcutter</mu-sub-header>
        <mu-content-block>
            杭州电子科技大学<br/>
            计算机学院<br/>
            14051123李宜柄的本科毕业设计<br/>
            基于 laravel+vue+muse-ui 的移动端spa应用
        </mu-content-block>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
