<template>
  <div>
    <div v-show="video.processing_complete">
      <video-player :video-id="video.id" ref="videoPlayer"></video-player>
      <div class="row">
        <div class="col-sm-12 center-align">
          <p class="time-label" v-text="this.timeLabelText"></p>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6 center-align">
          <button @click="setStartTime()" class="waves-effect waves-light btn set-start-button">Set Start</button>
        </div>
        <div class="col-sm-6 center-align">
          <button @click="setEndTime()" class="waves-effect waves-light btn set-end-button">Set End</button>
        </div>
      </div>
    </div>
    <!-- <video-uploader></video-uploader> -->
    <div class="row">
      <div class="col-sm-12">
        <div class="card header-stats">
          <div class="card-content">
            <h4>Header Stats</h4>
            <div class="row">
              <div class="col-sm-4 center-align">
                <div v-bind:class="{ activeCatch: (run.stats.header.catch_type === 'slick horns') }" @click="setHeaderCatchType('slick horns')" class="catch-type-button catch">
                  <span>Slick Horns</span>
                </div>
              </div>
              <div class="col-sm-4 center-align">
                <div v-bind:class="{ activeCatch: (run.stats.header.catch_type === 'neck') }" @click="setHeaderCatchType('neck')" class="catch-type-button catch">
                  <span>Neck</span>
                </div>
              </div>
              <div class="col-sm-4 center-align">
                <div v-bind:class="{ activeCatch: (run.stats.header.catch_type === 'half head') }" @click="setHeaderCatchType('half head')" class="catch-type-button catch">
                  <span>Half Horns</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 center-align">
                <div v-bind:class="{ activeCatchPenalty: (run.stats.header.penalty_type === 'missed') }" @click="setHeaderPenaltyType('missed')" class="catch-type-button penalty">
                  <span>Missed</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card heeler-stats">
          <div class="card-content">
            <h4>Heeler Stats</h4>
            <div v-bind:class="{ disabled: run.stats.header.penalty_type === 'missed' }" class="row">
              <div class="col-sm-4 center-align">
                <div v-bind:class="{ activeCatch: (run.stats.heeler.catch_type === 'clean') }" @click="setHeelerCatchType('clean')" class="catch-type-button catch">
                  <span>Clean</span>
                </div>
              </div>
              <div class="col-sm-4 center-align">
                <div v-bind:class="{ activeCatchPenalty: (run.stats.heeler.penalty_type === 'leg') }" @click="setHeelerPenaltyType('leg')" class="catch-type-button penalty">
                  <span>Leg</span>
                </div>
              </div>
              <div class="col-sm-4 center-align">
                <div v-bind:class="{ activeCatchPenalty: (run.stats.heeler.penalty_type === 'missed') }" @click="setHeelerPenaltyType('missed')" class="catch-type-button penalty">
                  <span>Missed</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card details">
          <div class="card-content">
            <h4>Details</h4>
            <form>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <date-picker v-model="run.date"></date-picker>
                  <label for="date">Date</label>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <select v-model="run.event_id" id="event-select">
                    <option value="0" disabled selected>Choose Event</option>
                    <option v-for="event in events" :key="event.id" :value="event.id">{{ event.location }}</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <input v-model="run.stats.roping" placeholder="Roping" id="roping" type="text" class="validate">
                  <label for="roping">Roping</label>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <input v-model="run.stats.round" placeholder="Round" id="round" type="text" class="validate">
                  <label for="round">Round</label>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <input v-model="run.stats.time" placeholder="Time" id="time" type="number" class="validate">
                  <label for="time">Time</label>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 center-align">
                  <label>
                    <input v-model="run.stats.no_time" type="checkbox" id="no-time" />
                    <span>No Time</span>
                  </label>
                </div>
                <div class="col-sm-6 center-align">
                  <label>
                    <input v-model="run.stats.score" type="checkbox" id="score" />
                    <span>Score</span>
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <h5>Header Select</h5>
                  <select v-model="run.stats.header.human_id" id="header-select">
                    <option value="0" disabled selected>Choose Header</option>
                    <option v-for="human in humans" :key="human.id" :value="human.id">{{ human.first_name + ' ' + human.last_name }}</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <select v-model="run.stats.header.barrier_penalty" id="header-barrier-penalty">
                    <option value="0" selected>No Barrier Penalty</option>
                    <option value="5">5 Seconds</option>
                    <option value="10">10 Seconds</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <h5>Heeler Select</h5>
                  <select v-model="run.stats.heeler.human_id" id="heeler-select">
                    <option value="0" disabled selected>Choose Heeler</option>
                    <option v-for="human in humans" :key="human.id" :value="human.id">{{ human.first_name + ' ' + human.last_name }}</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 input-field">
                  <select v-model="run.stats.heeler.barrier_penalty" id="heeler-barrier-penalty">
                    <option value="0" selected>No Barrier Penalty</option>
                    <option value="5">5 Seconds</option>
                    <option value="10">10 Seconds</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-lg-4 offset-lg-4 center-align">
                  <a @click.prevent="save()" href="#" class="waves-effect waves-light btn save-button">Save Run</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>
