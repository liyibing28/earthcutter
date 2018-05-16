
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import router from './routes';
import store from './store/index';
import MuseUI from 'muse-ui';
import 'muse-ui/dist/muse-ui.css';
import App from './components/App'
import VeeValidate from 'vee-validate';
import jwtToken from './helpers/jwt';
import VueAMap from 'vue-amap';
import VueHtml5Editor from 'vue-html5-editor'

import VueQuillEditor from 'vue-quill-editor'
// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

// import BaiduMap from 'vue-baidu-map'
//import VueCoreImageUpload from 'vue-core-image-upload';
//import VueCoreImageUpload from 'vue-core-image-upload/dist/ssr';


axios.interceptors.request.use(function (config) {
    if(jwtToken.getToken()){
        config.headers['Authorization'] = 'Bearer ' + jwtToken.getToken();
    }
    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});


Vue.use(VueRouter);
Vue.use(MuseUI);
Vue.use(VeeValidate);
Vue.use(VueAMap);
Vue.use(VueHtml5Editor,{
    showModuleName: false,
    icons: {
        image: "fa fa-file-image-o",
    },
    visibleModules: [
        "image",
    ],
    // 配置图片模块
    // config image module
    image: {
        // 文件最大体积，单位字节  max file size
        sizeLimit: 512 * 1024,
        // 上传参数,默认把图片转为base64而不上传
        upload: {
            url: '/api/uploadImage',
            headers: {},
            params: {},
            fieldName: 'img',
        },
        // 压缩参数,默认使用localResizeIMG进行压缩,设置为null禁止压缩
        // compression config,default resize image by localResizeIMG (https://github.com/think2011/localResizeIMG)
        // set null to disable compression
        compress: {
            width: 1600,
            height: 1600,
            quality: 80
        },
        // 响应数据处理,最终返回图片链接
        // handle response data，return image url
        uploadHandler(responseText){
            //default accept json data like  {ok:false,msg:"unexpected"} or {ok:true,data:"image url"}
            console.log(responseText);
            let json = JSON.parse(responseText)
            if (!json.ok) {
                alert(json.msg)
            } else {
                return json.data
            }
        }
    },
});

Vue.use(VueQuillEditor, {

});
VueAMap.initAMapApiLoader({
    key: 'e29bd81fa85d6b97a3db2b05e655fc2b',
    plugin: ['AMap.Autocomplete', 'AMap.PlaceSearch', 'AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MapType', 'AMap.PolyEditor', 'AMap.CircleEditor','Geocoder'],
    // 默认高德 sdk 版本为 1.4.4
    v: '1.4.4'
});



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('app',App);
Vue.component('example-component', require('./components/ExampleComponent.vue'));

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App)
});
