<template>
    <layout title="收藏" :has_menu="true">
        <div v-for="favorite in favorits" :key="favorite.id">
            <mu-sub-header >
                <router-link :to="{ name: 'mark-detail', params:{id : favorite.map.id }}">{{favorite.map.title}}</router-link>
            </mu-sub-header>
            <mu-sub-header> 创建者：<router-link :to="{ name: 'user-profile', params:{id : favorite.user.id }}">{{favorite.user.name}}</router-link></mu-sub-header>
            <mu-sub-header>创建时间: {{favorite.map.created_at}}</mu-sub-header>
            <mu-divider></mu-divider>
        </div>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        name: "favorite",
        data() {
            return {
                favorits : [],
            }
        },
        mounted(){
            axios.post('/api/show-favorite').then(response =>{
                this.favorits = response.data;
                console.log(this.favorits);
            });
        }

    }
</script>

<style scoped>

</style>