<template>
    <div class="video">
        <router-link :to="`/video/${video.id}`" class="video-wrapper">
            <div class="vid-thumbnail" :style="`background-image: url('${video.thumbnail_url}')`">
                <!-- <div class="vid-time" align="center"><p>0:30</p></div> -->
            </div>
            <div class="vid-content">
                <div class="vid-description"><span v-if="video.human">{{ video.human.first_name }} {{ video.human.last_name }}'s Video</span></div>
                <!-- <div class="vid-views"><span v-if="video.human">{{ video.human.name }}</span> | <span class="light-green">1,001 views</span></div> -->
            </div>
        </router-link>
    </div>
</template>
<script>
export default {
    props: ['video'],
    // data() {
    //     return {
    //         video: {},
    //         human: {}
    //     }
    // }
}
</script>
