<template>
    <m-transition type="slide">
        <layout title="我的评论" :has_menu="false">
            <div v-for="comment in comments" :key="comment.id">
                <mu-sub-header>
                    <router-link :to="{ name: 'mark-detail', params:{id : comment.map.id }}">{{comment.map.title}}</router-link>
                    {{comment.created_at}}
                </mu-sub-header>
                <mu-content-block>
                    <div class="panel-body" v-html="comment.body"></div>
                </mu-content-block>
                <mu-divider/>
            </div>
        </layout>
    </m-transition>

</template>

<script>
    import Layout from "../common/Layout";
    import MTransition from "../base/m-transition";

    export default {
        components: {MTransition, Layout},
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

<style>
    .panel-body img{
        width: 80%;
    }
</style>