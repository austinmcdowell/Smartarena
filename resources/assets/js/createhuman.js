$(document).ready(function() {
  let classificationInput = $('#classification');
  let firstNameInput      = $('#first_name');
  let lastNameInput       = $('#last_name');
  let locationInput       = $('#location');

  $('.upload-button').on('click', function(e) {
    e.preventDefault();
    let classification = parseInt(classificationInput.val());
    let firstName = firstNameInput.val();
    let lastName  = lastNameInput.val();
    let location = locationInput.val();

    $.post('/createhuman', {
      classification: classification,
      firstName: firstName,
      lastName: lastName,
      location: location
    }, function(data) {
      if (data.success) {
        alert("Human successfully created.");
      } else {
        alert(data.message);
      }
    });
  });
});