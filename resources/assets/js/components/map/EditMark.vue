<template>
    <m-transition type="slide">
        <layout :has_menu="false" title="增加标记">
            <mu-content-block >
                <mu-select-field v-model="marker.mark_type" :labelFocusClass="['label-foucs']" label="选择分享类型">
                    <mu-menu-item v-for="text,index in list" :key="text" :value="text" :title="text" />
                </mu-select-field>
                <mu-text-field v-model="marker.title" label="简介" hintText="请输入一些简单介绍"/><br/>

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
                                v-model="marker.body"
                                ref="myQuillEditor"
                                :options="editorOption"
                        >
                        </quill-editor>
                    </div>

                </div>
                <br/>
                <mu-switch label="仅自己可见" v-model="marker.isHidden" /><br/>
                <br/>
                <mu-raised-button @click="editMark" primary>修改</mu-raised-button>
                <mu-raised-button @click="deleteMark" primary>删除</mu-raised-button>
            </mu-content-block>
        </layout>
    </m-transition>
</template>

<script>
    import MTransition from "../base/m-transition";
    import Layout from "../common/Layout";
    import jwtToken from './../../helpers/jwt'
    import VueCoreImageUpload from 'vue-core-image-upload'
    import {mapActions} from 'vuex';


    const toolbarOptions = [
        ['bold'],        // toggled buttons
        ['link', 'image'],
        ['clean']                                         // remove formatting button
    ];

    export default {
        name: "EditMark",
        components: {Layout, MTransition, VueCoreImageUpload,},
        data(){
            return{
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
                list: ['营地', '路况', '风景', '天气'],
                marker: {},
                user:{},
            }
        },
        mounted() {
            axios.get('/api/show-mark/' + this.$route.params.id).then(response => {
                this.marker = response.data[0];
                this.user = this.marker.user;
                console.log(this.marker);
            });
        },
        methods:{
            editMark(){
                let formData ={
                    markerType : this.marker.mark_type,
                    title : this.marker.title,
                    body : this.marker.body,
                    isHidden : this.marker.isHidden,
                };
                axios.post('/api/edit-mark/' + this.$route.params.id ,formData).then(response => {

                    console.log(response.data);
                    if(response.data.code === 200){
                        this.setPopup('修改成功！');
                        this.$router.push({name : 'map', params : {id: this.$route.params.id}});
                    }else {
                        this.setPopup('修改出错！！');
                    }
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
            deleteMark(){
                axios.post('/api/delete-mark/' + this.$route.params.id).then(response =>{

                    if(response.status === 200)
                    {
                        this.$router.push('/');
                        this.setPopup('删除标记点成功');
                    }
                    else{
                        this.setPopup('标记点未删除');
                    }

                });
            },
            ...mapActions([
                'setPopup',
            ])
        },
    }
</script>

<style>
    .quill-editor:not(.bubble) .ql-container,
    .quill-editor:not(.bubble) .ql-container .ql-editor {
        height: 10rem;
        padding-bottom: 1rem;
    }
</style>