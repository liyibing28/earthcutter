<template>
    <layout title="修改资料" :has_menu="false">
        <div>
            <edit-profile-form></edit-profile-form>
        </div>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";
    import EditProfileForm from "./EditProfileForm";

    export default {
        components: {
            EditProfileForm,
            Layout},
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
