<template>
    <div class="content">
        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Mass Run Uploader</h5>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-field">
                                        <select v-model="selectedEventId" id="event-select">
                                            <option value="" disabled selected>Choose your option</option>
                                            <option v-for="event in events" :key="event.id" :value="event.id">{{ event.location }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-field">
                                        <textarea v-model="csvText" id="textarea1" class="csv-textarea form-control"></textarea>
                                        <label for="textarea1">Paste Your Roping Data Here</label>
                                    </div>
                                </div>
                            </div>

                            <button @click="uploadCSV" class="btn btn-primary">Upload CSV</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <div @drop="uploadFromDrop" class="card">
                    <div class="card-body">
                        <h5 class="card-title">Upload Videos</h5>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-field">
                                        <input @change.prevent="uploadFromForm" id="file" name="file" type="file">
                                        <label for="file">Upload Your Video (not required)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" :style="`width: ${uploadPercentage}%`"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <ul id="successfully-uploaded">
                                        <li v-for="fileName in successfullyUploaded" :key="fileName">{{ fileName }} was uploaded successfully!</li>
                                    </ul>
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
        const $this = this;

        $(window).on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });

        $(window).on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
        });

        axios.get('/massupload/runs/events').then(response => {
            $this.events = response.data;
        }).catch(e => {
            alert('Something went wrong, please contact support.');
        })
    },
    data() {
        return {
            queue: [],
            events: [],
            selectedEventId: null,
            csvText: '',
            successfullyUploaded: [],
            uploadPercentage: 0
        }
    },
    methods: {
        parseDate(string) {
            const newDate = new Date(string);
            if (newDate.toJSON === null) {
                return new Date(0);
            } else {
                return newDate;
            }
        },
        parseBool(string) {
            return (string.toString().trim().toLowerCase() === 'true');
        },
        parseRun(run, eventId) {
            return {
                file: run[0].trim(),
                date: this.parseDate(run[1]),
                eventId: eventId,
                roping: run[2].trim(),
                round: run[3].trim(),
                rawTime: parseFloat(run[4]),
                headerSaid: run[5].trim(),
                headerName: run[6].trim().toLowerCase(),
                headerLocation: run[7].trim().toLowerCase(),
                heelerSaid: run[8].trim(),
                heelerName: run[9].trim().toLowerCase(),
                heelerLocation: run[10].trim().toLowerCase(),
                headerCatch: (this.parseBool(run[11])),
                headerCatchType: run[12].trim(),
                headerPenaltyType: run[13].trim(),
                headerPenaltyTime: parseFloat(run[14]),
                heelerCatch: (this.parseBool(run[15])),
                heelerCatchType: run[16].trim(),
                heelerPenaltyType: run[17].trim(),
                heelerPenaltyTime: parseFloat(run[18])
            };
        },
        parseContentsOf(entry) {
            const $this = this;

            if (entry.isFile) {
                if (entry.name !== '.DS_Store') {
                    return this.prepareForUpload(entry);
                }
            } else {
                const entryReader = entry.createReader();
                const promises    = [];
                return new Promise((resolve, reject) => {
                    promises.push(new Promise((resolveEntry, rejectEntry) => {
                        entryReader.readEntries(entryNodes => {
                            const childPromises = [];
                            entryNodes.forEach(node => {
                                if (node.name !== '.DS_Store') {
                                    if (node.isDirectory) {
                                        childPromises.push($this.parseContentsOf(node));
                                    } else {
                                        childPromises.push($this.prepareForUpload(node));
                                    }
                                }
                            });
                            resolveEntry(Promise.all(childPromises));
                        });
                    }));
                    resolve(Promise.all(promises));
                });
            }
        },
        prepareForUpload(fileEntry) {
            let $this = this;

            return new Promise((resolve, reject) => {
                fileEntry.file((file) => {
                    const filename = fileEntry.name;

                    $this.queue.push(function() {
                        let form = new FormData();
                        form.append('video', file);

                        if (file.type !== 'video/mp4') {
                            alert('The only file type we currently accept is MP4.');
                            return Promise.reject();
                        }

                        $this.uploadPercentage = 0;
                        return axios.post('/massupload/runs/uploadVideo', form, {
                            onUploadProgress: progressEvent  => {
                                $this.uploadPercentage = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                            }
                        }).then(response => {
                            $this.successfullyUploaded.push(filename);
                            return Promise.resolve();
                        }).catch(e => {
                            alert('There has been an error, please contact support.');
                        });
                    });
                    resolve();
                });
            });
        },
        uploadFromForm(e) {

        },
        uploadFromDrop(e) {
            const $this = this;
            const length = e.dataTransfer.items.length;
            const parentPromises = [];

            for (let i = 0; i < length; i++) {
                const entry = e.dataTransfer.items[i].webkitGetAsEntry();
                parentPromises.push(this.parseContentsOf(entry));
            }

            Promise.all(parentPromises).then(function() {
                if ($this.queue.length === 1) {
                    return $this.queue[0]();
                } else {
                    $this.queue.reduce(function(promiseChain, nextPromise) {
                        // All of the items in the queue are functions, but the only way this can run is if we run .then against a promise
                        // We first check if promiseChain is a function and if so we call it. After that iteration it'll be a promise object.
                        if (typeof promiseChain === 'function') {
                            return promiseChain().then((result) => nextPromise().then(Array.prototype.concat.bind(result)), Promise.resolve([]));
                        } else {
                            return promiseChain.then((result) => nextPromise().then(Array.prototype.concat.bind(result)), Promise.resolve([]));
                        }
                    });
                }
            });
        },
        uploadCSV() {
            const $this = this;
            const csvData = this.csvText.split('\n');
            const eventId = this.selectedEventId;

            if (!eventId) {
                alert("You must select an event.");
                return;
            }

            let parsedCSVData = [];
            
            for (let i = 1; i < csvData.length; i++) {
                let run = csvData[i].split(',');
                if (run.length !== 19) {
                    alert('Invalid data. Records do not contain enough data.');
                    break;
                }
                parsedCSVData.push($this.parseRun(run, eventId))
            }
            
            axios.post('/massupload/runs/process', parsedCSVData).then(response => {
                alert('Runs imported successfully!');
            }).catch(e => {
                alert('There was an error.');
            });
        }
    }
}
</script>