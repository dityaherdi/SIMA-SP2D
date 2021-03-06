import Vue from 'vue'
import Vuex from 'vuex'
import {getLocalUser} from './helpers/auth';

Vue.use(Vuex)

const user = getLocalUser();

export default new Vuex.Store({
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        activePage: '',
        modalOpen: ''
    },
    getters: {
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        isLoading(state) {
            return state.loading;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        activePage(state) {
            return state.activePage;
        },
        modalOpen(state) {
            return state.modalOpen;
        }
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem('user', JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            localStorage.removeItem('user');
            state.isLoggedIn = false;
            state.currentUser = null;
        },
        changePage(state, route) {
            state.activePage = route;
        },
        modalOpen(state, entity) {
            state.modalOpen = entity
        }
    },
    actions: {
        login(context) {
            context.commit('login');
        },
        modalOpen(context, entity) {
            context.commit('modalOpen', entity)
        }
    }
})