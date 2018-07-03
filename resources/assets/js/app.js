
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
import CreateHumanComponent from './components/admin/CreateHumanComponent.vue';
import UserHumanLinkerComponent from './components/admin/UserHumanLinkerComponent.vue';
import MassUploadRunsComponent from './components/admin/MassUploadRunsComponent.vue';
import MassUploadHumansComponent from './components/admin/MassUploadHumansComponent.vue';

Vue.use(VueRouter);

let routes = [
  { path: '/', component: HomeComponent },
  { path: '/profile/:id', component: ProfileComponent },
  { path: '/run/edit/:id', component: RunEditor, meta: { requireSubscription: true } },
  { path: '/leaderboard/:type', component: LeaderboardComponent },
  { path: '/video/:id', component: VideoPlayerComponent },
  { path: '/admin/create-human', component: CreateHumanComponent },
  { path: '/admin/user-human-linker', component: UserHumanLinkerComponent },
  { path: '/admin/mass-upload-runs', component: MassUploadRunsComponent },
  { path: '/admin/mass-upload-humans', component:  MassUploadHumansComponent },
];

const router = new VueRouter({ routes });

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requireSubscription)) {                
      if (!window.user.stripeid) {
          window.location = '/choose-plan';
          return;
      }
  }
  next();
});

const app = new Vue({
    el: '#app',
    router
});


