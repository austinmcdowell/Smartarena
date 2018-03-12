$(document).ready(function() {
  let queue = [];

  let parseDate = function parseDate(string) {
      const newDate = new Date(string);
      if (newDate.toJSON === null) {
        return new Date(0);
      } else {
        return newDate;
      }
  }

  let parseBool = function parseBool(string) {
    return (string.toString().trim().toLowerCase() === 'true');
  }

  let parseRun = function parseRun(run, eventId) {
    return {
      file: run[0].trim(),
      date: parseDate(run[1]),
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
      headerCatch: (parseBool(run[11])),
      headerCatchType: run[12].trim(),
      headerPenaltyType: run[13].trim(),
      headerPenaltyTime: parseFloat(run[14]),
      heelerCatch: (parseBool(run[15])),
      heelerCatchType: run[16].trim(),
      heelerPenaltyType: run[17].trim(),
      heelerPenaltyTime: parseFloat(run[18])
    };
  }

  let parseContentsOf = function parseContentsOf(entry) {
    if (entry.isFile) {
      if (entry.name !== '.DS_Store') {
        return prepareForUpload(entry);
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
                  childPromises.push(parseContentsOf(node));
                } else {
                  childPromises.push(prepareForUpload(node));
                }
              }
            });
            resolveEntry(Promise.all(childPromises));
          });
        }));
        resolve(Promise.all(promises));
      });
    }
  }

  let prepareForUpload = function prepareForUpload(fileEntry) {
    return new Promise((resolve, reject) => {
      fileEntry.file((file) => {
        const filename = fileEntry.name;

        queue.push(function() {
          let form = new FormData();
          form.append('video', file);

          if (file.type !== 'video/mp4') {
            alert('The only file type we currently accept is MP4.');
            return Promise.reject();
          }

          return $.ajax({
            type: 'POST',
            processData: false,
            contentType: false,
            data: form,
            url: '/massupload/runs/uploadVideo',
            beforeSend: function(request, xhr) {
              $('.upload-progress .determinate').css('width', '0%');
            },
            xhr: function() {
              let xhr = $.ajaxSettings.xhr() ;
        
              xhr.upload.onprogress = function(data){
                let perc = Math.round((data.loaded / data.total) * 100);
                $('.upload-progress .determinate').css('width', perc + '%');
              };

              return xhr;
            },
            success: function(data) {
              $(`<li>${filename} was uploaded successful!</li>`).appendTo('#successfully-uploaded');
            }
          });

        });
        resolve();
      });
    });
  }

  // disable drag and drop on the window

  $(window).on('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $(window).on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
  });

  $('.upload-card').on('drop', function(e) {
    const length = e.originalEvent.dataTransfer.items.length;
    const parentPromises = [];

    for (let i = 0; i < length; i++) {
      const entry = e.originalEvent.dataTransfer.items[i].webkitGetAsEntry();
      parentPromises.push(parseContentsOf(entry));
    }

    Promise.all(parentPromises).then(function() {
      if (queue.length === 1) {
        return queue[0]();
      } else {
        queue.reduce(function(promiseChain, nextPromise) {
          // All of the items in the queue are functions, but the only way this can run is if we run .then against a promise
          // We first check if promiseChain is a function and if so we call it. After that iteration it'll be a promise object.
          if (typeof promiseChain === 'function') {
            return promiseChain().then((result) => nextPromise().then(Array.prototype.concat.bind(result)), Promise.resolve([]));
          } else {
            return promiseChain.then((result) => nextPromise().then(Array.prototype.concat.bind(result)), Promise.resolve([]));
          }
        });
      }
    })
  });

  $('.upload-button').on('click', function(e) {
    e.preventDefault();
    const csvData = $('.csv-textarea').val().split('\n');
    const eventId = $('#event-select').val();

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
      parsedCSVData.push(parseRun(run, eventId))
    }

    console.log(parsedCSVData);

    $.post('/massupload/runs/process', JSON.stringify(parsedCSVData), function(data) {
      if (data.success) {
        alert('Runs imported successfully!');
      } else {
        alert('There was an error.');
      }
    });

  });

});