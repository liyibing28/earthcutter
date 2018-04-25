<template>
    <layout title="我的标记" :has_menu="false">

    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        name: "my-markers",
        data(){
            return{
                markers : [],
            }
        },
        mounted(){
            axios.post('/api/my-markers').then(response =>{
                this.markers = response.data;
                console.log(this.markers);
            });
        }
    }
</script>

<style scoped>

</style>