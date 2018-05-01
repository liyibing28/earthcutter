<template>
    <layout title="消息记录" :has_menu="true">
        <mu-list>
            <mu-list-item v-for="message in messages" :key="message[0].id" :title="message[0].from_user_name" >
                <mu-avatar src="/images/avatar1.jpg" slot="leftAvatar"/>
                <router-link slot="describe" :to="{ name: 'message-detail', params:{id : message[0].from_user_id }}">{{message[0].body}}</router-link>
                <mu-icon-menu slot="right" icon="more_vert" tooltip="操作">
                    <mu-menu-item title="回复" />
                    <mu-menu-item title="删除" />
                </mu-icon-menu>
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
                this.messages = response.data; //两个data是因为后端有分页
                console.log(this.messages);
            });
        },
        methods:{

        }
    }
</script>

<style scoped>

</style>