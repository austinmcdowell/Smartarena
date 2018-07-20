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
    const videoId = this.$route.params.id;

    if (videoId) {
      axios.get(`/video/${videoId}`).then(response => {
        let data = response.data;
        $this.video = data;
      }).catch(e => {
          console.log(e);
          // window.history.back();
        });
      
    } else {
      window.history.back();
    }
  },
  data() {
    return {
      video: {}
    };
  }
};
</script>
