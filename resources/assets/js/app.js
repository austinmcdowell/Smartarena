
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import VueCarousel from 'vue-carousel';
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue);
Vue.use(VueCarousel);

// Components

import HomeComponent from './components/HomeComponent.vue';
import LeaderboardComponent from './components/LeaderboardComponent.vue';
import ProfileComponent from './components/ProfileComponent.vue';
import VideoComponent from './components/VideoComponent.vue';
import VideoUploaderComponent from './components/VideoUploaderComponent.vue';
import RunEditorComponent from './components/RunEditorComponent.vue';
import CreateHumanComponent from './components/admin/CreateHumanComponent.vue';
import UserHumanLinkerComponent from './components/admin/UserHumanLinkerComponent.vue';
import MassUploadRunsComponent from './components/admin/MassUploadRunsComponent.vue';
import MassUploadHumansComponent from './components/admin/MassUploadHumansComponent.vue';
import SearchBarComponent from './components/SearchBarComponent.vue';
import SearchResultsComponent from './components/SearchResultsComponent.vue';


Vue.use(VueRouter);

let routes = [
  { path: '/', component: HomeComponent },
  { path: '/profile/:id', component: ProfileComponent },
  { path: '/run/edit/:id', component: RunEditorComponent, meta: { requireSubscription: true } },
  { path: '/run/new/:videoId', component: RunEditorComponent, meta: { requireSubscription: true } },
  { path: '/leaderboard/:type', component: LeaderboardComponent },
  { path: '/video/new', component: VideoUploaderComponent, meta: { requireSubscription: true } },
  { path: '/video/:id', component: VideoComponent },
  { path: '/admin/create-human', component: CreateHumanComponent, meta: { requireAdmin: true } },
  { path: '/admin/user-human-linker', component: UserHumanLinkerComponent, meta: { requireAdmin: true } },
  { path: '/admin/mass-upload-runs', component: MassUploadRunsComponent, meta: { requireAdmin: true } },
  { path: '/admin/mass-upload-humans', component:  MassUploadHumansComponent, meta: { requireAdmin: true } },
];

const router = new VueRouter({ routes });

router.beforeEach((to, from, next) => {

  if (to.matched.some(record => record.meta.requireSubscription)) {                
      if (!window.user || !window.user.stripe_id) {
          window.location = '/choose-plan';
          return;
      }
  }

  if (to.matched.some(record => record.meta.requireAdmin)) {                
    if (!window.user || !window.user.role !== 'admin') {
        window.location = '/';
        return;
    }
}

  next();
});

const app = new Vue({
    el: '#app',
    router,
    components: {
        'search-bar': SearchBarComponent,
        'search-results': SearchResultsComponent
    }
});


