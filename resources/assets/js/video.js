
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

// Components

import VideoComponent from './components/VideoComponent.vue';
import SearchBarComponent from './components/SearchBarComponent.vue';
import SearchResultsComponent from './components/SearchResultsComponent.vue';

const app = new Vue({
    el: '#app',
    components: {
        'video-component': VideoComponent,
        'search-bar': SearchBarComponent,
        'search-results': SearchResultsComponent
    }
});


