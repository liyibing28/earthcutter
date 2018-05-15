<template>
    <div>
    <div>
        <router-view></router-view>
    </div>
    <mu-popup position="top" :overlay="false" popupClass="popup-top" :open="popupVisible">
        {{popupContent}}
    </mu-popup>
    </div>
</template>

<script>
    import jwtToken from './../helpers/jwt'
    import Cookie from 'js-cookie'
    import TopMenu from './common/TopMenu'
    import { mapGetters } from 'vuex';
    export default {
        components : {
            TopMenu,
        },
        computed : {
            ...mapGetters(['popupVisible', 'popupContent']),
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

<style scoped>

</style>