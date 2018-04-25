<template>
    <layout title="收藏" :has_menu="true">
        <div v-for="favorite in favorits" :key="favorite.id">
            <mu-sub-header>{{favorite.map.title}}</mu-sub-header>
            <mu-content-block>
                <p>{{favorite.map.body}}</p>
            </mu-content-block>
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