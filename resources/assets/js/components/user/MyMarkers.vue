<template>
    <m-transition>
        <layout title="我的标记" :has_menu="false">
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
        </layout>
    </m-transition>

</template>

<script>
    import Layout from "../common/Layout";
    import MTransition from "../base/m-transition";
    import MarkerList from "../base/marker-list";
    import Loading from "./../base/loading"

    export default {
        components: {
            MarkerList,
            MTransition,
            Loading,
            Layout},
        name: "my-markers",
        data(){
            return{
                markers : [],
            }
        },
        mounted(){
            axios.post('/api/my-markers').then(response =>{
                this.markers = response.data;
                console.log(this.markers);
            });
        },
        methods : {
            selectItem(item, index){
                console.log(this.markers[index]);
                this.$router.push('/map/'+ this.markers[index].id);
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "./../../../sass/mixin";
    @import "./../../../sass/variables";
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