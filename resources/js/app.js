/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import $ from 'jquery';
window.jQuery = $;
window.$ = $;

require('./bootstrap');
require('es6-promise').polyfill();

window.route = require('./route');
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
    
Vue.component('chat-messages', require('./components/ChatMessagesComponent.vue').default);
Vue.component('create-room-form', require('./components/CreateRoomForm.vue').default);
Vue.component('room-authorization-form', require('./components/RoomAuthorizationForm.vue').default);
Vue.component('room-list', require('./components/RoomList.vue').default);
Vue.component('room-expanded-list', require('./components/RoomExpandedList.vue').default);
Vue.component('settings-form', require('./components/SettingsForm.vue').default);
Vue.component('room-search', require('./components/RoomSearch.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        favorites: [],
        messages: [],
        message: '',
    },
    mounted() {
        makeResizableDiv();
        this.fetchFavorites();
    },
    methods: {  
        fetchMessages(url) {
            axios.post(url).then(response => {
                if(response.data['status'] == 'success'){
                    this.messages = response.data['messages'];
                }
            });
            
        },
        sendMessage(url) {
            axios.post(url, {
                message: this.message
            }).then(response => {
                if(response.data['status'] == 'success'){
                    this.message = '';
                }
            });
        },
        joinChannel(channel) {
            window.Echo.join(`ChatApp.${channel}`)
                .here((e) => {
                    console.log(e);
                })
                .listen('MessageSent', (e) => {
                    this.messages.push({
                        message: e.message,
                        user: e.user
                    });
                });
        },
        addFavorite(room) {
            var url = route('favorite', room);
            axios.post(url).then(response => {
                if(response.data['status'] == 'success'){
                    this.fetchFavorites();
                }
            });
        },
        fetchFavorites() {
            var url = route('fetch-favorites');
            axios.get(url).then(response => {
                if(response.data['status'] == 'success'){
                    this.favorites = response.data['favorites'];
                }
            });
            
        },
        changeRoom(room){
            var url = route('room', room);
            axios.get(url).then((response) => {
                window.location.href = url;
            }).catch((error) => {
                if(error.response.status === 403){
                    this.selected = this.currentItem;
                    this.$refs.auth_room.createAuthorizationForm(room);
                }
            })
        },
    },
});
