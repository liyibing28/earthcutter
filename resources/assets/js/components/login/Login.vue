<template>
    <m-transition type="slide">
        <layout :has_menu="true" title="登录">
            <div class="main">
                <ul class="form-list">
                    <li>
                        <mu-text-field v-model="email" label="邮箱"/>
                    </li>
                    <li>
                        <mu-text-field v-model="password" type="password" label="密码"/>
                    </li>
                    <li>
                        <router-link to="/register" tag="a" class="option">注册账号</router-link>
                        <router-link to="" tag="a" class="option">忘记密码</router-link>
                        <mu-raised-button label="登录" @click="login" primary/>
                    </li>
                </ul>
            </div>
        </layout>
    </m-transition>

</template>

<script>
    import Layout from "../common/Layout";
    import MTransition from "../base/m-transition";
    import { mapActions } from 'vuex';

    export default {
        name: "login",
        components : {
            MTransition,
            Layout,
        },
        data(){
            return {
                email: '',
                password: '',
            }
        },
        methods: {
            async login(){
                if(!this._validate(this.email)){
                    this.setPopup('邮箱地址不合法，请输入合法邮箱');
                    return false;
                }

                if(!this._validate(this.password,'password')){
                    this.setPopup('密码不合法，请输入16位以内密码');
                    return false;
                }

                let formData = {
                    email: this.email,
                    password: this.password
                };
                this.$store.dispatch('loginRequest',formData).then(response => {
                    this.setPopup('登录成功！');
                    this.$router.push({name: 'map'});
                }).catch(error => {
                    if(error.response.status === 421){
                        this.setPopup('邮箱或密码不符');
                    }

                })
            },
            // 校验输入
            _validate(str, type = 'email') {
                const reg = {
                    // 11位手机号
                    mobile: /^1(3|4|5|6|7|8)\d{9}$/,
                    // 4位验证码
                    vcode: /^\d{4}$/,
                    //邮箱
                    email: /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/,
                    // 16位以内用户名
                    username: /^[a-zA-Z_]\w{0,15}$/,
                    // 16位以内密码
                    password: /^.{1,16}$/
                };
                return reg[type].test(str);
            },
            ...mapActions([
                'setPopup',
            ])

        }
    }
</script>

<style scoped lang="scss">
    @import './../../../sass/variables';
    .login_box {
        padding: 20px;
    }
    .page-wrapper {
        position: fixed;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: 2017;
        background-color: #fff;
    }

    .main {
         width: 100%;
         height: 75vh;
         margin-top: 25px;
     }

    .form-list {
        width: 80%;
        margin: 0 auto;
        li {
            display: block;
            &:last-child {
                float: right;
                padding-top: 10px;
                .option {
                    margin-right: 20px;
                    font-size: 14px;
                    color: $color-theme;
                }
                &::after {
                    content: '';
                    clear: both;
                }
            }
        }
    }

</style>
