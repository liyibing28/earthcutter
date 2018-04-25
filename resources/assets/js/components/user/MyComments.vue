<template>
    <layout title="我的评论" :has_menu="false">

    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        name: "my-comments",
        data(){
            return{
                comments : [],
            }
        },
        mounted(){
            axios.post('/api/my-comments').then(response =>{
                this.comments = response.data;
                console.log(this.comments);
            });
        }
    }
</script>

<style scoped>

</style>