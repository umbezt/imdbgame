/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');

window.Vue = require('vue');
window.Swal  = require('sweetalert2');

window.setCookie = function (cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};
import VueRouter from 'vue-router'
import HomeComponent from "./components/HomeComponent";
import GameComponent from "./components/GameComponent";
import AppComponent from "./components/AppComponent";
import LastGamesComponent from "./components/LastGamesComponent";

Vue.use(VueRouter);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/AppComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('App', require('./components/AppComponent.vue').default);
Vue.component('Home', require('./components/HomeComponent.vue').default);
Vue.component('Game', require('./components/GameComponent.vue').default);
Vue.component('LastGamesComponent', require('./components/LastGamesComponent.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeComponent,

        },
        {
            path: '/game',
            name: 'game',
            component: GameComponent,

        },
    ],
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {'app': AppComponent, 'home': HomeComponent, 'game': GameComponent, 'lastgames' : LastGamesComponent},
    router
});
