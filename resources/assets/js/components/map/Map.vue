<template>
    <layout :has_menu="true" title="earthcutter">
        <div class="amap-wrapper">
            <el-amap class="amap-box" ref="map"  vid="amap" :amap-manager="amapManager" :plugin="plugin" :center="center" :events="events">
                <!--//添加标记-->
                <el-amap-marker  vid="add-marker" :position="marker.position" :visible="marker.visible" :draggable="marker.draggable" ></el-amap-marker>
                <el-amap-info-window vid="add-marker-info-window" :position="marker.position" :visible="markerWindow.visible" :autoMove="true" :template="template">
                    <div>
                        <p>address: {{ marker.address }}</p>
                        <mu-raised-button label="添加 marker" :to="{ name: 'add-marker', params:{lng: marker.position[0], lat:marker.position[1]}} " primary/>
                    </div>
                </el-amap-info-window>

                <!--//展示已存在标记-->
                <el-amap-marker content="<i class='fa fa-anchor fa-lg'></i>" v-for="marker in markers" :key="marker.id" :position="marker.position" :events="marker.events" ></el-amap-marker>
                <el-amap-info-window v-if="window" :position="window.position" :visible="window.visible" :template="window.template">
                    <div>
                        <router-link :to="{ name: 'mark-detail', params:{id : window.id }}">{{window.title}}</router-link>
                    </div>
                </el-amap-info-window>


            </el-amap>
        </div>

    </layout>
</template>

<script>
    import { AMapManager } from 'vue-amap';
    import VueAMap from "vue-amap";
    import Layout from "../common/Layout";
    import LoginForm from "../login/LoginForm"
    export default {
        components: {
            LoginForm,
            Layout
        },
        data() {
            let self = this;
            return {
                amapManager : new VueAMap.AMapManager(),
                bounds:{},
                content: '',
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
                markerRefs: [],
                points: [],
                windows: [],
                window: '',
                events: {
                    init: (o) => {
                        setTimeout(() => {
                            console.log(this.markerRefs);
                            let cluster = new AMap.MarkerClusterer(o, this.markerRefs,{
                                gridSize: 80,
                                renderCluserMarker: this._renderCluserMarker
                            });
                            console.log(cluster);
                        }, 1000);
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
                        this.$nextTick(() => {
                            this.marker.visible = true;
                            this.markerWindow.visible = true;
                        });

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
                    }
                },
                list: ['营地', '路况', '风景', '天气'],
                toggle: true,
                addMarkerInfo: {
                    markerType : '营地',
                    title: '',
                    body: '',
                    isHidden: false,
                },
                template : ``,
            }
        },
        mounted(){
            let markers = [];
            let windows = [];
            let self = this;
            axios.get('/api/show-mark').then(response =>{
                length = response.data.length;
                this.points = response.data;
                console.log(length);
                for (let i = 0 ; i < length ; i ++) {
                    markers.push({
                        position: [this.points[i].longitude, this.points[i].latitude],
                        events: {
                            click() {
                                self.windows.forEach(window => {
                                    window.visible = false;
                                });

                                self.window = self.windows[i];
                                self.$nextTick(() => {
                                    self.window.visible = true;
                                });
                            }
                        }
                    });

                    windows.push({
                        title : this.points[i].title,
                        id    : this.points[i].id,
                        position: [this.points[i].longitude, this.points[i].latitude],
                        template: '',
                        visible: false
                    });
                }

                this.markers = markers;
                this.windows = windows;

                console.log(this.windows);
            })

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
                    this.close('bottom');
                });
            },

            _renderCluserMarker(context) {
                const count = this.markers.length;

                let factor = Math.pow(context.count/count, 1/18)
                let div = document.createElement('div');
                let Hue = 180 - factor* 180;
                let bgColor = 'hsla('+Hue+',100%,50%,0.7)';
                let fontColor = 'hsla('+Hue+',100%,20%,1)';
                let borderColor = 'hsla('+Hue+',100%,40%,1)';
                let shadowColor = 'hsla('+Hue+',100%,50%,1)';
                div.style.backgroundColor = bgColor
                let size = Math.round(30 + Math.pow(context.count/count,1/5) * 20);
                div.style.width = div.style.height = size+'px';
                div.style.border = 'solid 1px '+ borderColor;
                div.style.borderRadius = size/2 + 'px';
                div.style.boxShadow = '0 0 1px '+ shadowColor;
                div.innerHTML = context.count;
                div.style.lineHeight = size+'px';
                div.style.color = fontColor;
                div.style.fontSize = '14px';
                div.style.textAlign = 'center';
                context.marker.setOffset(new AMap.Pixel(-size/2,-size/2));
                context.marker.setContent(div)
            }
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
    .popup-bottom {
        width: 100%;
        max-width: 1000px;
    }

    .amap-wrapper {
        width: 100%;
        height: 500px;
    }
    .popup-content{
        width: 280px;
    }

</style>