<template>
    <div>
        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Human Linker</h5>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <select v-model="selectedUserId" id="user-select">
                                            <option value="" disabled selected>Choose user</option>
                                            <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <select v-model="selectedHumanId" id="user-select">
                                            <option value="" disabled selected>Choose human</option>
                                            <option v-for="human in humans" :key="human.id" :value="human.id">{{ human.first_name }} {{ human.last_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 offset-sm-4">
                                    <button @click="link()" class="btn btn-primary">Link User and Human</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    mounted() {
        let $this = this;

        axios.get('/user-human-linker-data').then(response => {
            let data = response.data;
            $this.users = data.users;
            $this.humans = data.humans;
        }).catch(e => {
            alert('Something went wrong, please contact support.');
        });
    },
    data() {
        return {
            selectedUserId: null,
            selectedHumanId: null,
            users: [],
            humans: []
        }
    },
    methods: {
        link() {
            if (this.selectedUserId && this.selectedHumanId) {
                axios.post('/link-user-human', { userId: this.selectedUserId, humanId: this.selectedHumanId }).then(response => {
                    alert('User and human linked successfully!');
                }).catch(e => {
                    alert('Something went wrong, please contact support!');
                });
            }
        }
    }
}
</script>