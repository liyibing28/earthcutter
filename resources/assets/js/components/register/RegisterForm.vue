<template>
    <div>
        <form method="POST" @submit.prevent="register">

            <mu-flexbox orient="vertical" justify="center">
                <mu-flexbox-item>
                    <mu-text-field v-model="name" label="用户名" name="name" hintText="请输入用户名" type="text" labelFloat/>
                </mu-flexbox-item>
                <mu-flexbox-item>
                    <mu-text-field v-model="email" label="邮箱" name="email" hintText="请输入邮箱" type="email" labelFloat/><br/>
                </mu-flexbox-item>
                <mu-flexbox-item>
                    <mu-text-field v-model="password" label="密码" name="password" hintText="请输入密码" type="password" labelFloat/>
                </mu-flexbox-item>

                <mu-flexbox-item>
                    <mu-text-field label="确认密码" hintText="请再次输入密码" name="password_confirmation" type="password" labelFloat/>
                </mu-flexbox-item>

                <mu-raised-button label="注册" type="submit" class="demo-raised-button" primary/>

            </mu-flexbox>
        </form>
        <mu-toast v-if="toast" message="请前往邮箱验证用户" @close="hideToast"/>


    </div>


</template>

<script>
    export default {
        name: "register-form",
        data(){
            return {
                name: '',
                email: '',
                password: '',
            }
        },
        methods : {
            register(){
                let formData = {
                    name: this.name,
                    email: this.email,
                    password: this.password
                }
                axios.post('api/register',formData).then(response => {
                    this.showToast();
                    this.$router.push({name: 'map'});
                })
            },
            showToast () {
                this.toast = true;
                if (this.toastTimer) clearTimeout(this.toastTimer);
                this.toastTimer = setTimeout(() => { this.toast = false }, 2000)
            },
            hideToast () {
                this.toast = false
                if (this.toastTimer) clearTimeout(this.toastTimer)
            }
        }
    }
</script>

<style scoped>

</style>