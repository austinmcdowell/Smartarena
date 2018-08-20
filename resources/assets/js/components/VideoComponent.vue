<template>
    <video-player :video-id="video.id"></video-player>
</template>
<script>
import VideoPlayerComponent from "./VideoPlayerComponent.vue";

export default {
  components: {
    "video-player": VideoPlayerComponent
  },
  mounted() {
    const $this = this;
    let videoId;

    if (this.$route) {
      videoId = this.$route.params.id;
    }
    
    if (!videoId) {
      let pathNameArray = window.location.pathname.split('/');
      videoId = pathNameArray[pathNameArray.length - 1];
    }

    if (videoId) {
      axios.get(`/video/data/${videoId}`).then(response => {
        let data = response.data;
        $this.video = data;
      }).catch(e => {
          console.log(e);
          // window.history.back();
        });
      
    } else {
      //window.history.back();
    }
  },
  data() {
    return {
      video: {}
    };
  }
};
</script>
