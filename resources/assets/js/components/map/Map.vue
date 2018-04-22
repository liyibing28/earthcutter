<template>
    <layout :has_menu="true" title="earthcutter">
        <div class="page_wrap" >
            <baidu-map class="map" :center="center" :zoom="zoom" @ready="handler" @click="Mark">
                <bm-geolocation anchor="BMAP_ANCHOR_BOTTOM_LEFT" :showAddressBar="true" :autoLocation="true" ></bm-geolocation>
                <bm-navigation anchor="BMAP_ANCHOR_BOTTOM_RIGHT"></bm-navigation>
                <bm-marker :position="{lng: marker.lng, lat: marker.lat}"></bm-marker>
                <bm-info-window :position="{lng: marker.lng, lat: marker.lat}" title="Info Window Title" :show="true" @close="infoWindowClose" @open="infoWindowOpen">
                    <p v-text="infoWindow.contents"></p>
                    <mu-raised-button @click="open('bottom')">下面弹出</mu-raised-button>
                </bm-info-window>
            </baidu-map>

            <mu-popup position="bottom" popupClass="demo-popup-bottom" :open="bottomPopup" @close="close('bottom')">
                <mu-appbar title="弹出">
                    <mu-flat-button slot="right" label="关闭" color="white" @click="close('bottom')"/>
                </mu-appbar>
                <mu-content-block>
                    <mu-select-field v-model="addMarkerInfo.markerType" :labelFocusClass="['label-foucs']" label="选择分享类型">
                        <mu-menu-item v-for="text,index in list" :key="index" :value="index" :title="text" />
                    </mu-select-field>
                    <mu-text-field v-model="addMarkerInfo.title" label="简介" hintText="请输入一些简单介绍"/><br/>
                    <mu-text-field v-model="addMarkerInfo.body" hintText="请输入详细介绍" multiLine :rows="3" :rowsMax="6"/><br/>
                    <mu-switch label="仅自己可见" v-model="addMarkerInfo.isHidden" /><br/>

                    <mu-raised-button @click="addMark" primary>创建</mu-raised-button>

                </mu-content-block>
            </mu-popup>
        </div>
    </layout>
</template>

<script>
    import Layout from "../common/Layout";
    export default {
        components: {
            Layout
        },
        data() {
            return {
                center: {lng:0, lat:0},
                markers: [],
                marker: {lng:0, lat:0 },
                zoom:3,
                position: '',
                bottomPopup: false,
                infoWindow: {
                    show: true,
                    contents: '新增标记点'
                },
                //markerType: 0,
                list: ['营地', '路况', '风景', '天气'],
                toggle: true,
                addMarkerInfo: {
                    markerType : 0,
                    title: '',
                    body: '',
                    isHidden: false,
                }
            }
        },
        mounted(){

        },
        methods:{
            Mark({point}){
                this.marker = point;

                //this.marker.push(this.position);
            },
            handler ({BMap, map}) {
                //console.log(point);
                this.center.lng = 110.404;
                this.center.lat = 39.915;
                this.zoom = 10;
            },
            infoWindowClose (e) {
                this.infoWindow.show = false
            },
            infoWindowOpen (e) {
                this.infoWindow.show = true
            },
            addMark(){
                let formData ={
                    markerType : this.addMarkerInfo.markerType,
                    title : this.addMarkerInfo.title,
                    body : this.addMarkerInfo.body,
                    isHidden : this.addMarkerInfo.isHidden,
                    lng : this.marker.lng,
                    lat : this.marker.lat,
                };
                axios.post('/api/add-mark',formData).then(response => {
                    console.log(response.data);
                });
            },
            open (position) {
                this[position + 'Popup'] = true
            },
            close (position) {
                this[position + 'Popup'] = false
            },
        },

    }
</script>

<style scoped lang="less">
    @import url('./../../../less/common.less');
    .page_wrap {
        width: 100%;
        height: 100%;
        background: #f5f5f5;
        .map_wrap{
            width:100%;
            height:700px;
            border:#ccc solid 1px;
        }
    }
    .map {
        width: 100%;
        height: 400px;
    }
    .demo-popup-bottom {
        width: 100%;
        max-width: 700px;
    }

</style>