<template>
    <input v-model="query" @keyup="search" type="text" placeholder="search" class="nav-search">
</template>

<script>

import EventBus from './EventBus';

export default {
    data() {
        return { 
            query: ''
        }
    },
    methods: {
        search() {
            if (!this.query.length) {
                EventBus.$emit('queryEmptied');
                return;
            }

            axios.get(`/search?query=${this.query}`).then(response => {
                EventBus.$emit('searchResultsReceived', response.data);
            });
        }
    }
}
</script>
