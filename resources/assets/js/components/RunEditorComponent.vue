<template>
  <div>
    <div v-show="video.processing_complete">
      <video-player ref="videoPlayer"></video-player>
      <div class="row">
        <div class="col s12 center-align">
          <p class="time-label" v-text="this.timeLabelText"></p>
        </div>
      </div>
      <div class="row">
        <div class="col s6 center-align">
          <button @click="setStartTime()" class="waves-effect waves-light btn set-start-button">Set Start</button>
        </div>
        <div class="col s6 center-align">
          <button @click="setEndTime()" class="waves-effect waves-light btn set-end-button">Set End</button>
        </div>
      </div>
    </div>
    <!-- <video-uploader></video-uploader> -->
    <div class="row">
      <div class="col s12">
        <div class="card header-stats">
          <div class="card-content">
            <h4>Header Stats</h4>
            <div class="row">
              <div class="col s4 center-align">
                <div v-bind:class="{ activeCatch: (header.catchType === 'slick horns') }" @click="setHeaderCatchType('slick horns')" class="catch-type-button catch">
                  <span>Slick Horns</span>
                </div>
              </div>
              <div class="col s4 center-align">
                <div v-bind:class="{ activeCatch: (header.catchType === 'neck') }" @click="setHeaderCatchType('neck')" class="catch-type-button catch">
                  <span>Neck</span>
                </div>
              </div>
              <div class="col s4 center-align">
                <div v-bind:class="{ activeCatch: (header.catchType === 'half head') }" @click="setHeaderCatchType('half head')" class="catch-type-button catch">
                  <span>Half Horns</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col s12 center-align">
                <div v-bind:class="{ activeCatchPenalty: (header.catchType === 'missed') }" @click="setHeaderCatchType('missed')" class="catch-type-button penalty">
                  <span>Missed</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col s12">
        <div class="card heeler-stats">
          <div class="card-content">
            <h4>Heeler Stats</h4>
            <div v-bind:class="{ disabled: header.catchType === 'missed' }" class="row">
              <div class="col s4 center-align">
                <div v-bind:class="{ activeCatch: (heeler.catchType === 'clean') }" @click="setHeelerCatchType('clean')" class="catch-type-button catch">
                  <span>Clean</span>
                </div>
              </div>
              <div class="col s4 center-align">
                <div v-bind:class="{ activeCatchPenalty: (heeler.catchType === 'leg') }" @click="setHeelerCatchType('leg')" class="catch-type-button penalty">
                  <span>Leg</span>
                </div>
              </div>
              <div class="col s4 center-align">
                <div v-bind:class="{ activeCatchPenalty: (heeler.catchType === 'missed') }" @click="setHeelerCatchType('missed')" class="catch-type-button penalty">
                  <span>Missed</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col s12">
        <div class="card details">
          <div class="card-content">
            <h4>Details</h4>
            <form class="col s12">
              <div class="row">
                <div class="col s12 input-field">
                  <input v-model="run.date" class="datepicker" placeholder="Date" id="date" type="text">
                  <label for="date">Date</label>
                </div>
              </div>
              <div class="row">
                <div class="col s12 input-field">
                  <select v-model="run.eventId" id="event-select">
                    <option value="0" disabled selected>Choose Event</option>
                    <option v-for="event in events" :key="event.id" :value="event.id">{{ event.location }}</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 input-field">
                  <input v-model="run.roping" placeholder="Roping" id="roping" type="text" class="validate">
                  <label for="roping">Roping</label>
                </div>
              </div>
              <div class="row">
                <div class="col s12 input-field">
                  <input v-model="run.round" placeholder="Round" id="round" type="text" class="validate">
                  <label for="round">Round</label>
                </div>
              </div>
              <div class="row">
                <div class="col s12 input-field">
                  <input v-model="run.time" placeholder="Time" id="time" type="number" class="validate">
                  <label for="time">Time</label>
                </div>
              </div>
              <div class="row">
                <div class="col s6 center-align">
                  <label>
                    <input v-model="run.noTime" type="checkbox" id="no-time" />
                    <span>No Time</span>
                  </label>
                </div>
                <div class="col s6 center-align">
                  <label>
                    <input v-model="run.score" type="checkbox" id="score" />
                    <span>Score</span>
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="col s12 input-field">
                  <h5>Header Select</h5>
                  <select v-model="run.headerId" id="header-select">
                    <option value="0" disabled selected>Choose Header</option>
                    <option v-for="human in humans" :key="human.id" :value="human.id">{{ human.first_name + ' ' + human.last_name }}</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 input-field">
                  <select v-model="header.barrierPenalty" id="header-barrier-penalty">
                    <option value="0" selected>No Barrier Penalty</option>
                    <option value="5">5 Seconds</option>
                    <option value="10">10 Seconds</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 input-field">
                  <h5>Heeler Select</h5>
                  <select v-model="run.heelerId" id="heeler-select">
                    <option value="0" disabled selected>Choose Heeler</option>
                    <option v-for="human in humans" :key="human.id" :value="human.id">{{ human.first_name + ' ' + human.last_name }}</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 input-field">
                  <select v-model="heeler.barrierPenalty" id="heeler-barrier-penalty">
                    <option value="0" selected>No Barrier Penalty</option>
                    <option value="5">5 Seconds</option>
                    <option value="10">10 Seconds</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col s12 l4 offset-l4 center-align">
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
import EventBus from './EventBus';

