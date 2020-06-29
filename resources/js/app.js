/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
import QuickEdit from 'vue-quick-edit';
import tinymce from './components/tinymce.vue';
import youtube from './components/youtube.vue';
import fa from './components/fa.vue';
import Clipboard from 'v-clipboard'
import VueUploadComponent from 'vue-upload-component'
import Notifications from 'vue-notification'

window.Vue = require('vue');
const axios = require('axios').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('tinymce', tinymce);
Vue.component('youtube', youtube);
Vue.component('fa', fa);
Vue.component('file-upload', VueUploadComponent)
Vue.component('quick-edit', QuickEdit);
Vue.use(Clipboard)
Vue.use(Notifications)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// var app = new Vue({
//     el: '#vue',
// });
