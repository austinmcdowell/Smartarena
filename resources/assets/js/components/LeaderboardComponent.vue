<template>
    <div id="leaderboard" class="container-fluid">
        <br />
        <h3 class="sec-title">Best of</h3>
        <div class="row award-center justify-content-between">
            <div class="col-lg-12 awards">
                <div class="container-fluid">
                    <div class="row">
                        <div v-show="mostRunsBadge.human_name" class="col-lg-3 award most-runs">
                            <router-link :to="`/profile/${mostRunsBadge.human_id}`">
                                <div class="circle">
                                    <div class="award-background">
                                        <div class='full-name' align="left">{{ mostRunsBadge.human_name }}</div>
                                        <div class='description' align="left"> Most Runs</div>
                                        <div class="accolade">{{ mostRunsBadge.count }}</div>
                                    </div>
                                </div>
                            </router-link>
                        </div>

                        <div v-show="mostEfficientBadge.human_name" class="col-lg-3 award most-efficient">
                            <router-link :to="`/profile/${mostEfficientBadge.human_id}`">
                                <div class="circle">
                                    <div class="award-background">
                                        <div class='full-name' align="left">{{ mostEfficientBadge.human_name }}</div>
                                        <div class='description' align="left">Most Efficient</div>
                                        <div class="accolade">Most Efficient</div>
                                    </div>
                                </div>
                            </router-link>
                        </div>

                        <div v-show="shortestAverageTimeBadge.human_name" class="col-lg-3 award shortest-average-time">
                            <router-link :to="`/profile/${shortestAverageTimeBadge.human_id}`">
                                <div class="circle">
                                    <div class="award-background">
                                        <div class='full-name' align="left">{{ shortestAverageTimeBadge.human_name }}</div>
                                        <div class='description' align="left">Best Average Time</div>
                                        <div class="accolade"> {{ shortestAverageTimeBadge.count }}</div>
                                    </div>
                                </div>
                            </router-link>
                        </div>

                        <div v-show="mostVideosUploadedBadge.human_name" class="col-lg-3 award most-videos-uploaded">
                            <router-link :to="`/profile/${mostVideosUploadedBadge.human_id}`">
                                <div class="circle">
                                    <div class="award-background">
                                        <div class='full-name' align="left">{{ mostVideosUploadedBadge.human_name }}</div>
                                        <div class='description' align="left">Most uploads</div>
                                        <div class="accolade">{{ mostVideosUploadedBadge.count }}</div>
                                    </div>
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="sec-title">Coaches</h3>
        <div class="row coaches">
            <div class="col-lg-12 justify-content-center professionals">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 pro-image">
                            <button class="hire-btn" align="center">Hire Adam</button>
                        </div>
                        <div class="col-lg-6 pro-content">
                            <h2>Adam Evans</h2>
                            <div class="sport-btn"><p align="center">roping</p></div>
                            <p class="pro-description">Lorem ipsum ana init elo tu reinay</p>
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4">
                                        <!-- NEEDS THUMBNAIL AND LINK TO VIDEO -->
                                        <div class="coach-vid"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="coach-vid"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="coach-vid"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <h3 class="sec-title">Roping</h3>
        <div class="row roping-videos justify-content-between">
            <!-- NEEDS THUMBNAIL AND LINK TO VIDEO -->
            <div class="col-lg-2 rope-vid">
                <div class="vid-thumbnail"></div>
                <div class="vid-description">Vid Title</div>
            </div>
            <div class="col-lg-2 rope-vid">
                <div class="vid-thumbnail"></div>
                <div class="vid-description">Vid Title</div>
            </div>
            <div class="col-lg-2 rope-vid">
                <div class="vid-thumbnail"></div>
                <div class="vid-description">Vid Title</div>
            </div>
            <div class="col-lg-2 rope-vid">
                <div class="vid-thumbnail"></div>
                <div class="vid-description">Vid Title</div>
            </div>
            <div class="col-lg-2 rope-vid">
                <div class="vid-thumbnail"></div>
                <div class="vid-description">Vid Title</div>
            </div>
            <div class="col-lg-2 rope-vid">
                <div class="vid-thumbnail"></div>
                <div class="vid-description">Vid Title</div>
            </div>
        </div>
        <!-- <div class="row hide-on-large-only">
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
        </div> -->

        <!-- <div class="row">
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
        </div> -->
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
