<template>
    <m-transition type="slide">
        <layout :has_menu="false" title="增加标记">
            <mu-content-block >
                <mu-select-field v-model="addMarkerInfo.markerType" :labelFocusClass="['label-foucs']" label="选择分享类型">
                    <mu-menu-item v-for="text,index in list" :key="index" :value="text" :title="text" />
                </mu-select-field>
                <mu-text-field v-model="addMarkerInfo.title" label="简介" hintText="请输入一些简单介绍"/><br/>

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
                                v-model="addMarkerInfo.body"
                                ref="myQuillEditor"
                                :options="editorOption"
                        >
                        </quill-editor>
                    </div>

                </div>
                <br/>
                <mu-switch label="仅自己可见" v-model="addMarkerInfo.isHidden" /><br/>
                <br/>
                <mu-raised-button @click="addMark" primary>创建 </mu-raised-button>
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
        name: "AddMark",
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
                addMarkerInfo: {
                    markerType : '营地',
                    title: '',
                    body: '',
                    isHidden: false,
                },
            }
        },
        methods:{
            addMark(){
                let formData ={
                    markerType : this.addMarkerInfo.markerType,
                    title : this.addMarkerInfo.title,
                    body : this.addMarkerInfo.body,
                    isHidden : this.addMarkerInfo.isHidden,
                    lng : this.$route.params.lng,
                    lat : this.$route.params.lat,
                };
                axios.post('/api/add-mark',formData).then(response => {
                    this.$router.push('/');
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
    }
</script>

<style>
    .quill-editor:not(.bubble) .ql-container,
    .quill-editor:not(.bubble) .ql-container .ql-editor {
        height: 10rem;
        padding-bottom: 1rem;
    }
</style>