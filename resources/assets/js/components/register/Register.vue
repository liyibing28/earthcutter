<template>
    <m-transition type="slide">
        <div class="page-wrapper">
            <layout :has_menu="false" title="注册">
                <div class="main">
                    <div class="form-group">
                        <register-form></register-form>
                    </div>


                </div>
            </layout>
        </div>

    </m-transition>


</template>

<script>
    import RegisterForm from './RegisterForm';
    import Layout from "../common/Layout";
    import MTransition from "../base/m-transition";

    export default {
        name: "register",
        components : {
            MTransition,
            Layout,
            RegisterForm}
    }
</script>

<style lang="scss" scoped>
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
        height: 90vh;
        margin: 10px auto;
        overflow-x: hidden;
        overflow-y: scroll;
    .form-group {
        width: 85%;
        margin: 0 auto;
        li {
            padding: 10px 0;
            display: block;
            div {
                display: inline-block;
            }
        }
    }

    }

</style>