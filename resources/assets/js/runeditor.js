$(document).ready(function() {
  let player = videojs('my-video');
  
  let currentVideo = {};
  let currentScrobbleTime = null;
  let startTime = null;
  let endTime = null;

  let onLoad = true;

  // video functions

  let play = function play(file) {
    $('#video-player').show();
    let reader = new FileReader();
    reader.onload = function(videoFile) {
      player.src({ type: 'video/mp4', src: videoFile.target.result});
    }
    reader.readAsDataURL(file);
  }

  let updateLabel = function updateLabel() {
    let timeLabel = $('.time-label');

    if (startTime && !endTime) {
      timeLabel.html('Starting at ' + startTime.toFixed(2) + 's');
    }

    if (startTime && endTime) {
      let timeValue = (endTime - startTime).toFixed(2);
      timeLabel.html(`Time: ${timeValue}s`);
      $('#time').val(timeValue);
    }
  }

  // Catch functions

  let setCatchType = function setCatchType(element, riderType) {
    let isCatch = element.hasClass('catch') ? true : false;
    let catchType = element.data('catch-type');
    let card = $(element.parents('.card')[0]);

    card.find('.catch-type-button').each(function(index, el) {
      let button = $(el);
      button.css({
        'background-color': '#fff',
        'color': '#000'
      });
    });
    
    if (isCatch) {
      if (SA.run[riderType].catchType === catchType && !onLoad) {
        SA.run[riderType].catchType = null;
        return
      }
      SA.run[riderType].catchType = catchType;
      if (SA.run.header.penaltyType) {
        $('.heeler-stats').find('.catch-type-button').each(function(index, el) {
          let button = $(el);
          button.css({
            'background-color': '#fff',
            'color': '#000'
          });
        });
        SA.run.header.penaltyType = null;
      }
      element.css({
        'background-color': '#28a745',
        'color': '#fff'
      });
    } else {
      if (SA.run[riderType].penaltyType === catchType && !onLoad) {
        SA.run[riderType].penaltyType = null;
        return
      }

      // disable heeler stats and clear is header missed
      if (catchType === 'missed') {
        $('#no-time').prop('checked', true);
        if (riderType === 'header') {
          $('.heeler-stats').find('.catch-type-button').each(function(index, el) {
            let button = $(el);
            button.css({
              'background-color': '#ccc',
              'color': '#fff'
            });
          });
          SA.run.heeler.catchType = null;
          SA.run.heeler.penaltyType = null;
        }
      }

      SA.run[riderType].penaltyType = catchType;
      SA.run[riderType].catchType = null;
      element.css({
        'background-color': 'red',
        'color': '#fff'
      });
    }
  }

  // Set Field Values on Load (for Edits)

  let setFieldValues = function setFieldValues() {
    $('#date').val(SA.run.date);
    $('#event-select').val(SA.run.eventId);
    $('#roping').val(SA.run.roping);
    $('#round').val(SA.run.round);
    $('#time').val(SA.run.time);
    $('.time-label').html(`Time: ${SA.run.time}s`);

    $('#no-time').prop('checked', SA.run.noTime);
    $('#score').prop('checked', SA.run.score);

    $('#header-select').val(SA.run.header.humanId);
    $('#header-barrier-penalty').val(SA.run.header.barrierPenalty);

    $('#heeler-select').val(SA.run.heeler.humanId);
    $('#heeler-barrier-penalty').val(SA.run.heeler.barrierPenalty);

    if (SA.run.header.catchType) {
      console.log(SA.run.header.catchType)
      let element = $($('.header-stats').find(`[data-catch-type='${SA.run.header.catchType}']`)[0]);
      setCatchType(element, 'header');
    } else if (SA.run.header.penaltyType) {
      let element = $($('.header-stats').find(`[data-catch-type='${SA.run.header.penaltyType}']`)[0]);
      setCatchType(element, 'header');
    }

    if (SA.run.heeler.catchType) {
      let element = $($('.heeler-stats').find(`[data-catch-type='${SA.run.heeler.catchType}']`)[0]);
      setCatchType(element, 'heeler');
    } else if (SA.run.heeler.penaltyType) {
      let element = $($('.heeler-stats').find(`[data-catch-type='${SA.run.heeler.penaltyType}']`)[0]);
      setCatchType(element, 'heeler');
    }

    onLoad = false;
  }

  let uploadVideo = function uploadVideo(file) {
    let form = new FormData();
    form.append('video', file);
    if (SA.run.runId) {
      form.append('runId', SA.run.runId);
    }

    if (['video/mp4', 'video/quicktime'].indexOf(file.type) === -1) {
      alert(`The only file type we currently accept is MP4. This file type is ${file.type}`);
      return;
    }

    play(file);

    $.ajax({
      type: 'POST',
      processData: false,
      contentType:  false,
      data: form,
      url: '/teamroping/upload',
      beforeSend: function(request, xhr) {        
        $('.upload-progress').show();
        $('.upload-progress .determinate').css('width', '0%');
        $('.save-button').addClass('disabled');
      },
      xhr: function() {
        let xhr = $.ajaxSettings.xhr() ;
        
        xhr.upload.onprogress = function(data){
          let perc = Math.round((data.loaded / data.total) * 100);
          $('.upload-progress .determinate').css('width', perc + '%');
        };

        return xhr;
      },
      error: function() {
        alert('Something went wrong. Please contact support.');
      },
      success: function(data) {
        currentVideo = data;
        currentVideo.newUpload = true;
        $('.save-button').removeClass('disabled');
      }
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

  $('.set-start-button').on('click', function(e) {
    e.preventDefault();
    startTime = currentScrobbleTime;
    updateLabel();
  });

  $('.set-end-button').on('click', function(e) {
    e.preventDefault();
    if (!startTime) {
      startTime = 0.0;
    }

    if (currentScrobbleTime < startTime) {
      return;
    }

    endTime = currentScrobbleTime;
    updateLabel();
  });

  player.on('timeupdate', function() {
    currentScrobbleTime = player.currentTime();
  });

  $('#time').on('change', function(e) {
    let $this = $(this);
    $('.time-label').html(`Time: ${$this.val()}s`)
  });

  $('.upload-card').on('drop', function(e) {
    let file = e.originalEvent.dataTransfer.files[0];
    uploadVideo(file);
  });

  $('#file').on('change', function(e) {
    e.preventDefault();
    let file = (e.originalEvent.srcElement.files[0]);
    uploadVideo(file);
  });

  $('.header-stats .catch').on('click', function(e) {
    e.preventDefault();
    let element = $(this);
    setCatchType(element, 'header');
  });

  $('.header-stats .penalty').on('click', function(e) {
    e.preventDefault();
    let element = $(this);
    setCatchType(element, 'header');
  });

  $('.heeler-stats .catch').on('click', function(e) {
    e.preventDefault();
    let element = $(this);
    if (SA.run.header.penaltyType !== 'missed') {
      setCatchType(element, 'heeler');
    }
  });

  $('.heeler-stats .penalty').on('click', function(e) {
    e.preventDefault();
    let element = $(this);
    if (SA.run.header.penaltyType !== 'missed') {
      setCatchType(element, 'heeler');
    }
  });

  // Save Button
  $('.save-button').on('click', function(e) {
    e.preventDefault();

    SA.run.date = $('#date').val();
    SA.run.eventId = $('#event-select').val();
    SA.run.roping  = $('#roping').val();
    SA.run.round   = $('#round').val();
    SA.run.time    = $('#time').val();
    
    if ($('#no-time').val() === "on") {
      SA.run.noTime = true;
    } else {
      SA.run.noTime = false;
    }

    if ($('#score').val() === "on") {
      SA.run.score = true;
    } else {
      SA.run.score = false;
    }
    
    SA.run.header.humanId = $('#header-select').val();
    SA.run.header.barrierPenalty = $('#header-barrier-penalty').val();
    SA.run.heeler.humanId = $('#heeler-select').val();
    SA.run.heeler.barrierPenalty = $('#heeler-barrier-penalty').val();
    SA.run.currentVideo = currentVideo;

    if (SA.run.header.humanId === SA.run.heeler.humanId) {
      alert('The header and heeler cannot both be the same person!');
      return;
    }

    if (!SA.run.eventId) {
      alert('You must select an event!');
      return;
    }

    if (!SA.run.header.humanId || !SA.run.heeler.humanId) {
      alert('You must select both a header and heeler.');
      return;
    }

    $.ajax({
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(SA.run),
      url: '/teamroping/save',
      success: function(data) {
        window.location.replace('/profile/' + SA.humanId);
      },
      error: function(xhr, textStatus, error) {
        console.log(xhr, textStatus, error);
        alert("Something went wrong. Please contact support.");
        //window.history.back();
      }
    })
  });

  // init:

  // A video exists on load
  // let's show the video player and hide the uploader.

  if (SA.videos.length) {
    $('#video-player').show();
    let video  = SA.videos[0];
    player.src({ type: 'video/mp4', src: video.file_url});
    player.play();
  }

  // Create SA.run object
  SA.run = {
    header: {},
    heeler: {}
  }

  if (SA.rawRun) {
    SA.run.runId = SA.rawRun.id;
    SA.run.eventId = SA.rawRun.event_id;
    SA.run.date = SA.rawRun.date;

    SA.run.header.barrierPenalty = SA.rawRun.header_barrier_penalty;
    SA.run.header.catchType = SA.rawRun.header_catch_type;
    SA.run.header.humanId = SA.rawRun.header_human_id;
    SA.run.header.penaltyType = SA.rawRun.header_penalty_type;

    SA.run.heeler.barrierPenalty = SA.rawRun.heeler_barrier_penalty;
    SA.run.heeler.catchType = SA.rawRun.heeler_catch_type;
    SA.run.heeler.humanId = SA.rawRun.heeler_human_id;
    SA.run.heeler.penaltyType = SA.rawRun.heeler_penalty_type;

    SA.run.time = SA.rawRun.raw_time;
    SA.run.roping = SA.rawRun.roping;
    SA.run.round = SA.rawRun.round;

    setFieldValues();
  }

  // Date picker initializer
  $('#date').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: true // Close upon selecting a date,
  });

});