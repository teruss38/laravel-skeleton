/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.ElementUI = require('element-ui');

import store from './store'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('send-message', require('./widgets/message/SendMessage.vue').default);
Vue.component('send-user-message', require('./widgets/message/SendMessageToUser.vue').default);
Vue.component('send-mobile-verify-code', require('./widgets/SendMobileVerifyCode.vue').default);
Vue.component('notification-mark-as-read', require('./widgets/notification/MarkAsRead.vue').default);
Vue.component('support', require('./widgets/Support.vue').default);
Vue.component('collect', require('./widgets/Collect.vue').default);
Vue.component('follow', require('./widgets/Follow.vue').default);
Vue.component('go-top', require('./widgets/GoTop.vue').default);
Vue.component('svg-icon', require('./widgets/SvgIcon.vue').default);

Vue.component('settings-profile', require('./components/settings/Profile.vue').default);
Vue.component('settings-account', require('./components/settings/Account.vue').default);
Vue.component('settings-login-histories', require('./components/settings/LoginHistories.vue').default);
Vue.component('settings-tokens', require('./components/settings/PersonalAccessTokens.vue').default);
Vue.component('settings-applications', require('./components/settings/Clients.vue').default);
Vue.component('settings-authorization', require('./components/settings/AuthorizedClients.vue').default);
Vue.component('settings-wallet', require('./components/settings/Wallet.vue').default);
Vue.component('settings-integral', require('./components/settings/Integral.vue').default);
Vue.component('settings-settle', require('./components/settings/Settle.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    store,
    computed: {
        isLogin() {
            return this.$store.getters.isLogin;
        },
        username() {
            return this.$store.getters.username;
        },
        avatar() {
            return this.$store.getters.avatar;
        },
    },
    created() {
        this.$store.dispatch('app/init');
    },
    mounted() {

    }
});


