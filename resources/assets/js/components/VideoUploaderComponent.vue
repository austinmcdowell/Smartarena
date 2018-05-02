<template>
  <div>
    <div class="row video-uploader">
      <div class="col s12 offset-l3 l6">
        <div @drop="uploadFromDrop" class="card upload-card">
          <div class="card-content">
            <div class="input-field col s12 file-upload">
              <input id="file" name="file" type="file">
              <label for="file">Upload Your Video</label>
            </div>
            <div v-show="percentageUploaded > 0" class="progress upload-progress">
                <div class="determinate" style="width: 0%"></div>
            </div>
            <div v-show="uploadedVideo.id" class="row">
              <div class="col s12 upload-action-buttons">
                <a :href="'/profile/' + humanId" class="waves-effect waves-light btn">Continue</a>
                <p><a :href="`/teamroping/new/${uploadedVideo.id}`">...or add statistics</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</template>
<script>
  import EventBus from './EventBus';

  export default {
    mounted() {
      // keep browser from leaving page
      $(window).on('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
      });

      $(window).on('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
      });

      this.humanId = window.SA.humanId;
    },
    data() {
      return {
        percentageUploaded: 0,
        uploadedVideo: {},
        humanId: null
      }
    },
    watch: {
      percentageUploaded: function(percentageUploaded) {
        $('.upload-progress .determinate').css('width', percentageUploaded + '%');
      }
    },
    methods: {
      uploadFromDrop: function(e) {
        let file = e.dataTransfer.files[0];
        this.uploadVideo(file);
      },
      uploadFromForm: function(e) {
        e.preventDefault();
        let file = (e.srcElement.files[0]);
        this.uploadVideo(file);
      },
      uploadVideo: function(file) {
        let $this = this;
        let form = new FormData();
        form.append('video', file);

        // check for video id so we can overwrite

        if (['video/mp4', 'video/quicktime'].indexOf(file.type) === -1) {
          alert(`The only file type we currently accept is MP4. This file type is ${file.type}`);
          return;
        }

        this.percentageUploaded = 0;

        axios.post('/videos/upload', form, {
          onUploadProgress: function(progressEvent) {
            $this.percentageUploaded = Math.round(progressEvent.loaded / progressEvent.total * 100);
          }
        }).then(response => {
          $this.uploadedVideo = response.data;
        });
      }
    } 
  }
</script>