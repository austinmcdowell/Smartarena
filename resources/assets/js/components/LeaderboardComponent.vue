<template>
    <div id="leaderboard" class="container-fluid">
    <h3 class="sec-title">Coaches</h3>
    <carousel :per-page="1" :autoplay="true" :autoplayTimeout="2500" :loop="true" :mouse-drag="false">
        <slide v-for="coach in coaches" :key="coach.id">
            <div class="row coaches">
                <div class="col-lg-12 justify-content-center professionals">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 pro-image">
                                <button class="hire-btn" align="center">Hire {{ coach.first_name }}</button>
                            </div>
                            <div class="col-lg-6 pro-content">
                                <h2>{{ coach.first_name }} {{ coach.last_name }}</h2>
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
