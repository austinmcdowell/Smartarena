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
                                    <router-link :to="`/video/${firstVideo.id}`">
                                        <div class="video" :style="`background-image: url('${firstVideo.thumbnail_url}')`"></div>
                                    </router-link>
                                    
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
                                                        <td><router-link :to="`/run/edit/${run.id}`">Edit</router-link></td>
                                                        <td><router-link :to="`/video/${run.videos[0].id}`">Play</router-link></td>
                                                        <td>{{ run.date }}</td>
                                                        <td>{{ run.event.location }}</td>
                                                        <td>{{ run.stats.header.catch_type }}</td>
                                                        <td>{{ run.stats.heeler.catch_type }}</td>
                                                        <td>{{ run.stats.header.penalty_type }}</td>
                                                        <td>{{ run.stats.header.penalty_time }}</td>
                                                        <td>{{ run.stats.header.penalty_time + run.stats.heeler.penalty_time }}</td>
                                                        <td>{{ run.stats.raw_time }}</td>
                                                        <td>{{ run.stats.total_time }}</td>
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
                                                        <td><router-link :to="`/run/edit/${run.id}`">Edit</router-link></td>
                                                        <td><router-link :to="`/video/${run.videos[0].id}`">Play</router-link></td>
                                                        <td>{{ run.date }}</td>
                                                        <td>{{ run.event.location }}</td>
                                                        <td>{{ run.stats.header.catch_type }}</td>
                                                        <td>{{ run.stats.heeler.catch_type }}</td>
                                                        <td>{{ run.stats.heeler.penalty_type }}</td>
                                                        <td>{{ run.stats.header.penalty_time }}</td>
                                                        <td>{{ run.stats.header.penalty_time + run.stats.heeler.penalty_time }}</td>
                                                        <td>{{ run.stats.raw_time }}</td>
                                                        <td>{{ run.stats.total_time }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </b-tab>
                                    </b-tabs>
                                </b-card>
                            </div>

                            <div class="col-lg-12 uploads">
                                <h5>Recent Uploads</h5>
                                <div class="container">
                                    <div class="row roping-videos justify-content-between">
                                        <div class="col-sm-12 col-lg-4 rope-vid" v-for="video in uploadedVideos" :key="video.id"><video-cell :video="video"></video-cell></div>
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

export default {
    mounted() {
        let $this = this;
        let profileId = this.$route.params.id; 

        if (!profileId) {
            alert('There has been an error. Please contact support.');
            return;
        }

        if (window.user) {
            this.user = window.user;
        }

        axios.get(`/profile/${this.$route.params.id}`).then(response => {
            let data = response.data;

            $this.headerRuns = data.headerRuns;
            $this.heelerRuns = data.heelerRuns;
            $this.human      = data.human;
            $this.uploadedVideos = data.uploadedVideos;
            $this.associatedVideos = data.associatedVideos;

            if ($this.uploadedVideos.length) {
                $this.firstVideo = $this.uploadedVideos[0];
            } else if ($this.associatedVideos.length) {
                $this.firstVideo = $this.associatedVideos[0];
            }

        }).catch(e => {
            alert('There has been an error. Please contact support.')
        })
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
