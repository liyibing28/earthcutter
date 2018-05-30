<template>
    <layout title="我的账户" :has_menu="false">
            <div class="content">
                <mu-card class="card">
                    <mu-list>
                        <mu-list-item title="头像">
                            <mu-avatar :src="avatar" slot="left" :size="30"></mu-avatar>
                            <vue-core-image-upload
                                    :crop="false"
                                    @imageuploaded="imageuploaded"
                                    :max-file-size="5242880"
                                    inputOfFile="img"
                                    url="/api/avatar"
                                    text="修改"
                                    :headers="headers"
                                    slot="right">
                            </vue-core-image-upload>
                        </mu-list-item>


                        <mu-list-item title="用户名" to="/">
                            <mu-icon slot="left" value="star" />
                            <p slot="after">{{user.name}}</p>
                            <mu-icon slot="after" value="chevron_right" />
                        </mu-list-item>

                        <mu-list-item title="注册时间">
                            <mu-icon slot="left" value="access_time" />
                            <p slot="after">2017-10-9</p>
                        </mu-list-item>
                    </mu-list>
                </mu-card>

                <mu-card class="card">
                    <mu-list-item title="邮箱" to="/edit-profile">
                        <mu-icon slot="left" value="email" />
                        <p slot="after">{{user.email}}</p>
                        <mu-icon slot="after" value="chevron_right" />
                    </mu-list-item>
                    <mu-list-item title="密码" @click="alterInfo('password')">
                        <mu-icon slot="left" value="lock" />
                        <p slot="after">修改</p>
                        <mu-icon slot="after" value="chevron_right" />
                    </mu-list-item>
                </mu-card>

                <mu-card class="card">
                    <mu-raised-button label="退出登录" labelClass="exit-btn" @click="logout" fullWidth color="#ff8a80" />
                </mu-card>
            </div>
        <keep-alive>
            <router-view></router-view>
        </keep-alive>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";
    import {mapState} from "vuex";
    import {mapActions} from 'vuex';
    import jwtToken from './../../helpers/jwt'
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
                headers: {Authorization : 'Bearer ' + jwtToken.getToken()},
            }
        },
        created() {
            this.$store.dispatch('setAuthUser');
        },
        computed :{
            ...mapState({
                user: state => state.AuthUser
            }),
            avatar:{
                get(){
                    return this.$store.state.AuthUser.avatar;
                },
                set(value){
                    this.$store.commit({
                        type : types.UPDATE_PROFILE_avatar,
                        value : value,
                    })
                }
            }
        },
        methods : {
            editProfile(){
                this.$router.push({name:'edit-profile'});
            },
            imageuploaded(response) {
            },
            alterInfo(infoName = 'email') {
                this.$router.push({name:'edit-profile'});
            },
            logout(){
                this.$store.dispatch('logoutRequest');
                this.setPopup('退出登录成功！');
            },
            ...mapActions([
                'setPopup',
                'updateAvatar',
            ])
        }

    }
</script>

<style lang="scss" scoped>
    .content {
        width: 100%;
        height: calc(100vh - 96px);
        position: relative;
        //z-index: -1;
    }

    .card {
        width: 95%;
        margin: 10px auto;
        &:first-child,
        &:last-child {
            margin-top: 20px;
        }
    }
    .exit-btn {
        font-size: 14px;
    }
</style>