export function initialize(store, router) {
    // route required auth guard
    router.beforeEach((to, from, next) => {
        if(to.matched.some(route => route.meta.requiresAuth) && !store.state.currentUser){
            next({name: 'Login'});
        }else if(to.path == '/login' && !store.state.currentUser){
            next({name: 'Login'});
        }else if(to.path == '/login' && store.state.currentUser){
            next({name: 'Dashboard'});
        }else{
            next();
        }
    });

    // 401 interceptor
    axios.interceptors.response.use(null, (error) => {
        if (error.response.status == 401){
            axios.post('api/logout')
            store.commit('logout');
            router.push({name: 'Login'});
        }

        return Promise.reject(error);
    });

    if(store.getters.currentUser) {
        setAuthorization(store.getters.currentUser.token);
    }
}

export function setAuthorization(token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}