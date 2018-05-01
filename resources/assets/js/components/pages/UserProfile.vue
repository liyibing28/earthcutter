<template>
    <m-transition type="slide">
        <layout :title="title" :has_menu="false">
                <div class="bg-image" :style="bgStyle" ref="bgImage">
                    <div class="marker-wrapper" v-show="markers.length>0">
                        <div class="sendMessage" ref="playBtn" @click="open">
                            <i class="material-icons">message</i>
                            <span class="text">发送私信</span>
                        </div>
                        <div class="favor" v-show="true" @click="" ref="favorBtn">
                            <i class="material-icons">favorite</i>
                            <span class="text">关注</span>
                        </div>
                    </div>
                    <div class="filter" ref="filter"></div>
                </div>
                <div class="bg-layer" ref="layer"></div>

                <div class="list" ref="list">
                    <div>
                        <div :class="['song-list-wrapper',{'pad':markers.length}]">
                            <marker-list @select="selectItem" :markers="markers"></marker-list>
                        </div>
                        <div class="loading-container" v-show="!markers.length">
                            <loading></loading>
                        </div>
                    </div>
                </div>

            <mu-dialog :open="dialog" :title="title" @close="close">
                <mu-text-field v-model="body" hintText="消息内容" name="body" :fullWidth="true"/>
                <mu-flat-button slot="actions" @click="close" primary label="取消"/>
                <mu-flat-button slot="actions" primary @click="sendMessage" label="发送"/>
            </mu-dialog>
        </layout>
    </m-transition>
</template>

<script>
    import Layout from "../common/Layout";
    import Loading from "./../base/loading"
    import MTransition from "../base/m-transition";
    import MarkerList from "../base/marker-list";
    export default {
        components: {
            MarkerList,
            Loading,
            MTransition,
            Layout},
        name: "guest-profile",
        data () {
            return {
                dialog: false,
                body : '',
                user_id: '',
                status : false,
                user :{},
                bgImage: {
                    type: '',
                    default: ''
                },
                markers:[],
            }
        },
        computed:{
            title(){
                return this.user.name;
            },
            bgStyle() {
                return `background-image: url(${this.bgImage});`;
            }
        },
        mounted() {
            axios.get('/api/user/' + this.$route.params.id).then(response => {
                this.user = response.data[0];
                this.markers = this.user.has_markers;
                this.bgImage = this.user.avatar;
                console.log(this.bgImage);
                console.log(this.markers);
            });
        },

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
            },
            selectItem(item, index) {
                console.log(this.markers[index]);
                this.$router.push('/map/'+ this.markers[index].id);
            },
        }
    }
</script>

<style lang="scss" scoped>
    @import "./../../../sass/mixin";
    @import "./../../../sass/variables";
    .bg-image {
        position: relative;
        width: 100%;
        height: 0;
        padding-top: 70%;
        transform-origin: top;
        background-size: cover;
    }
    .marker-wrapper {
        position: absolute;
        bottom: 20px;
        z-index: 50;
        width: 100%;
        display: flex;
        justify-content: center;
        .favor,
        .sendMessage {
            box-sizing: border-box;
            width: 135px;
            padding: 7px 0;
            margin: 0 auto;
            text-align: center;
            border: 1px solid $color-theme;
            color: $color-theme;
            border-radius: 100px;
            font-size: 0;
            .material-icons {
                display: inline-block;
                vertical-align: middle;
                margin-right: 6px;
                font-size: $font-size-medium-x;
            }
            .text {
                display: inline-block;
                visibility: visible;
                vertical-align: middle;
                font-size: $font-size-small;
            }
        }
    }
    .filter {
        //position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(7, 17, 27, 0.4);
    }
    .bg-layer {
        //position: relative;
        height: 100%;
        background: $color-background;
    }
    .list {
        //position: fixed;
        top: 0;
        bottom: 0;
        width: 100%;
        background: $color-background;
        .song-list-wrapper {
            background-color: $color-highlight-background;
        }
        .pad {
            padding: 20px 15px;
        }
        .loading-container {
            position: absolute;
            width: 100%;
            top: 50%;
            transform: translateY(-50%);
        }
    }

</style>