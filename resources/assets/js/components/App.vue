<template>
    <div>
    <div>
        <router-view></router-view>
    </div>
    <mu-popup position="top" :overlay="false" popupClass="popup-top" :open="POP.popupVisible">
        {{POP.popupContent}}
    </mu-popup>
    </div>
</template>

<script>
    import jwtToken from './../helpers/jwt'
    import Cookie from 'js-cookie'
    import TopMenu from './common/TopMenu'
    import { mapGetters } from 'vuex'
    import {mapState} from "vuex";
    export default {
        components : {
            TopMenu,
        },
        computed: {
            ...mapGetters([
                'popupVisible',
                'popupContent'
            ]),
            ...mapState({
                POP: state => state.Register
            })
        },
        created(){
            if(jwtToken.getToken()) {               //存在accesstoken 为登录状态
                this.$store.dispatch('setAuthUser')
            }
            else if(Cookie.get('auth_id')){        //不存在，存在refreshtoken，坐请求
                this.$store.dispatch('refreshToken')
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import './../../sass/_variables.scss';

    #app {
        color: $color-theme;
        overflow: hidden;
    }

    .popup-top {
        width: 100%;
        opacity: 0.8;
        height: 48px;
        line-height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>