<template>
    <layout title="详细资料" :has_menu="false">
        <div>
            <mu-raised-button label="发送私信" @click="open" primary/>
            <mu-dialog :open="dialog" title="评论" @close="close">
                <mu-text-field v-model="body" hintText="多行文本输入，默认 2行，最大4行" name="body" multiLine :rows="2" :rowsMax="4" fullWidth="true"/>
                <mu-flat-button slot="actions" @click="close" primary label="取消"/>
                <mu-flat-button slot="actions" primary @click="sendMessage" label="发送"/>
            </mu-dialog>
        </div>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";

    export default {
        components: {Layout},
        name: "comment",
        data () {
            return {
                dialog: false,
                body : '',
                user_id: '',
                status : false,
            }
        },
        mounted(){
            axios.get('/api/show-comments/'+this.$store.params.id).then(response => {

            })
        },
        props:['user'],
        methods: {
            open () {
                this.dialog = true
            },
            close () {
                this.dialog = false
            },
            sendMessage(){
                let formData = {
                    to_user_id : 37,
                    body : this.body,
                }

                axios.post('/api/sendMessage',formData).then(response => {
                    this.status = response.data.status;
                    this.close();
                });
            }
        }
    }
</script>

<style scoped>

</style>