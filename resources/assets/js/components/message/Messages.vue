<template>
    <layout title="消息记录" :has_menu="true">
        <mu-list>
            <mu-list-item title="这个周末一起吃饭么?">
                <mu-avatar src="/images/avatar1.jpg" slot="leftAvatar"/>
                <span slot="describe">
        <span style="color: rgba(0, 0, 0, .87)">Myron Liu -</span> 周末要来你这里出差，要不要一起吃个饭呀，实在编不下去了,哈哈哈哈哈哈
      </span>
                <mu-icon-menu slot="right" icon="more_vert" tooltip="操作">
                    <mu-menu-item title="回复" />
                    <mu-menu-item title="标记" />
                    <mu-menu-item title="删除" />
                </mu-icon-menu>
            </mu-list-item>
            <mu-divider inset/>
        </mu-list>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        name: "messages"
    }
</script>

<style scoped>

</style>