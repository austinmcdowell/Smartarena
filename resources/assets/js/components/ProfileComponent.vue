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
                                <div class="upload">
                                    <div class="video"></div>

                                    <h5>Rider Name does example run for X Rodeo</h5>
                                    <p>1,001 views | July 13</p>
                                </div>

                                

                                
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
                                            <table class="table runs-table">
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
                                            <table class="table runs-table">
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

            

            <!-- <div class="row recent-upload">
                <div class="col-lg-12">
                    <p>Most Recent Upload</p>
                </div>
                
                <div class="col-lg-6 profile-vid"></div>
                <div class="col-lg-6">
                    <h3>Video Title</h3>
                </div>
                
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h3>Runs</h3>
                </div>
            </div>

            <div class="row run-types">
                <div class="col-lg-2 run-active">
                    <p>Header</p>
                </div>
                <div class="col-lg-2 run">
                    <p align="center">Heeler</p>
                </div>
                <div class="col-lg-2 run">
                    <p align="center">Option 3</p>
                </div>
                <div class="col-lg-2 run">
                    <p align="center">Option 4</p>
                </div>
                <div class="col-lg-2 run">
                    <p align="center">Option 5</p>
                </div>
                <div class="col-lg-2 run">
                    <p align="center">Option 6</p>
                </div>
            </div>
            
            <table class="table profile-table">
                <thead>
                    <tr>
                        <th scope="col">Classification</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                    </tr>
                </thead>
                <tbody>
                    <tr @click="showProfile(human.id)" v-for="human in humans" :key="human.id">
                        <td scope="row">{{ human.classification }}</td>
                        <td>{{ human.first_name }}</td>
                        <td>{{ human.last_name }}</td>
                    </tr>

                    <tr>
                        <td>0</td>
                        <td>Austin</td>
                        <td>McDowell</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>Austin</td>
                        <td>McDowell</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>Austin</td>
                        <td>McDowell</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>Austin</td>
                        <td>McDowell</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>Austin</td>
                        <td>McDowell</td>
                    </tr>
                    <tr>
                        <td>0</td>
                        <td>Austin</td>
                        <td>McDowell</td>
                    </tr>
                </tbody>
            </table>

            <div id="video-modal" class="modal">
                <div class="modal-content">
                    <div id="video-player">
                        <div id="protection">
                            <video id="my-video" class="video-js" autoplay controls data-setup="{}" playsinline>
                                <p class="vjs-no-js">
                                    To view this video please enable JavaScript, and consider upgrading to a web browser that
                                    <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                </p>
                            </video>
                        </div>
                        <div class="row zoom-panel">
                            <div class="col s6 zoom-button center-align">
                                <span class="zoom-in">+</span>
                            </div>
                            <div class="col s6 zoom-button center-align">
                                <span class="zoom-out">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s3 control-button center-align double-rewind">
                            <span><i class="fas fa-angle-double-left"></i></span>
                        </div>
                        <div class="col s3 control-button center-align single-rewind">
                            <span><i class="fas fa-angle-left"></i></span>
                        </div>
                        <div class="col s3 control-button center-align single-forward">
                            <span><i class="fas fa-angle-right"></i></span>
                        </div>
                        <div class="col s3 control-button center-align double-forward">
                            <span><i class="fas fa-angle-double-right"></i></span>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <div v-if="!uploadedVideos.length && !headerRuns.length && !heelerRuns.length" class="row center-align">
                <div class="col s10 offset-s1">
                    <h5>This person doesn't have any runs yet!</h5>
                </div>
            </div> -->
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
            $this.associatedVideos     = data.associatedVideos;
        }).catch(e => {
            alert('There has been an error. Please contact support.')
        })
    },
    data() {
        return {
            user: {},
            human: {},
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
