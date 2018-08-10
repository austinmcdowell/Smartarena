<template>
    <div class="content">
        <b-card>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <select class="form-control" v-model="selectedHuman">
                                <option value="" disabled selected>Choose profile</option>
                                <option v-for="human in humans" :key="human.id" :value="human">{{ human.first_name + ' ' + human.last_name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="classification" type="text" v-model="selectedHuman.classification" />
                            <label for="classification">Classification</label>
                        </div>
                        <div class="form-group">
                            <select class="form-control" v-model="selectedHuman.type">
                                <option value="standard">Standard</option>
                                <option value="pro">Pro</option>
                            </select>
                            <label for="type">Type</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="firstName" type="text" v-model="selectedHuman.first_name" />
                            <label for="firstName">First Name</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="lastName" type="text" v-model="selectedHuman.last_name" />
                            <label for="lastName">Last Name</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="location" type="text" v-model="selectedHuman.location" />
                            <label for="location">Location</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="email" type="text" v-model="selectedHuman.email" />
                            <label for="email">Email</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="phone" type="text" v-model="selectedHuman.phone" />
                            <label for="phone">Phone number</label>
                        </div>
                        <div class="form-group">
                            <input class="form-control" id="calendly_link" type="text" v-model="selectedHuman.calendly_link" />
                            <label for="calendly_link">Calendly URL</label>
                        </div>

                        <button class="btn btn-primary" @click="save()">Save</button>
                    </div>
                    
                </div>
            </div>
        </b-card>
    </div>
</template>
<script>

export default {
    mounted() {
        let $this = this;

        axios.get('/humans').then(response => {
            $this.humans = response.data;
        });
    },
    data() {
        return {
            selectedHuman: {},
            humans: []
        }
    },
    methods: {
        save() {
            axios.post('/humans/save', this.selectedHuman).then(response => {
                alert('Human saved successfully!');
            }).catch(e => {
                alert('There was an error, please contact support');
            });
        }
    }
}

</script>
