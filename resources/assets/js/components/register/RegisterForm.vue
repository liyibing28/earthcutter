<template>
    <div>
        <form method="POST" @submit.prevent="register">

            <mu-flexbox orient="vertical" justify="center">
                <mu-flexbox-item>
                    <mu-text-field v-model="this.name" label="用户名" name="name" hintText="请输入用户名" type="text" labelFloat/>
                </mu-flexbox-item>
                <mu-flexbox-item>
                    <mu-text-field v-model="this.email" label="邮箱" name="email" hintText="请输入邮箱" type="email" labelFloat/><br/>
                </mu-flexbox-item>
                <mu-flexbox-item>
                    <mu-text-field v-model="this.password" label="密码" name="password" hintText="请输入密码" type="password" labelFloat/>
                </mu-flexbox-item>

                <mu-flexbox-item>
                    <mu-text-field v-model="this.rePassword" label="确认密码" hintText="请再次输入密码" name="rePassword" type="password" labelFloat/>
                </mu-flexbox-item>

                <mu-raised-button label="注册" type="submit" class="demo-raised-button" primary/>

            </mu-flexbox>
        </form>


    </div>


</template>

<script>
    import { mapActions } from 'vuex';
    import { sendRegisterReq } from './../../api/user'

    export default {
        name: "register-form",
        data(){
            return {
                name: '',
                email: '',
                password: '',
                rePassword: '',
            }
        },
        methods : {
            validateName(){
                if(!this._validate(this.name,'username')){
                    this.setPopup('请输入正确用户名');
                    return false;
                }
            },
            validateEmail(){
                if(!this._validate(this.email)){
                    this.setPopup('请输入正确邮箱地址');
                    return false;
                }
            },
            validatePassword(){
                if(!this._validate(this.password,'password')){
                    this.setPopup('密码不合法，请输入16位以内密码');
                    return false;
                }

                if (this.form.password !== this.form.rePassword) {
                    this.setPopup('两次输入密码不一致');
                    return false;
                }
            },
            register(){
                if(!this.validateName()){
                    return;
                }
                if(!this.validateEmail()){
                    return;
                }
                if(!this.validatePassword()){
                    return;
                }

                let formData = {
                    name: this.name,
                    email: this.email,
                    password: this.password
                };
                axios.post('api/register',formData).then(response => {
                    this.$router.push({name: 'map'});
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
            ...mapActions([
                'setPopup',
            ])
        }
    }
</script>

<style scoped>

</style>