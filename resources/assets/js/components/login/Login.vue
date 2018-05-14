<template>
    <m-transition type="slide">
        <layout :has_menu="true" title="登录">
            <div class="main">
                <ul class="form-list">
                    <li>
                        <mu-text-field v-model="email" label="邮箱" labelFloat />
                    </li>
                    <li>
                        <mu-text-field v-model="password" type="password" label="密码" labelFloat />
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
    import LoginForm from './LoginForm';
    import Layout from "../common/Layout";
    import MTransition from "../base/m-transition";

    const REG = {
        isMobile: /^1(3|4|5|6|7|8)\d{9}$/,
        isUsername: /^[a-z_]\w{0,15}$/,
        isPassword: /^.{1,16}$/
    };

    export default {
        name: "login",
        components : {
            MTransition,
            Layout,
            LoginForm
        },
        data(){
            return {
                email: '',
                password: '',
            }
        },
        methods: {
            login(){
                let formData = {
                    //client_id : '2',
                    //client_secret : 'VhH4ImtwYsxZxgFIT1GPCina0WezYROdTmwnb7ec',
                    //scope : '',
                    //grant_type : 'password',
                    email: this.email,
                    password: this.password
                };
                this.$store.dispatch('loginRequest',formData).then(response => {
                    this.$router.push({name: 'map'});
                }).catch(error => {
                    if(error.response.status === 421){
                        this.bag.add('password','邮箱和密码不符','auth');
                    }

                    console.log();
                })
            }
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
