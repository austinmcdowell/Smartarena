$(document).ready(function() {
  // $('#event-select').material_select();

  function parseDate(string) {
      const newDate = new Date(string);
      if (newDate.toJSON === null) {
        return new Date(0);
      } else {
        return newDate;
      }
  }

  function parseBool(string) {
    return (string.toString().trim().toLowerCase() === 'true');
  }

  function parseRun(run, eventId) {
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
      console.log(typeof data);
      if (data.success) {
        alert('Humans imported successfully!');
      } else {
        alert('There was an error.');
      }
    });

  });

});