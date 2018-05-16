<template>
    <form method="POST" @submit.prevent="login">
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
                <mu-raised-button label="登录" type="submit" primary/>
            </li>
        </ul>
    </form>

</template>

<script>
    import JWTToken from '../../helpers/jwt'
    import { mapActions } from 'vuex';

    export default {
        data(){
            return {
                email: '',
                password: '',
            }
        },
        methods : {
            validateEmail(){
                if(!this._validate(this.email,'email')){
                    this.setPopup('请输入正确邮箱地址');
                    return false;
                }
            },
            validatePassword(){
                if(!this._validate(this.password,'password')){
                    this.setPopup('密码不合法，请输入16位以内密码');
                    return false;
                }
            },
            login(){
                if(!this.validateEmail()){
                    return;
                }
                if(!this.validatePassword()){
                    return;
                }

                    let formData = {
                        email: this.email,
                        password: this.password
                    };
                    this.$store.dispatch('loginRequest',formData).then(response => {
                        this.$router.push({name: 'map'});
                    }).catch(error => {
                        if(error.response.status === false){
                            this.setPopup('邮箱或密码不符');
                        }
                    })
            },
            _validate(str, type = 'email') {
                const reg = {
                    //邮箱
                    email: /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/,
                    // 11位手机号
                    mobile: /^1(3|4|5|6|7|8)\d{9}$/,
                    // 16位以内用户名
                    username: /^[a-zA-Z_]\w{0,15}$/,
                    //16位以内密码
                    password: /^.{1,16}$/
                };
                return reg[type].test(str);
            },
            ...mapActions(['setPopup'])
        }

    }
</script>

<style lang="scss" scoped>
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
        //color: $color-theme;
    }
    &::after {
         content: '';
         clear: both;
     }
    }
    }
    }
</style>