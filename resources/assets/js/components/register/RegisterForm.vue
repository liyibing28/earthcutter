<template>
    <form method="POST" @submit.prevent="register">

        <mu-flexbox orient="vertical" justify="center">
            <mu-flexbox-item>
                <mu-text-field
                        v-validate="{ required: true, min: 4 }"
                        v-model="name" label="用户名" name="name" hintText="请输入用户名" type="text" labelFloat/><br/>
            </mu-flexbox-item>
            <mu-flexbox-item>
                <mu-text-field
                        v-model="email" label="邮箱" name="email" hintText="请输入邮箱" type="email"
                        v-validate="{ required: true, email: true }"
                        labelFloat/><br/>
            </mu-flexbox-item>

            <mu-flexbox-item>
                <mu-text-field
                        v-validate="{ required: true, min:6 }"
                        v-model="password" label="密码" name="password" hintText="请输入密码" type="password" labelFloat/><br/>
            </mu-flexbox-item>

            <mu-flexbox-item>
                <mu-text-field
                        v-validate="{ required: true, min:6, confirmed: 'password'}"
                        label="确认密码" hintText="请再次输入密码" name="password_confirmation" type="password" labelFloat/><br/>
            </mu-flexbox-item>

                <mu-raised-button label="注册" type="submit" class="demo-raised-button" primary/>

        </mu-flexbox>


    </form>
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
                    //console.log('success');
                    this.$router.push({name: 'confirm'})
                })
            }
        }
    }
</script>

<style scoped>

</style>