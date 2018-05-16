import Vue from 'vue'
import Vuex from 'vuex'
import AuthUser from './modules/auth-user'
import Login from './modules/login'
import EditProfile from './modules/edit-profile'
import Register from './modules/register'
import state from './state'
import * as getters from './getters';
import * as actions from './actions';
import mutations from './mutations';
import createLogger from 'vuex/dist/logger';

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        AuthUser,
        Login,
        EditProfile,
        Register,
        actions,
        state,
        mutations,
        getters,
        strict: debug,
        plugins: debug ? [createLogger()] : []
    },
    strict: true
})