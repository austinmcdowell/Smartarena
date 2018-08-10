<template>
    <div class="content">
        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Human Record</h5>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <select v-model="type">
                                            <option selected value="standard">Standard</option>
                                            <option value="pro">Pro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input v-model="classification" class="form-control" placeholder="Classification" id="classification" type="number">
                                        <label for="classification">Classification</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input v-model="firstName" class="form-control" placeholder="First Name" id="first_name" type="text">
                                        <label for="first_name">First Name</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input v-model="lastName" class="form-control" placeholder="Last Name" id="last_name" type="text">
                                        <label for="last_name">Last Name</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input v-model="email" class="form-control" placeholder="Email" id="email" type="text">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input v-model="phone" class="form-control" placeholder="Phone" id="phone" type="text">
                                        <label for="phone">Phone</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input v-model="location" class="form-control" placeholder="Location" id="location" type="text">
                                        <label for="location">Location</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button @click="saveHuman()" class="btn btn-primary">Save Human</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            type: 'standard',
            classification: '',
            firstName: '',
            lastName: '',
            email: '',
            phone: '',
            location: ''
        }
    },
    methods: {
        saveHuman() {
            let payload = {
                type: this.type,
                classification: this.classification,
                firstName: this.firstName,
                lastName: this.lastName,
                email: this.email,
                phone: this.phone,
                location: this.location
            };

            axios.post('/createhuman', payload).then(response => {
                alert('Human successfully created.');
            }).catch(e => {
                alert('There was an error, please contact support.');
            });
        }
    }
}
</script>
