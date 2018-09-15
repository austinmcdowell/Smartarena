<template>
    <div id="leaderboard" class="container-fluid">
        <h3 class="sec-title">Hire a Coach</h3>
        <carousel :per-page="1" :autoplay="true" :autoplayTimeout="2500" :loop="true" :mouse-drag="false" paginationColor="rgb(140, 140, 140)">
            <slide v-for="coach in coaches" :key="coach.id">
                <div class="row coaches">
                    <div class="col-lg-12 justify-content-center professionals">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 pro-image">
                                    <h2 align="center">{{ coach.first_name }} {{ coach.last_name }}</h2>
                                    <div>
                                        <a v-show="coach.calendly_link" :href="`/hire/${coach.id}`" class="hire-btn" align="center">Hire {{ coach.first_name }}</a>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12 col-lg-12 pro-content">
                                    <a :href="coach.calendly_link" class="hire-btn" align="center">Hire {{ coach.first_name }}</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </slide>
        </carousel>

        <h3 class="sec-title">Leaderboard</h3>
        <table class="table leaderboard-table">
            <thead>
                <tr>
                    <th scope="col">Quality Videos</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                </tr>
            </thead>
            <tbody>
                <tr @click="showProfile(human.id)" v-for="human in humans" :key="human.id">
                    <td scope="row">{{ human.quality_videos_count }}</td>
                    <td>{{ human.first_name }}</td>
                    <td>{{ human.last_name }}</td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-lg-10"><h3 class="sec-title">Latest Roping Videos</h3></div>
        </div>

        <div class="row roping-videos justify-content-between">
            <div class="col-sm-12 col-md-4 col-lg-3 rope-vid" v-for="video in videos" :key="video.id"><video-cell :video="video"></video-cell></div>
        </div>
    </div>
</template>
<script>
import VideoCellComponent from './VideoCellComponent.vue';

export default {    
    mounted() {
        let $this = this;
        axios.get('/leaderboard/videos').then(response => {
            let data = response.data;
            $this.humans = data.humans;
            $this.coaches  = data.coaches;
            $this.videos = data.videos;
        }).catch(e => {
            alert('There was an error. Please contact support.');
        });
    },
    data() {
        return {
            user: {},
            humans: [],
            coaches: [],
            videos: [],
        }
    },
    methods: {
        showProfile(humanId) {
            this.$router.push(`/profile/${humanId}`);
        }
    },
    components: {
        'video-cell': VideoCellComponent
    }
}
</script>
