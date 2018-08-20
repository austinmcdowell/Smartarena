<template>
    <div v-show="shouldDisplay" id="results" class="search-results">
        <ul>
            <li @click="presentProfile(result)" v-for="result in results" :key="result.id">{{ result.first_name }} {{ result.last_name }}<span v-if="result.location"> - {{ result.location }}</span></li>
        </ul>
    </div>
</template>

<script>
import EventBus from './EventBus';

export default {
    mounted() {
        const $this = this;

        if (this.$route) {
            this.routerExists = true;
        }

        EventBus.$on('searchResultsReceived', function(data) {
            $this.shouldDisplay = true;
            $this.results = data;
        });

        EventBus.$on('queryEmptied', function() {
            $this.shouldDisplay = false;
            $this.results = [];
        });
    },
    data() {
        return { 
            shouldDisplay: false,
            results: [],
            routerExists: false
        }
    },
    methods: {
        presentProfile(result) {
            window.location = '/#/profile/' + result.id; 
            EventBus.$emit('searchResultSelected', result.id);
            this.shouldDisplay = false;
        }
    }
}
</script>