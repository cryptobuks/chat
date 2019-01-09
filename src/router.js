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
            component: Home,
            meta: {
                redirectIfLoggedIn: true
            }
        },
        {
            path: '/chat',
            name: 'chat',
            component: () => import(/* webpackChunkName: "chat" */ './views/Chat.vue'),
            meta: {
                requireAuth: true,
            },
            children: [
                {
                    path: ':room',
                    name: 'chat-room',
                    component: () => import(/* webpackChunkName: "chat-room" */ './views/ChatRoom.vue')
                }
            ]
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
    if (auth.check() && to.meta.redirectIfLoggedIn) {
        next({path: '/chat', replace: true});
    }

    next();
});

export default router;