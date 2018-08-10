<template>
    <input v-model="query" type="text" placeholder="search" class="nav-search">
</template>

<script>

import EventBus from './EventBus';

export default {
    data() {
        return { 
            query: ''
        }
    },
    watch: {
        query: function(value) {
            let $this = this;

            if (!this.query.length) {
                EventBus.$emit('queryEmptied');
                return;
            }

            axios.get(`/search?query=${this.query}`).then(response => {
                if ($this.query.length) {
                    EventBus.$emit('searchResultsReceived', response.data);
                }
            });
        }
    }
}
</script>
