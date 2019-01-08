import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';
import auth from './services/auth';

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/chat',
            name: 'chat',
            component: () => import(/* webpackChunkName: "about" */ './views/Chat.vue'),
            meta: {
                requireAuth: true,
            }
        },
        {
            path: '/about',
            name: 'about',
            component: () => import(/* webpackChunkName: "about" */ './views/About.vue')
        }
    ]
});

router.beforeEach((to, from, next) => {
    if (! auth.check() && to.meta.requireAuth) {
        next({path: '/', replace: true});
    }

    next();
});

export default router;