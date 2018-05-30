<template>
    <layout title="消息记录" :has_menu="true">
        <mu-list>
            <mu-list-item v-for="message in messages" :key="message[0].id" :title="message[0].with_friend.name" >
                <mu-avatar :src="message[0].with_friend.avatar" slot="leftAvatar"/>
                <router-link slot="describe" :to="{ name: 'message-detail', params:{id : message[0].friend }}">{{message[0].title}}  ({{message.length}})</router-link>
                <mu-icon slot="right" value="chevron_right"></mu-icon>
            </mu-list-item>
            <mu-divider inset/>
        </mu-list>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        name: "messages",
        data(){
            return {
               messages : [],
            }
        },
        mounted(){
            axios.post('/api/message').then(response => {
                this.messages = response.data;
                console.log(this.messages);
            });
        },
        methods:{
            deleteByUser(){
                console.log(1);
                axios.post('/api/message/delete/'+ messages[0][0].friend).then(response=>{
                    console.log(response.data);
                });
            }
        }
    }
</script>

<style scoped>

</style>