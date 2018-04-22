import VueRouter from 'vue-router';
import jwtToken from './helpers/jwt'
import Store from './store/index'

let routes = [
    {
        path : '/map',
        name : 'map',
        component : require('./components/map/Map'),
        mata : {},
    },
    {
        path : '/',
        name : 'home',
        component : require('./components/pages/Home'),
        mata: {},
    },
    {
        path: '/posts/:id',
        name: 'posts', //指定路由
        component: require('./components/post/Post'),
        mata: {},
    },
    {
        path: '/register',
        name: 'register', //指定路由
        component: require('./components/register/Register'),
        mata: { requireGuest: true },
    },
    {
        path: '/login',
        name: 'login', //指定路由
        component: require('./components/login/Login'),
        mata: { requireGuest: true },
    },
    {
        path: '/confirm',
        name: 'confirm', //指定路由
        component: require('./components/pages/Email'),
        mata: {},
    },
    {
        path: '/profile',
        name: 'profile',
        component: require('./components/user/Profile'),
        mata: { reqiureAuth: true }

    },
    {
        path: '/add-mark',
        name: 'add-mark',
        component: require('./components/map/AddMark'),
        mata: { reqiureAuth: true }

    },
    {
        path:'/edit-profile',
        name: 'edit-profile',
        component: require('./components/user/EditProfile')
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