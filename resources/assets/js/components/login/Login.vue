<template>
    <layout :has_menu="true" title="登录">
        <div class="login_box">
            <div class="login">
                <login-form></login-form>
            </div>
        </div>
    </layout>
</template>

<script>
    import LoginForm from './LoginForm';
    import Layout from "../common/Layout";

    export default {
        name: "login",
        components : {
            Layout,
            LoginForm}
    }
</script>

<style scoped lang="less">
    .login_box {
        padding: 20px;
    }

</style>
