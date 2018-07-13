<template>
    <div id="profile">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 banner">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="profile-pic"></div>
                            </div>
                            <div class="col-lg-9">
                                <div class="profile-info">
                                    <h1 class="human-name" v-text="`${human.first_name} ${human.last_name}`"></h1>
                                    <span class="sport-title">Team Roping</span>
                                    <span class="location">{{ human.location }}</span>
                                    <div class="hire-btn"><h5 align="center"><b>Hire {{ human.first_name }}</b></h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="row recent-upload">
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

            <!-- Header Runs -->
            <!-- <div v-if="headerRuns.length" class="row center-align">
                <div class="col-lg-12 offset-s1">
                    <h4>Header Runs</h4>
                </div>
            </div> -->
            
            <table class="table profile-table">
                <thead>
                    <tr>
                        <th scope="col">Classification</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr @click="showProfile(human.id)" v-for="human in humans" :key="human.id">
                        <td scope="row">{{ human.classification }}</td>
                        <td>{{ human.first_name }}</td>
                        <td>{{ human.last_name }}</td>
                    </tr> -->

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
            </div>

            <!-- <div v-if="!uploadedVideos.length && !headerRuns.length && !heelerRuns.length" class="row center-align">
                <div class="col s10 offset-s1">
                    <h5>This person doesn't have any runs yet!</h5>
                </div>
            </div> -->
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
