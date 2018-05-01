import VueRouter from 'vue-router';
import jwtToken from './helpers/jwt'
import Store from './store/index'

let routes = [
    {
        path : '/map',
        name : 'map',
        component : require('./components/map/Map'),
        meta : {},
    },
    {
        path : '/',
        name : 'home',
        component : require('./components/map/Map'),
        meta: {},
    },
    {
        path: '/posts/:id',
        name: 'posts', //指定路由
        component: require('./components/post/Post'),
        meta: {},
    },
    {
        path: '/register',
        name: 'register', //指定路由
        component: require('./components/register/Register'),
        meta: { requireGuest: true },
    },
    {
        path: '/login',
        name: 'login', //指定路由
        component: require('./components/login/Login'),
        meta: { requireGuest: true },
    },
    {
        path: '/me',
        name: 'me',
        component: require('./components/common/Me'),
        meta: { reqiureAuth: true }

    },
    {
        path: '/profile',
        name: 'profile',
        component: require('./components/user/Profile'),
        children :[
            {
                path: 'email',
                name: 'edit-email',
                component: require('./components/user/EditProfile')
            }
        ],
        meta: { reqiureAuth: true }

    },
    {
        path: '/user-profile/:id',
        name: 'user-profile', //指定路由
        component: require('./components/pages/UserProfile'),
        meta: {},
    },
    {
        path: '/add-mark',
        name: 'add-mark',
        component: require('./components/map/AddMark'),
        meta: { reqiureAuth: true }

    },
    {
        path:'/edit-profile',
        name: 'edit-profile',
        component: require('./components/user/EditProfile')
    },
    {
        path:'/message',
        name: 'message',
        component: require('./components/message/Messages')
    },
    {
        path:'/message/:id',
        name: 'message-detail',
        component: require('./components/message/MessageDetail')
    },
    {
        path:'/map/:id',
        name: 'mark-detail',
        component: require('./components/map/MarkDetail')
    },
    {
        path:'/favorite',
        name: 'favorite',
        component: require('./components/favorite/Favorite'),
        meta: { reqiureAuth: true}
    },
    {
        path:'/myMarker',
        name: 'myMarker',
        component: require('./components/user/MyMarkers'),
        meta: { reqiureAuth: true}
    },
    {
        path:'/myComments',
        name: 'myComments',
        component: require('./components/user/MyComments'),
        meta: { reqiureAuth: true}
    }
];

const router = new VueRouter({
    mode : 'history',
    routes
});

router.beforeEach((to,from,next) => {
    // 判断配置的路由中是否存在requireAuth存在则做出对应的判断
    if(to.meta.reqiureAuth){
        if(Store.state.AuthUser.authenticated || jwtToken.getToken()){
            return next()
        }else{
            return next({'name': 'login'})
        }
    }
    if(to.meta.requireGuest){
        if(Store.state.AuthUser.authenticated || jwtToken.getToken()){
            return next({'name': 'home'})
        }else{
            return next()
        }
    }
    next();//没有这一行运行不了
});

export default router