
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

// Components

import LeaderboardComponent from './components/LeaderboardComponent.vue';
import VideoUploaderComponent from './components/VideoUploaderComponent.vue';
import RunEditor from './components/RunEditorComponent.vue';

Vue.use(VueRouter);

let routes = [
  { path: '/', component: LeaderboardComponent },
  { path: '/profile/:id', component: VideoUploaderComponent },
  { path: '/run/edit/:id', component: RunEditor }
];

const router = new VueRouter({ routes });

const app = new Vue({
    el: '#app',
    router
});

$(document).ready(function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('.sidenav').sidenav();

  let elem = document.querySelector('.dropdown-button');
  let instance = M.Dropdown.init(elem, {});
});