<script>

import VideoPlayerComponent from './VideoPlayerComponent';
import Datepicker from 'vuejs-datepicker';
import EventBus from './EventBus';

export default {
  mounted() {
    const $this = this;
    
    if ($this.$route.params.id) {
      axios.get(`/run/${$this.$route.params.id}`).then(response => {
        let run = response.data;
        $this.run = run;
        $this.video = run.videos[0];
      });
    }

    axios.get('/events').then(response => {
      $this.events = response.data;
      return axios.get('/humans');
    }).then(response => {
      $this.humans = response.data;
      if ($this.$route.params.videoId) {
        return axios.get(`/video/data/${$this.$route.params.videoId}`).then(response => {
          $this.video = response.data;
        });
      } else {
        Promise.resolve();
      }
    }).catch(e => {
      alert('There was an error, please contact support.');
      window.history.back();
    })

    if (this.video.processing_complete) {
      EventBus.$emit('videoSourceChange', this.video);
    }

    if (this.run.id) {
      this.timeLabelText = `Time: ${this.run.stats.time}s`;
    }
  },
  data() {
    return {
      run: {
        id: null,
        event_id: 0,
        stats: {
          header: {
            human_id: null,
            did_catch: false,
            catch_type: null,
            penalty_time: null,
            barrier_penalty: 0
          },
          heeler: {
            human_id: null,
            did_catch: false,
            catch_type: null,
            penalty_time: null,
            barrier_penalty: 0
          },
          no_time: false,
          time: 0,
          raw_time: 0,
          total_time: 0
        }
      },
      events: [],
      humans: [],
      video: {},
      startTime: null,
      endTime: null,
      timeLabelText: 'Time: 0.00s'
    }
  },
  methods: {
    setHeaderCatchType: function(catchType) {
      this.run.stats.header.catch_type = catchType;

      if (this.run.stats.header.penalty_type) {
        this.run.stats.header.penalty_type = null;
      }
    },
    setHeaderPenaltyType: function(penaltyType) {
      if (this.run.stats.header.catch_type) {
        this.run.stats.header.catch_type = null;
      }

      this.run.stats.header.penalty_type = penaltyType;
    },
    setHeelerCatchType: function(catchType) {
      if (this.run.stats.header.catch_type === 'missed') {
        this.run.stats.heeler.catch_type === null;
        return;
      }

      if (this.run.stats.heeler.penalty_type) {
        this.run.stats.heeler.penalty_type = null;
      }

      this.run.stats.heeler.catch_type = catchType;
    },
    setHeelerPenaltyType: function(penaltyType) {
      if (this.run.stats.heeler.catch_type) {
        this.run.stats.heeler.catch_type = null;
      }

      this.run.stats.heeler.penalty_type = penaltyType;
    },
    setStartTime() {
      this.startTime = this.$refs.videoPlayer.getCurrentScrobbleTime();
      this.updateLabel();
    },
    setEndTime() {
      let currentScrobbleTime = this.$refs.videoPlayer.getCurrentScrobbleTime();
      
      if (!this.startTime) {
        this.startTime = 0.0;
      }

      if (currentScrobbleTime < this.startTime) {
        return;
      }

      this.endTime = currentScrobbleTime;
      this.updateLabel();
    },
    updateLabel() {
      if (this.startTime && !this.endTime) {
        this.timeLabelText = `Starting at ${this.startTime.toFixed(2)}s`;
      }

      if (this.startTime && this.endTime) {
        let timeValue = (this.endTime - this.startTime).toFixed(2);
        this.timeLabelText = `Time: ${timeValue}s`;
        this.run.stats.time = timeValue;
      }
    },
    save() {
      let $this = this;
      let payload = this.run;
      payload.video_id = this.video.id;

      if (payload.stats.header.human_id === payload.stats.heeler.human_id) {
        alert('The header and heeler cannot both be the same person!');
        return;
      }

      if (!payload.event_id) {
        alert('You must select an event!');
        return;
      }

      if (!payload.stats.header.human_id || !payload.stats.heeler.human_id) {
        alert('You must select both a header and heeler.');
        return;
      }

      axios.post('/run/save', payload).then(data => {
        $this.$router.push('/profile/' + window.user.human.id);
      }).catch(e => {
        console.log(e);
        alert("Something went wrong. Please contact support.");
      });
    }
  },
  components: {
    'video-player': VideoPlayerComponent,
    'date-picker': Datepicker
  }
}
</script>
