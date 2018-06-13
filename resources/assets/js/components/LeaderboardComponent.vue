<template>
    <div>
        <br />
        <div class="row">
            <div class="col s8 offset-s2 awards center-align">

                <div v-show="mostRunsBadge.human_name" class="award most-runs">
                    <div class="circle"></div>
                    <div class='full-name'>{{ mostRunsBadge.human_name }}</div>
                    <div class='description'>({{ mostRunsBadge.count }}) Most Runs</div>
                </div>

                <div v-show="mostEfficientBadge.human_name" class="award most-efficient">
                    <div class="circle"></div>
                    <div class='full-name'>{{ mostEfficientBadge.human_name }}</div>
                    <div class='description'>Most Efficient</div>
                </div>

                <div v-show="shortestAverageTimeBadge.human_name" class="award shortest-average-time">
                    <div class="circle"></div>
                    <div class='full-name'>{{ shortestAverageTimeBadge.human_name }}</div>
                    <div class='description'>Best Average Time: {{ shortestAverageTimeBadge.count }}</div>
                </div>

                <div v-show="mostVideosUploadedBadge.human_name" class="award most-videos-uploaded">
                    <div class="circle"></div>
                    <div class='full-name'>{{ mostVideosUploadedBadge.human_name }}</div>
                    <div class='description'>Most uploads: {{ mostVideosUploadedBadge.count }}</div>
                </div>

            </div>
        </div>
        <div class="row hide-on-large-only">
            <div class="col s10 offset-s1">
                <div class="card" v-for="human in humans" :key="human.id">
                    <div v-if="stats[human.id]" class="card-content">
                        <img v-if="human.video && human.video.thumbnail_url" :src="human.video.thumbnail_url" alt="">
                        <h4><router-link :to="`/profile/${human.id}`" v-text="`${human.first_name} ${human.last_name}`"></router-link></h4>
                        <p>Classification: {{ human.classification }}</p>
                        <p>Catch count: {{ stats[human.id]['catch_count'] }}</p>
                        <p>Runs: {{ stats[human.id]['run_count'] }}</p>
                        <p>Total Run Penalties: {{ stats[human.id]['total_penalties'] }}</p>
                        <p>Total Raw Time: {{ stats[human.id]['total_raw_time'] }}s</p>
                        <p>Time With Penalties: {{ stats[human.id]['time_with_penalties'] }}s</p>
                        <p>Catch Percentage: {{ stats[human.id]['catch_percentage'] }}%</p>
                        <p>Average Time: {{ stats[human.id]['sum_of_average_time'] }}s</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row hide-on-med-and-down">
            <div class="col l10 offset-l1">
                <div class="card">
                    <div class="card-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>Classification</th>
                                    <th>Name</th>
                                    <th>Catch Count</th>
                                    <th>Runs</th>
                                    <th>Penalties</th>
                                    <th>Total Run Penalties</th>
                                    <th>Total Raw Time</th>
                                    <th>Time With Penalties</th>
                                    <th>Catch Percentage</th>
                                    <th>Average Time</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                                <tr v-for="human in humans" :key="human.id" v-if="stats[human.id]">
                                    <td>{{ human.classification }}</td>
                                    <td><router-link :to="`/profile/${human.id}`" v-text="`${human.first_name} ${human.last_name}`"></router-link></td>
                                    <td>{{ stats[human.id]['catch_count'] }}</td>
                                    <td>{{ stats[human.id]['run_count'] }}</td>
                                    <td>{{ stats[human.id]['penalties'] }}</td>
                                    <td>{{ stats[human.id]['total_penalties'] }}</td>
                                    <td>{{ stats[human.id]['total_raw_time'] }}s</td>
                                    <td>{{ stats[human.id]['time_with_penalties'] }}s</td>
                                    <td>{{ stats[human.id]['catch_percentage'] }}%</td>
                                    <td>{{ stats[human.id]['sum_of_average_time'] }}s</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {    
    mounted() {
        let $this = this;
        axios.get('/leaderboard').then(response => {
            let data = response.data;
            $this.humans = data.humans;
            $this.stats  = data.stats;
            $this.mostRunsBadge = data.mostRunsBadge;
            $this.mostEfficientBadge = data.mostEfficientBadge;
            $this.shortestAverageTimeBadge = data.shortestAverageTimeBadge;
            $this.mostVideosUploadedBadge = data.mostVideosUploadedBadge;
            console.log(data);
        }).catch(e => {
            alert('There was an error. Please contact support.');
        })
    },
    data() {
        return {
            user: {},
            humans: [],
            stats: {},
            mostRunsBadge: {},
            mostEfficientBadge: {},
            shortestAverageTimeBadge: {},
            mostVideosUploadedBadge: {}
        }
    }
}
</script>
