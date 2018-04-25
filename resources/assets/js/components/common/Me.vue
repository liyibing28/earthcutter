<template>
    <layout title="我的" :has_menu="true">
        <mu-list>
            <mu-list-item mu-list-item title="我的账户" to="/profile">
                <mu-icon slot="left" value="inbox"></mu-icon>
            </mu-list-item>
            <mu-divider />
            <mu-list-item title="marker" to="/myMarker">
                <mu-icon slot="left" value="grade"/>
            </mu-list-item>
            <mu-divider />
            <mu-list-item title="我的评论" to="/myComments">
                <mu-icon slot="left" value="rate_review"/>
            </mu-list-item>
            <mu-divider />
            <mu-list-item title="设置">
                <mu-icon slot="left" value="settings"/>
            </mu-list-item>
            <mu-divider />
        </mu-list>

    </layout>
</template>

<script>
    import {mapState} from "vuex";
    import Layout from "./Layout";

    export default {
        components: {
            Layout},
        name: "me",
        computed :{
            ...mapState({
                user: state => state.AuthUser
            })
        },
    }
</script>

<style scoped>

</style>