
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueCarousel from 'vue-carousel';
Vue.use(VueCarousel);

// Components

import HomeComponent from './components/HomeComponent.vue';
import LeaderboardComponent from './components/LeaderboardComponent.vue';
import ProfileComponent from './components/ProfileComponent.vue';
import VideoPlayerComponent from './components/VideoPlayerComponent.vue';
import RunEditor from './components/RunEditorComponent.vue';

Vue.use(VueRouter);

let routes = [
  { path: '/', component: HomeComponent },
  { path: '/profile/:id', component: ProfileComponent },
  { path: '/run/edit/:id', component: RunEditor },
  { path: '/leaderboard/:type', component: LeaderboardComponent },
  { path: '/video/:id', component: VideoPlayerComponent }
];

const router = new VueRouter({ routes });

const app = new Vue({
    el: '#app',
    router
});

// $(document).ready(function() {
//   $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
//   });

//   $('.sidenav').sidenav();

//   let elem = document.querySelector('.dropdown-button');
//   let instance = M.Dropdown.init(elem, {});
// });
