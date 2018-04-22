<template>
    <layout title="详细资料" :has_menu="false">
        <div>
            <mu-raised-button label="发送私信" @click="open" primary/>
            <mu-dialog :open="dialog" title="Dialog" @close="close">
                <mu-text-field v-model="body" hintText="多行文本输入，默认 3行，最大6行" name="body" multiLine :rows="3" :rowsMax="6" fullWidth="true"/>
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
        name: "guest-profile",
        data () {
            return {
                dialog: false,
                body : '',
                user_id: '',
                status : false,
            }
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