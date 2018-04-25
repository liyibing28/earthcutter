<template>
    <layout title="详情" :has_menu="false">
        <mu-list>
            <mu-list-item v-for="message in messages" :key="message.id" :title="message.from_user_name">
                <router-link :to="{ name: 'message-detail', params:{id : message.from_user_id }}" slot="describe">{{message.body}}</router-link>
            </mu-list-item>
            <mu-divider inset/>
        </mu-list>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        name: "message-detail",
        data(){
            return {
                messages : [],
            }
        },
        mounted(){
            axios.post('/api/message/' + this.$route.params.id).then(response => {
                this.messages = response.data;
                console.log(this.messages);
            });
        }
    }
</script>

<style scoped>

</style>