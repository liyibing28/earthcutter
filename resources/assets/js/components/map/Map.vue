<template>
    <layout :has_menu="true" title="earthcutter">
        <div class="amap-wrapper">
            <el-amap class="amap-box" ref="map"  vid="amap" :amap-manager="amapManager" :plugin="plugin" :center="center" :events="events">
                <!--//添加标记-->
                <el-amap-marker vid="add-marker" :position="marker.position" :visible="marker.visible" :draggable="marker.draggable" ></el-amap-marker>
                <el-amap-info-window vid="add-marker-info-window" :position="marker.position" :visible="markerWindow.visible" :autoMove="true">
                    <p>address: {{ marker.address }}</p>
                    <mu-raised-button label="下面弹出" @click="open('bottom')"/>
                </el-amap-info-window>

                <!--//展示已存在标记-->
                <el-amap-marker v-for="marker11 in markers" :key="marker11.id" :position="marker11.position" ></el-amap-marker>
                <el-amap-info-window v-if="window" :position="window.position" :visible="window.visible" :content="window.content"></el-amap-info-window>

            </el-amap>

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
    import { AMapManager } from 'vue-amap';
    import VueAMap from "vue-amap";
    import Layout from "../common/Layout";
    export default {
        components: {
            Layout
        },
        data() {
            let self = this;
            return {
                amapManager : new VueAMap.AMapManager(),
                bounds:{},
                center: [121.518658, 25.038462],
                lng: 0,
                lat: 0,
                plugin: [{
                    pName: 'ToolBar',
                    events: {
                        init(instance) {
                            //console.log(instance);
                        }
                    }
                }],
                marker : {
                    position : [0,0],
                    visible: false,
                    draggable: true,
                    clickable: true,
                    address : '',
                },
                markerWindow: {
                    //template: '<mu-raised-button label="下面弹出" @click="open(\'bottom\')"/>',
                    autoMove: true,
                    visible:false,
                },
                markers : [
                    {
                        position: [121.5273285, 31.21515044],
                        visible: true,
                        draggable: false,
                        template: '<span>1</span>',
                    }
                ],
                points: [],
                windows: [],
                window: '',
                events: {
                    init: (o) => {
                        //console.log(o.getCenter());
                        //console.log(this.$refs.map.$$getInstance());
                        o.getCity(result => {
                            //console.log(result)
                        })
                    },
                    'moveend': () => {
                    },
                    'zoomchange': () => {
                    },
                    'click': (e) => {
                        console.log(e.lnglat);
                        this.marker.visible = false;
                        this.markerWindow.visible = false;
                        this.marker.position = [e.lnglat.lng, e.lnglat.lat];
                        this.marker.visible = true;
                        this.markerWindow.visible = true;

                        // 这里通过高德 SDK 完成。

                        let geocoder = new AMap.Geocoder({
                            radius: 1000,
                            extensions: "all"
                        });
                        geocoder.getAddress(self.marker.position, function(status, result) {
                            if (status === 'complete' && result.info === 'OK') {
                                if (result && result.regeocode) {
                                    self.marker.address = result.regeocode.formattedAddress;
                                    self.$nextTick();
                                }
                            }
                        });
                    },
                    'complete': () => {
                        this.bounds = this.amapManager.getMap().getBounds();
                        console.log(this.bounds);
                        let formData = {
                            north : this.bounds.northeast.lat,
                            east : this.bounds.northeast.lng,
                            south : this.bounds.southwest.lat,
                            west : this.bounds.southwest.lng,
                        };
                        console.log(formData);
                        axios.get('/api/show-mark',formData).then(response => {
                            console.log(response.data);
                            this.points = response.data;
                            console.log(this.points.length);
                            for(let i=0; i < this.points.length; i++){
                                let marker = {
                                    position: [this.points[i].longitude,this.points[i].latitude],
                                    events: {
                                        click() {
                                            this.windows.forEach(window => {
                                                window.visible = false;
                                            });

                                            this.window = this.windows[i];
                                            self.$nextTick(() => {
                                                this.window.visible = true;
                                            });
                                        }
                                    }
                                };
                                this.markers.push(marker);
                                this.windows.push({
                                    position: [this.points[i].longitude,this.points[i].latitude],
                                    content: `<div class="prompt">${ i }</div>`,
                                    visible: false
                                });
                            }
                        });

                    }
                },
                list: ['营地', '路况', '风景', '天气'],
                toggle: true,
                addMarkerInfo: {
                    markerType : 0,
                    title: '',
                    body: '',
                    isHidden: false,
                },
                //底部弹出组件
                bottomPopup: false,
            }
        },
        mounted(){
        },
        methods:{
            addMark(){
                let formData ={
                    markerType : this.addMarkerInfo.markerType,
                    title : this.addMarkerInfo.title,
                    body : this.addMarkerInfo.body,
                    isHidden : this.addMarkerInfo.isHidden,
                    lng : this.marker.position[0],
                    lat : this.marker.position[1],
                };
                axios.post('/api/add-mark',formData).then(response => {
                    console.log(response.data);
                });
            },

            //底部弹出组件
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

    .search-box {
        //position: absolute;
        margin-top: 5px;
        width: 80%;
        left: 5px;
    }
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
        width: 100px;
        height: 400px;
    }
    .demo-popup-bottom {
        width: 100%;
        max-width: 700px;
    }

    .amap-wrapper {
        width: 100%;
        height: 500px;
    }

</style>