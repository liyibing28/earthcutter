<template>
    <form method="POST" @submit.prevent="login">

        <mu-flexbox orient="vertical" justify="center">
            <mu-flexbox-item>
                <mu-text-field
                        v-model="email" label="邮箱" name="email" hintText="请输入邮箱" type="email"
                        v-validate="{ required: true, email: true }"/><br/>
            </mu-flexbox-item>

            <mu-flexbox-item>
                <mu-text-field
                        v-validate="{ required: true, min:6 }"
                        v-model="password" label="密码" name="password" hintText="请输入密码" type="password"/><br/>
            </mu-flexbox-item>


            <mu-raised-button label="登录" type="submit" class="demo-raised-button" primary/>

        </mu-flexbox>


    </form>
</template>

<script>
    import JWTToken from '../../helpers/jwt'
    export default {
        data(){
            return {
                email: '',
                password: '',
            }
        },
        methods : {
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
                    //this.$router.push({name: 'profile'});
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

<style scoped>

</style>