<template>
    <m-transition type="slide">
        <layout :has_menu="false" title="评论">
            <div v-for="comment in comments" :key="comment.id">
                <mu-sub-header>
                    <mu-avatar :src="comment.user.avatar" :size="25"></mu-avatar>
                    <router-link :to="{ name: 'user-profile', params:{id : comment.user.id }}">{{comment.user.name}}</router-link>
                     {{comment.created_at}}
                </mu-sub-header>
                <mu-content-block>
                    <div class="panel-body" v-html="comment.body"></div>
                </mu-content-block>
                <mu-divider/>
            </div>

            <mu-float-button icon="edit" class="float-button" @click="open"/>

            <mu-dialog :open="dialog" title="评论" @close="close">

                <div>
                    <div>
                        <!-- 图片上传组件辅助-->
                        <vue-core-image-upload
                                class="img-uploader"
                                :crop="false"
                                @imageuploaded="imageuploaded"
                                :max-file-size="5242880"
                                inputOfFile="img"
                                url="/api/uploadImage"
                                text=" "
                                :headers="headers">
                        </vue-core-image-upload>
                        <!--富文本编辑器组件-->
                        <div>
                            <quill-editor
                                    v-model="body"
                                    ref="myQuillEditor"
                                    :options="editorOption"
                            >
                            </quill-editor>
                        </div>

                    </div>
                    <mu-flat-button slot="actions" @click="close" primary label="取消"/>
                    <mu-flat-button slot="actions" primary @click="sendComment" label="发送"/>
                </div>

            </mu-dialog>
        </layout>
    </m-transition>
</template>

<script>
    import MTransition from "../base/m-transition";
    import VueCoreImageUpload from 'vue-core-image-upload'
    import Layout from "../common/Layout";
    import jwtToken from './../../helpers/jwt'
    import {mapActions} from 'vuex';

    const toolbarOptions = [
        ['bold'],        // toggled buttons
        ['link', 'image'],
        ['clean']                                         // remove formatting button
    ];

    export default {
        name: "CommentsList",
        components: {Layout, MTransition,VueCoreImageUpload,},
        data(){
            return{
                dialog: false,
                body: '',
                comments: [],
                headers: {Authorization : 'Bearer ' + jwtToken.getToken()},
                editorOption: {
                    placeholder: '',
                    theme: 'snow',  // or 'bubble'
                    modules: {
                        toolbar: {
                            container: toolbarOptions,  // 工具栏
                            handlers: {
                                'image': function (value) {
                                    if (value) {
                                        document.querySelector('.img-uploader input').click()
                                    } else {
                                        this.quill.format('image', false);
                                    }
                                }
                            }
                        }
                    }
                } , // 富文本编辑器配置
            }
        },
        methods:{
            open () {
                this.dialog = true;
            },
            close () {
                this.dialog = false
            },
            sendComment(){
                let formData = {
                    marker_id: this.$route.params.id,
                    body : this.body,
                };

                axios.post('/api/addComments',formData).then(response => {
                    this.status = response.data;
                    this.close();

                    axios.get('/api/show-comments/' + this.$route.params.id).then(response =>{
                        console.log(response.data);
                        this.comments = response.data;
                    });
                });
            },
            imageuploaded(response) {
                // 获取富文本组件实例
                let quill = this.$refs.myQuillEditor.quill;
                // 如果上传成功
                console.log(response.code);
                console.log(response.info);
                if (response.code === '200' && response.info !== null) {
                    // 获取光标所在位置
                    let length = quill.getSelection().index;
                    // 插入图片  res.info为服务器返回的图片地址
                    quill.insertEmbed(length, 'image', response.info);
                    // 调整光标到最后
                    quill.setSelection(length + 1)
                } else {
                    this.setPopup('图片上传失败');
                }
            },
            ...mapActions([
                'setPopup',
            ])
        },
        mounted(){
            axios.get('/api/show-comments/' + this.$route.params.id).then(response =>{
                console.log(response.data);
                this.comments = response.data;
            });
        }
    }
</script>

<style>
    .panel-body img{
        width: 80%;
    }
    .float-button {
        position: fixed;
        right: 20px;
        bottom: 20px;
    }
    .quill-editor:not(.bubble) .ql-container,
    .quill-editor:not(.bubble) .ql-container .ql-editor {
        height: 10rem;
        padding-bottom: 1rem;
    }
</style>