<template>
    <div id="profile">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 banner">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <div class="profile">
                                    <div class="profile-pic"></div>
                                    <h5 class="human-name" v-text="`${human.first_name} ${human.last_name}`" align="center"></h5>
                                    <span class="location" align="center">{{ human.location }}</span>
                                    <div class="profile-stats">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-6 stat-vids">
                                                    <h4 align="center">{{ videoCount }}</h4>
                                                    <h5 align="center">videos</h5>
                                                </div>
                                                <div class="col-6 stat-views">
                                                    <h4 align="center">{{ runCount }}</h4>
                                                    <h5 align="center">runs</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="profile-desc">
                                        <h5><i style="font-size:18px" class="fab fa-twitter s-media"></i>twitter.com</h5>
                                        <h5><i style="font-size:18px" class="fab fa-facebook s-media"></i>facebook.com</h5>
                                    </div> -->
                                    
                                    <div v-if="human.type === 'pro'">
                                        <a class="hire-btn btn" :href="human.calendly_link">Hire {{ human.first_name }}</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-sm-12 col-lg-8 recent-upload">
                                <div class="upload" v-show="firstVideo.id">
                                    <a :href="`/video/${firstVideo.id}`">
                                        <div class="video" :style="`background-image: url('${firstVideo.thumbnail_url}')`"></div>
                                    </a>
                                    
                                    <h5>Watch {{ human.first_name + ' ' + human.last_name }}'s featured video</h5>
                                    <!-- <p>1,001 views | July 13</p> -->
                                </div>

                                <h5 class="no-videos" v-show="!firstVideo.id">This user doesn't have any uploaded videos!</h5>
       
                                <!-- <div class="profile-info">
                                    <h1 class="human-name" v-text="`${human.first_name} ${human.last_name}`"></h1>
                                    <span class="sport-title">Team Roping</span>
                                    <span class="location">{{ human.location }}</span>
                                    <div class="hire-btn"><h5 align="center"><b>Hire {{ human.first_name }}</b></h5></div>
                                </div> -->
                            </div>

                            <div class="col-lg-12">
                                <b-card class="stats" no-body>
                                    <b-tabs card>
                                        <b-tab title="Header" active>
                                            <h5 v-show="!headerRuns.length">This user doesn't have any header runs.</h5>
                                            <table v-show="headerRuns.length" class="table runs-table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Date</th>
                                                        <th>Event</th>
                                                        <th>Header Catch</th>
                                                        <th>Heeler Catch</th>
                                                        <th>Header Penalty</th>
                                                        <th>Penalties</th>
                                                        <th>Total Run Penalties</th>
                                                        <th>Raw Time</th>
                                                        <th>Total Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="run in headerRuns" :key="run.id">
                                                        <td><div v-if="user && user.human"><router-link v-show="run.stats.header.human_id === user.human.id || run.stats.heeler.human_id === user.human.id" :to="`/run/edit/${run.id}`">Edit</router-link></div></td>
                                                        <td><span v-if="run.videos[0] && run.videos[0].processing_complete"><a :href="`/video/${run.videos[0].id}`">Play</a></span><span v-show="run.videos[0] && !run.videos[0].processing_complete">Processing...</span></td>
                                                        <td>{{ run.date }}</td>
                                                        <td>{{ run.event.location }}</td>
                                                        <td>{{ capitalize(run.stats.header.catch_type) }}</td>
                                                        <td>{{ capitalize(run.stats.heeler.catch_type) }}</td>
                                                        <td>{{ capitalize(run.stats.header.penalty_type) }}</td>
                                                        <td>{{ penaltyCount(run) }}</td>
                                                        <td>{{ totalPenaltyTime(run) }}</td>
                                                        <td>{{ run.stats.raw_time }}</td>
                                                        <td>{{ run.stats.total_time.toFixed(2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </b-tab>
                                        <b-tab title="Heeler">
                                            <h5 v-show="!heelerRuns.length">This user doesn't have any heeler runs.</h5>
                                            <table v-show="heelerRuns.length" class="table runs-table">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Date</th>
                                                        <th>Event</th>
                                                        <th>Header Catch</th>
                                                        <th>Heeler Catch</th>
                                                        <th>Heeler Penalty</th>
                                                        <th>Penalties</th>
                                                        <th>Total Run Penalties</th>
                                                        <th>Raw Time</th>
                                                        <th>Total Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="run in heelerRuns" :key="run.id">
                                                        <td><div v-if="user && user.human"><router-link v-show="run.stats.header.human_id === user.human.id || run.stats.heeler.human_id === user.human.id" :to="`/run/edit/${run.id}`">Edit</router-link></div></td>
                                                        <td><span v-if="run.videos[0] && run.videos[0].processing_complete"><a :href="`/video/${run.videos[0].id}`">Play</a></span><span v-show="run.videos[0] && !run.videos[0].processing_complete">Processing...</span></td>
                                                        <td>{{ run.date }}</td>
                                                        <td>{{ run.event.location }}</td>
                                                        <td>{{ capitalize(run.stats.header.catch_type) }}</td>
                                                        <td>{{ capitalize(run.stats.heeler.catch_type) }}</td>
                                                        <td>{{ capitalize(run.stats.heeler.penalty_type) }}</td>
                                                        <td>{{ penaltyCount(run) }}</td>
                                                        <td>{{ totalPenaltyTime(run) }}</td>
                                                        <td>{{ run.stats.raw_time }}</td>
                                                        <td>{{ run.stats.total_time.toFixed(2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </b-tab>
                                    </b-tabs>
                                </b-card>
                            </div>

                            <div class="col-lg-12 uploads" v-show="uploadedVideos.length">
                                <h5>Recent Uploads</h5>
                                <div class="container">
                                    <div class="row roping-videos justify-content-between">
                                        <div class="col-sm-12 col-lg-4 rope-vid" v-for="video in uploadedVideos" :key="video.id">
                                            <video-cell :video="video"></video-cell>
                                            <div style="text-align: center" v-if="user && user.human">
                                                <router-link class="btn btn-primary" v-if="user.human.id === video.human_id" :to="`/run/new/${video.id}`">Add Stats</router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import VideoCellComponent from './VideoCellComponent.vue';
import EventBus from './EventBus';

export default {
    mounted() {
        let $this = this;
        let profileId = this.$route.params.id; 

        if (window.user) {
            this.user = window.user;
        }

        EventBus.$on('searchResultSelected', function(profileId) {
            $this.loadData(profileId);
        });
        
        this.loadData(profileId);
    },
    data() {
        return {
            user: {},
            human: {},
            firstVideo: {},
            associatedVideos: [],
            uploadedVideos: [],
            headerRuns: [],
            heelerRuns: []
        }
    },
    watch: {
        '$route' (to, from) {
            this.clearData();
            let profileId = this.$route.params.id; 
            this.loadData(profileId);
        }
    },
    methods: {
        clearData() {
            this.user = {};
            this.human = {};
            this.firstVideo = {};
            this.associatedVideos = [];
            this.uploadedVideos = [];
            this.headerRuns = [];
            this.heelerRuns = [];
        },
        loadData(profileId) {
            let $this = this;

            if (!profileId) {
                alert('There has been an error. Please contact support.');
                return;
            }

            axios.get(`/profile/${profileId}`).then(response => {
                let data = response.data;

                $this.firstVideo = {};
                $this.headerRuns = data.headerRuns;
                $this.heelerRuns = data.heelerRuns;
                $this.human      = data.human;
                $this.uploadedVideos = data.uploadedVideos;
                $this.associatedVideos = data.associatedVideos;

                // This code will go and find a first video that's used as the Highlighted video
                // Later on we want to refactor this to only use Uploaded videos.
                if ($this.uploadedVideos.length) {
                    $this.firstVideo = $this.uploadedVideos[0];
                } else if ($this.associatedVideos.length) {
                    $this.firstVideo = $this.associatedVideos[0];
                } else if ($this.headerRuns.length) {
                    for (let i = 0; i < $this.headerRuns.length; i++) {
                        if ($this.headerRuns[i].videos.length) { 
                            $this.firstVideo = $this.headerRuns[i].videos[0];
                        } else {
                            continue;
                        }
                    }
                } else if ($this.heelerRuns.length) {
                    for (let i = 0; i < $this.heelerRuns.length; i++) {
                        if ($this.heelerRuns[i].videos.length) { 
                            $this.firstVideo = $this.heelerRuns[i].videos[0];
                        } else {
                            continue;
                        }
                    }
                }

            }).catch(e => {
                console.log(e);
                alert('There has been an error. Please contact support.')
            })
        },
        capitalize(str) {
            if (str) return str.split(' ').map((word) => { return word.charAt(0).toUpperCase() + word.substr(1) }).join(' ');
        },
        penaltyCount(run) {
            let count = 0;

            if (run.stats.header.barrier_penalty) {
                count++;
            }

            if (run.stats.heeler.barrier_penalty) {
                count++;
            }

            if (run.stats.header.penalty_type) {
                count++;
            }

            if (run.stats.heeler.penalty_type) {
                count++;
            }

            return count;
        },
        totalPenaltyTime(run) {
            let time = 0;

            if (run.stats.header.barrier_penalty) {
                time += 5;
            }

            if (run.stats.heeler.barrier_penalty) {
                time += 5;
            }

            if (run.stats.header.penalty_type) {
                time += 5;
            }

            if (run.stats.heeler.penalty_type) {
                time += 5;
            }

            return time;
        }
    },
    computed: {
        runCount() {
            return this.headerRuns.length + this.heelerRuns.length;
        },
        videoCount() {
            return this.associatedVideos.length + this.uploadedVideos.length;
        }
    },
    components: {
        'video-cell': VideoCellComponent
    }
};
</script>
