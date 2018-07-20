<template>
    <div id="leaderboard" class="container-fluid">
        <h3 class="sec-title">Coaches</h3>
        <carousel :per-page="1" :autoplay="true" :autoplayTimeout="2500" :loop="true" :mouse-drag="false">
            <slide v-for="coach in coaches" :key="coach.id">
                <div class="row coaches">
                    <div class="col-lg-12 justify-content-center professionals">
                        <div class="container-fluid">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 pro-image">
                                    <h2 align="center">{{ coach.first_name }} {{ coach.last_name }}</h2>
                                    
                                </div>
                                <div class="col-sm-12 col-lg-12 pro-content">
                                    <button class="hire-btn" align="center">Hire {{ coach.first_name }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </slide>
        </carousel>

    <table class="table leaderboard-table">
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
        </tbody>
    </table>

    <div class="row">
        <div class="col-lg-10"><h3 class="sec-title">Latest Roping Videos</h3></div>
    </div>
    
    <div class="row leaderboards-videos justify-content-between">
        <!-- NEEDS THUMBNAIL AND LINK TO VIDEO -->
        <div class="col-lg-2 rope-vid">
            <div class="vid-thumbnail" style="background-image: url('/img/cow.jpg');"></div>
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

    </div>
</template>
<script>
export default {    
    mounted() {
        let $this = this;
        axios.get('/leaderboard/teamroping').then(response => {
            let data = response.data;
            $this.humans = data.humans;
            $this.coaches  = data.coaches;
        }).catch(e => {
            alert('There was an error. Please contact support.');
        });
    },
    data() {
        return {
            user: {},
            humans: [],
            coaches: []
        }
    },
    methods: {
        showProfile(humanId) {
            this.$router.push(`/profile/${humanId}`);
        }
    }
}
</script>