export default {
  mounted() {
    // get humans, run if we need id, etc, 
    this.events = window.SA.events;
    this.humans = window.SA.humans;

    // Someday we'll account for multiple videos
    this.video  = window.SA.videos[0];
    let $this = this;

    let elem = document.querySelector('.datepicker');
    let instance = M.Datepicker.init(elem, {
      autoClose: true,
      onSelect: function(date) {
        Vue.set($this.run, 'date', date);
        this.close();
      }
    });

    if (this.video.processing_complete) {
      EventBus.$emit('videoSourceChange', this.video);
    }

    if (window.SA.rawRun) {
      let rawRun = window.SA.rawRun;
      Vue.set(this.run, 'id', rawRun.id)
      Vue.set(this.run, 'eventId', rawRun.event_id);
      Vue.set(this.run, 'date', rawRun.date);
      Vue.set(this.run, 'time', rawRun.raw_time);
      Vue.set(this.run, 'roping', rawRun.roping);
      Vue.set(this.run, 'round', rawRun.round);

      Vue.set(this.header, 'barrierPenalty', rawRun.header_barrier_penalty);
      Vue.set(this.run, 'headerId', rawRun.header_human_id);
      if (rawRun.header_catch_type) {
        Vue.set(this.header, 'catchType', rawRun.header_catch_type);
      } else if (rawRun.header_penalty_type) {
        Vue.set(this.header, 'catchType', rawRun.header_penalty_type);
      }

      Vue.set(this.heeler, 'barrierPenalty', rawRun.heeler_barrier_penalty);
      Vue.set(this.run, 'heelerId', rawRun.heeler_human_id);
      if (rawRun.heeler_catch_type) {
        Vue.set(this.heeler, 'catchType', rawRun.heeler_catch_type);
      } else if (rawRun.heeler_penalty_type) {
        Vue.set(this.heeler, 'catchType', rawRun.heeler_penalty_type);
      }

      this.timeLabelText = `Time: ${this.run.time}s`;
    }
  },
  data() {
    return {
      run: {
        heelerId: 0,
        headerId: 0,
        eventId: 0,
      },
      header: { barrierPenalty: 0 },
      heeler: { barrierPenalty: 0 },
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
      Vue.set(this.header, 'catchType', catchType);

      if (catchType === 'missed') {
        Vue.set(this.heeler, 'catchType', null);
      }
    },
    setHeelerCatchType: function(catchType) {
      if (this.header.catchType === 'missed') {
        Vue.set(this.heeler, 'catchType', null);
        return;
      }
      Vue.set(this.heeler, 'catchType', catchType);
    },
    setStartTime() {
      this.startTime = this.$refs.videoPlayer.getCurrentScrobbleTime();
      console.log(this.startTime);
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
        Vue.set(this.run, 'time', timeValue);
      }
    },
    save() {
      let payload = { header: {}, heeler: {} };

      if (this.run.id) {
        payload.runId = this.run.id;
      }

      payload.date = this.run.date;
      payload.eventId = this.run.eventId;
      payload.roping = this.run.roping;
      payload.round = this.run.round;
      payload.time = this.run.time;
      payload.noTime = this.run.noTime;
      payload.score = this.run.score;

      payload.header.humanId = this.run.headerId;
      payload.header.barrierPenalty = this.header.barrierPenalty;
      payload.header.catchType = this.header.catchType;
  
      payload.heeler.humanId = this.run.heelerId;
      payload.heeler.barrierPenalty = this.heeler.barrierPenalty;
      payload.heeler.catchType = this.heeler.catchType;

      payload.videoId = this.video.id;

      // take care of currentVideo

      if (payload.header.humanId === payload.heeler.humanId) {
        alert('The header and heeler cannot both be the same person!');
        return;
      }

      if (!payload.eventId) {
        alert('You must select an event!');
        return;
      }

      if (!payload.header.humanId || !payload.heeler.humanId) {
        alert('You must select both a header and heeler.');
        return;
      }

      axios.post('/teamroping/save', payload).then(data => {
        console.log(data);
        window.location.replace('/profile/' + window.SA.humanId);
      }).catch(e => {
        console.log(e);
        alert("Something went wrong. Please contact support.");
      });
    }
  },
  components: {
    'video-player': VideoPlayerComponent
  }
}
</script>
