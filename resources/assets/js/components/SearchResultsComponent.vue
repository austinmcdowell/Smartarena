<template>
    <div id="results" class="search-results">
        <ul>
            <li v-for="result in results" :key="result.id"><router-link :to="`/profile/${result.id}`">{{ result.first_name }} {{ result.last_name }} - {{ result.location }}</router-link></li>
        </ul>
    </div>
</template>

<script>
import EventBus from './EventBus';

export default {
    mounted() {
        const $this = this;
        EventBus.$on('searchResultsReceived', function(data) {
            console.log(data);
            $this.results = data;
        });

        EventBus.$on('queryEmptied', function() {
            $this.results = [];
        });
    },
    data() {
        return { 
            results: []
        }
    }
}
</script>