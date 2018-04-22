<template>
    <layout title="我的主页" :has_menu="true">
        <mu-list>
            <mu-list-item :title="user.name">
                <mu-icon value="people" slot="left" color="pinkA200"/>
            </mu-list-item>
            <mu-list-item :title="user.email">
                <mu-icon value="email" slot="left" color="pinkA200"/>
            </mu-list-item>
            <mu-raised-button @click="editProfile" primary>修改</mu-raised-button>
        </mu-list>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";
    import {mapState} from "vuex";
    export default {
        components: {Layout},
        name: "profile",
        created() {
            this.$store.dispatch('setAuthUser');
        },
        computed :{
            ...mapState({
                user: state => state.AuthUser
            })
        },
        methods : {
            editProfile(){
                this.$router.push({name:'edit-profile'});
            }
        }

    }
</script>

<style scoped>

</style>