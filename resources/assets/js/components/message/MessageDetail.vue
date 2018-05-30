<template>
    <layout title="详情" :has_menu="false">
        <mu-list>
            <div v-for="message in messages" :key="message.id">
                <mu-sub-header>from: {{message.from_user_name}}</mu-sub-header>
                <mu-list-item :title="message.body" :describeText="message.created_at">
                </mu-list-item>
                <mu-divider/>
            </div>

        </mu-list>

        <mu-float-button icon="edit" class="float-button" @click="open"/>

        <mu-dialog :open="dialog"  @close="close">
            <mu-text-field v-model="title" hintText="subject: required" name="title" :fullWidth="true" disabled/>
            <mu-text-field v-model="body" hintText="content" name="body" :fullWidth="true" multiLine :rows="3" :rowsMax="6"/>
            <mu-flat-button slot="actions" @click="close" primary label="取消"/>
            <mu-flat-button slot="actions" primary @click="sendMessage" label="发送"/>
        </mu-dialog>

    </layout>
</template>

<script>
    import Layout from "../common/Layout";
    import {mapActions} from 'vuex';

    export default {
        components: { Layout},
        name: "message-detail",
        data(){
            return {
                dialog: false,
                messages : [],
                title: '',
                body: '',
            }
        },
        created(){
            axios.post('/api/message/' + this.$route.params.id).then(response => {
                this.messages = response.data;
                this.title = this.messages[0].title;
                console.log(this.messages);
            });
        },
        mounted(){

        },
        methods:{
            open () {
                this.dialog = true;
            },
            close () {
                this.dialog = false
            },
            sendMessage(){
                let formData = {
                    to_user_id : this.$route.params.id,
                    title: this.title,
                    body : this.body,
                };

                axios.post('/api/sendMessage',formData).then(response => {
                    this.status = response.data.status;
                    this.close();
                    this.setPopup('发送成功');
                    axios.post('/api/message/' + this.$route.params.id).then(response => {
                        this.messages = response.data;
                        this.title = this.messages[0].title;
                        console.log(this.messages);
                    });
                });
            },
            ...mapActions([
                'setPopup'
            ])
        }
    }
</script>

<style scoped>
    .float-button {
        position: fixed;
        right: 20px;
        bottom: 20px;
    }
</style>