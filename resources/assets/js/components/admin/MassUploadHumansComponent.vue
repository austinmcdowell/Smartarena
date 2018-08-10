<template>
    <div class="content">
        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mass Upload Human Records</h5>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea v-model="csvText" id="textarea1" class="form-control"></textarea>
                                        <label for="textarea1">Paste your human records here</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <button @click="uploadCsv()" class="btn btn-primary">Upload CSV</button>
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
            csvText: null
        }
    },
    methods: {
        uploadCsv() {
            const csvData = this.csvText.split('\n');
            let parsedCSVData = [];

            for (let i = 1; i < csvData.length; i++) {
                let record = csvData[i].split(',');
                parsedCSVData.push({
                    importId: record[0],
                    classification: parseInt(record[1], 10),
                    firstName: record[2],
                    lastName: record[3],
                    location: record[4],
                    type: 'standard'
                });
            }
            
            axios.post('/massupload/humans/process', parsedCSVData).then(response => {
                alert('Humans imported successfully!');
            }).catch(e => {
                alert('There was an error.');
            });
        }
    }
}
</script>