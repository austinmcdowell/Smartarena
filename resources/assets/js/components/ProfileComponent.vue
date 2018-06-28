<template>
    <div>
        <div class="row">
            <div class="col s12 banner">
                <div class="teamroping-header">
                    <div class="col s12 center-align profile-info">
                        <h1 class="human-name" v-text="`${human.first_name} ${human.last_name}`"></h1>
                        <span class="sport-title">Team Roping</span>
                        <span class="location">{{ human.location }}</span>
                        <div class="hire-btn"><h5 align="center"><b>Hire {{ human.first_name }}</b></h5></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row hide-on-large-only">
            <div class="col offset-s2 s8 actions" v-if="user && human.user_id === user.id">
                <a href="/videos/new" class="waves-effect waves-light btn">Upload Video</a>
            </div>
        </div>

        <!-- Recently Uploaded -->
        <div v-if="uploadedVideos.length">
            <div class="row hide-on-large-only center-align">
                <div class="col s10 offset-s1">
                    <h4>Recently Uploaded</h4>
                </div>
            </div>

            <div class="row hide-on-large-only" v-for="video in uploadedVideos" :key="video.id">
                <div class="col s10 offset-s1">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12">
                                    <p>Filename: {{ video.file_name }}</p>
                                    <p>Uploaded at: {{ video.created_at }}</p>
                                </div>
                            </div>
                            <div class="row" v-if="video.processing_complete">
                                <div class="col s12 center-align">
                                    <img style="width: 100%" :src="video.thumbnail_url" alt="">
                                </div>
                            </div>
                            
                            <div class="row" v-if="user && human.user_id === user.id">
                                <div class="col s12 center-align">
                                    <router-link :to="`/teamroping/new/${video.id}`" class="waves-effect waves-light btn">Add Statistics</router-link>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12 center-align">
                                    <router-link v-if="video.processing_complete" class="waves-effect waves-light btn play-button" :to="`/video/${video.id}`">Play Video</router-link>
                                    <a v-else class="waves-effect waves-light btn disabled" href="#">Processing...</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

  
        <!-- Header Runs -->
        <div v-if="headerRuns.length" class="row hide-on-large-only center-align">
            <div class="col s10 offset-s1">
                <h4>Header Runs</h4>
            </div>
        </div>
        <div class="row hide-on-large-only">
            <div class="col s10 offset-s1" v-for="run in headerRuns" :key="run.id">
                <div class="card">
                    <div class="card-content">
                        <div class="row" v-if="run.videos.length && run.videos[0].processing_complete">
                            <div class="col s12 center-align">
                                <img style="width: 100%" :src="`${run.videos[0].thumbnail_url }`" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <p>Date: {{ run.date }}</p>
                                <p>Event: {{ run.event.location }} </p>
                                <p>Header Catch: {{ run.header_catch_type }}</p>
                                <p>Heeler Catch: {{ run.heeler_catch_type }}</p>
                                <p>Header Penalty: {{ run.header_penalty_type }}</p>
                                <p>Penalties: {{ run.header_penalty_time }}</p>
                                <p>Total Run Penalties: {{ run.header_penalty_time + run.heeler_penalty_time }}</p>
                                <p>Raw Time: {{ run.raw_time }}</p>
                                <p>Total Time: {{ run.total_time }}</p>
                            </div>
                        </div>
                    
                        <div class="row" v-if="user && human.user_id === user.id"> 
                            <div class="col s12 center-align">
                                <router-link :to="`/teamroping/${run.id}/edit`" class="waves-effect waves-light btn">Edit Run</router-link>
                            </div>
                        </div>

                        <div class="row" v-if="run.videos.length">
                            <div class="col s12 center-align">
                                <router-link v-if="run.videos[0].processing_complete" class="waves-effect waves-light btn play-button" :to="`/videos/${run.videos[0].id}`">Play Video</router-link>
                                <a v-else class="waves-effect waves-light btn disabled" href="#">Processing...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Heeler Runs -->
        <div v-if="heelerRuns.length" class="row hide-on-large-only center-align">
            <div class="col s10 offset-s1">
                <h4>Heeler Runs</h4>
            </div>
        </div>
        <div class="row hide-on-large-only">
            <div v-for="run in heelerRuns" :key="run.id" class="col s10 offset-s1">
                <div class="card">
                    <div class="card-content">
                        <div v-if="run.videos.length && run.videos[0].processing_complete" class="row">
                            <div class="col s12 center-align">
                                <img style="width: 100%" :src="`${run.videos[0].thumbnail_url}`" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <p>Date: {{ run.date }}</p>
                                <p>Event: {{ run.event.location }} </p>
                                <p>Header Catch: {{ run.header_catch_type }}</p>
                                <p>Heeler Catch: {{ run.heeler_catch_type }}</p>
                                <p>Header Penalty: {{ run.heeler_penalty_type }}</p>
                                <p>Penalties: {{ run.heeler_penalty_time }}</p>
                                <p>Total Run Penalties: {{ run.header_penalty_time + run.heeler_penalty_time }}</p>
                                <p>Raw Time: {{ run.raw_time }}</p>
                                <p>Total Time: {{ run.total_time }}</p>
                            </div>
                        </div>
                        
                        <div v-if="user && human.user_id === user.id" class="row">
                            <div class="col s12 center-align">
                                <router-link :to="`/teamroping/${run.id}/edit`" class="waves-effect waves-light btn">Edit Run</router-link>
                            </div>
                        </div>
          
                        <div v-if="run.videos.length && run.videos[0].processing_complete" class="row">
                            <div class="col s12 center-align">
                                <router-link v-if="run.videos[0].processing_complete" class="waves-effect waves-light btn play-button" :to="`/videos/${run.videos[0].id}`">Play Video</router-link>
                                <a v-else class="waves-effect waves-light btn disabled" href="#">Processing...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
        </div>

        <div v-if="!uploadedVideos.length && !headerRuns.length && !heelerRuns.length" class="row center-align">
            <div class="col s10 offset-s1">
                <h5>This person doesn't have any runs yet!</h5>
            </div>
        </div>
    </div>
</template>
<script>
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
        }).catch(e => {
            alert('There has been an error. Please contact support.')
        })
    },
    data() {
        return {
            user: {},
            human: {},
            uploadedVideos: [],
            headerRuns: [],
            heelerRuns: [],
        }
    }
};
</script>
