import Vue from 'vue'
import Vuex from 'vuex'
import AuthUser from './modules/auth-user'
import Login from './modules/login'
import EditProfile from './modules/edit-profile'
import state from './state'
import * as getters from './getters';
import * as actions from './actions';
import mutations from './mutations';
import createLogger from 'vuex/dist/logger';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        AuthUser,
        Login,
        EditProfile,
        actions,
        state,
        mutations,
        getters,
    },
    strict: true
})