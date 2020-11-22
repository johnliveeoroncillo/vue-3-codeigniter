import axios from 'axios';
import { VueCookieNext } from 'vue-cookie-next'
import router from '../router.js';


axios.defaults.baseURL = process.env.VUE_APP_ROOTAPI;
  
axios.interceptors.request.use((config) => {    
    if(VueCookieNext.isCookieAvailable('vue-ci-token') && VueCookieNext.isCookieAvailable('vue-ci-id')) {
        config.headers.authorization = "Bearer "+VueCookieNext.getCookie('vue-ci-token');
        config.headers.common["VUE-CI-ID"] = VueCookieNext.getCookie('vue-ci-id');
    }
    return config;
}, (error) => {
    // if (DEBUG) { console.error("✉️ ", error); }
    return Promise.reject(error);
});

// doing something with the response
axios.interceptors.response.use(
  (response) => {
      return response;
  },
  (error) => {
    if(error.response.status == 401) {
        VueCookieNext.removeCookie('vue-ci-token');
        VueCookieNext.removeCookie('vue-ci-id');
        router.replace({
                        name:'login',
                        query: {
                            show401: true
                        }
                    });
    }

    if (error.response && error.response.data) {
        return Promise.reject(error.response.data);
    }
    return Promise.reject(error.message);
  }
);

export default axios;