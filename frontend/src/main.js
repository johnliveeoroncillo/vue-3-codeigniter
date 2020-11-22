import { createApp } from 'vue'
import App from './App.vue'

import { VueCookieNext } from 'vue-cookie-next'

import VueAxios from 'vue-axios';
import axios from './plugins/axios';
import qs from 'qs';

import router from './router';

import CustomButton from '@/components/CustomButton.vue';
import AlertMessage from '@/components/AlertMessage.vue';
import CustomDialog from '@/components/CustomDialog.vue';
import AlertNotification from '@/components/AlertNotification.vue';


const title = process.env.VUE_APP_APPNAME;

router.beforeEach((to, from, next) => {
    document.title = title;
    if(to.matched.some(route => route.meta.requiresAuth)) {
        if(VueCookieNext.isCookieAvailable('vue-ci-token')) {
            return next();
        }
        else if(to.meta.error == undefined) {
            return next({path:'/'});
        }
    }
    else if(to.meta.requiresAuth == undefined && VueCookieNext.isCookieAvailable('vue-ci-token') && to.meta.error == undefined) {
        return next({path:'/home'});
    }
    return next();
});

const app = createApp(App);
app.component('CustomButton', CustomButton);
app.component('AlertMessage', AlertMessage);
app.component('CustomDialog', CustomDialog);
app.component('AlertNotification', AlertNotification);

app.use(VueCookieNext);
app.use(VueAxios, axios);
app.use(router);
app.mount('#app');


console.log(process.env.NODE_ENV);

app.config.globalProperties.$axios = axios;
app.config.globalProperties.$qs = qs;