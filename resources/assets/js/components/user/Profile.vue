<template>
    <layout title="我的主页" :has_menu="true">
        <mu-list>
            <mu-list-item title="头像">

                <vue-core-image-upload
                        :crop="false"
                        @imageuploaded="imageuploaded"
                        :max-file-size="5242880"
                        url="/api/avatar"
                        text="修改"
                        slot="right">
                </vue-core-image-upload>
            </mu-list-item>

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
    import VueCoreImageUpload from 'vue-core-image-upload'
    export default {
        components: {
            Layout,
            VueCoreImageUpload,
        },
        name: "profile",
        data(){
            return{
                src: 'http://img1.vued.vanthink.cn/vued0a233185b6027244f9d43e653227439a.png',
            }
        },
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
            },
            imageuploaded(res) {
                if (res.errcode == 0) {
                    this.src = res.data.src;
                }
            }
        }

    }
</script>

<style scoped>

</style>