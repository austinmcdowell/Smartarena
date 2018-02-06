$(document).ready(function() {

  $('.upload-button').on('click', function(e) {
    e.preventDefault();
  
    const csvData = $('.csv-textarea').val().split('\n');
    let parsedCSVData = [];

    for (let i = 1; i < csvData.length; i++) {
      let record = csvData[i].split(',');
      parsedCSVData.push({
        importId: record[0],
        classification: parseInt(record[1], 10),
        firstName: record[2],
        lastName: record[3],
        location: record[4]
      });
    }
    
    $.post('/massupload/humans/process', JSON.stringify(parsedCSVData), function(data) {
      console.log(data);
    });

  });
});