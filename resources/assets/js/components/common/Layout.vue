<template>
    <div class="container slim_scrollbar">
        <div class="header_warp">
            <slot name="header">
                <template>
                    <mu-appbar :title="title" >
                        <mu-icon-button icon="menu" slot="left" v-if="has_menu" @click="openMenu"></mu-icon-button>
                        <mu-icon-button icon="arrow_back" slot="left" v-if="!has_menu" @click="goback"></mu-icon-button>
                        <mu-icon-menu icon="expand_more" slot="right">
                            <slot name="bar_menu">
                                <mu-menu-item title="分享" />
                                <mu-menu-item to="/user/favorite" title="我的收藏" />
                            </slot>
                        </mu-icon-menu>
                    </mu-appbar>
                </template>
            </slot>
        </div>

        <div class="side" >
            <mu-drawer :docked="docked" :open="open" @close="openMenu()">
                <mu-list>
                    <mu-list-item :title="nav.title" :to="nav.path" v-for="nav in navs" :key="nav.title">
                        <mu-icon slot="left" :value="nav.icon" />
                    </mu-list-item>
                </mu-list>
            </mu-drawer>
        </div>

        <div class="content_wrap">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    let _self;
    import Store from './../../store/index';

    export default {
        data: function () {
            return{
                active_nav: '/',
                navs: [{
                    title: '首页',
                    path: '/',
                    icon: 'map',
                },{
                    title: '消息',
                    path: '/message',
                    icon: 'message',
                },{
                    title: '收藏',
                    path: '/favorite',
                    icon: 'favorite',
                },{
                    title: '我的',
                    path: '/profile',
                    icon: 'people',
                }],
                open: false,
                docked: false,
            }
        },
        props : {
            title: {
                type: String,
                default: '',
            },
            has_menu: {
                type: Boolean,
                default: true
            },
            leftAction: {
                type: Function,
            }
        },
        created(){
            _self = this
        },
        mounted(){
            // 设置手机状态栏颜色
            // this.setStatusBar();
        },
        activated(){
            //this.setActiveNav();
            //this.getModSwitch();
            //this.setStatusBar();
        },
        methods: {
            openMenu(){
                this.open = !this.open;
            },
            goback(){
                if (this.leftAction) {
                    this.leftAction.call(this.$parent);
                } else {
                    if (history.length > 1) {
                        this.$router.go(-1);
                    } else {
                        this.$router.push('/');
                    }
                }
            },
            handleChange(val) {
                this.active_nav = val;
                this.$router.push(val);
            },
            setActiveNav() {
                let path = this.$route.path;
                this.active_nav = path;
            },

        }

    }
</script>

<style scoped lang="less">
    .container {
        width: 100%;
        height: 100%;
        padding-left: 0;
        padding-right: 0;
        overflow-y: auto;
        .header_wrap {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 999;
        }
        .side {
            .img_box {
                height: 160px;
                background-repeat: no-repeat;
                background-size: cover;
            }
        }
        .content_wrap {
            padding: 0 0 0 0; // background: #f5f5f5;
        }
    }

</style>