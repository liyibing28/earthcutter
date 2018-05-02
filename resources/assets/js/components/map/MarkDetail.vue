<template>
    <layout title="详情" :has_menu="false">
        <div class="">
            <mu-sub-header>{{marker.title}}</mu-sub-header>
            <mu-sub-header> 创建者：<router-link :to="{ name: 'user-profile', params:{id : user.id }}">{{user.name}}</router-link></mu-sub-header>

            <mu-sub-header> 创建时间：{{marker.created_at}} </mu-sub-header>

            <mu-divider></mu-divider>
            <mu-content-block>
                <mu-sub-header> 类型：{{marker.mark_type}} </mu-sub-header>
                <p>{{marker.body}}</p>
            </mu-content-block>
            <div class="text-center">
                <mu-raised-button label="收藏" @click="addFavorite" v-if="!is_favorite" primary></mu-raised-button>
                <mu-raised-button label="取消收藏" @click="addFavorite" v-if="is_favorite"></mu-raised-button>

                <mu-raised-button label="评论" @click="open" primary/>
            </div>




            <mu-dialog :open="dialog" title="评论" @close="close">
                <div v-for="comment in comments" :key="comment.id">
                    <mu-sub-header>{{comment.user.name}}</mu-sub-header>
                    <mu-content-block>
                        <p>{{comment.body}}</p>
                    </mu-content-block>
                </div>

                <div>
                    <mu-text-field v-model="body" hintText="多行文本输入，默认 3行，最大6行" name="body" multiLine :rows="1" :rowsMax="2" :fullWidth="true"/>
                    <mu-flat-button slot="actions" @click="close" primary label="取消"/>
                    <mu-flat-button slot="actions" primary @click="sendMessage" label="发送"/>
                </div>

            </mu-dialog>
        </div>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";
    import Comment from "../common/Comment"

    export default {
        components: {
            Comment,
            Layout},
        name: "mark-detail",
        data(){
            return{
                dialog: false,
                marker: {},
                userId: '',
                markerId: '',
                body : '',
                comments: [],
                is_favorite : false,
                user:{},
            }
        },
        mounted() {
            axios.get('/api/show-mark/' + this.$route.params.id).then(response => {
            this.marker = response.data[0];
            this.user = this.marker.user;
            console.log(this.marker);
            });

            axios.post('/api/is-favorited/' + this.$route.params.id).then(response =>{
                this.is_favorite = response.data;
            });
        },
        methods: {
            open () {
                this.dialog = true;
                this.showComments();
            },
            close () {
                this.dialog = false
            },
            sendMessage(){
                let formData = {
                    marker_id: this.$route.params.id,
                    body : this.body,
                };

                axios.post('/api/addComments',formData).then(response => {
                    this.status = response.data;
                    this.close();
                });
            },
            showComments(){
                axios.get('/api/show-comments/' + this.$route.params.id).then(response =>{
                    console.log(response.data);
                    this.comments = response.data;
                });
            },
            addFavorite(){
                axios.post('/api/add-favorite/' + this.$route.params.id).then(response =>{
                    this.is_favorite = response.data;
                });
            }
        }
    }
</script>

<style scoped>

</style>