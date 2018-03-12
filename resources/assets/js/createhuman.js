$(document).ready(function() {
  let classificationInput = $('#classification');
  let firstNameInput      = $('#first_name');
  let lastNameInput       = $('#last_name');
  let emailInput          = $('#email');
  let phoneInput          = $('#phone');
  let locationInput       = $('#location');

  $('.upload-button').on('click', function(e) {
    e.preventDefault();
    let classification = parseInt(classificationInput.val());
    let firstName = firstNameInput.val();
    let lastName  = lastNameInput.val();
    let email     = emailInput.val();
    let phone     = phoneInput.val();
    let location  = locationInput.val();

    let payload = {
      classification: classification,
      firstName: firstName,
      lastName: lastName,
      email: email,
      phone: phone,
      location: location
    };

    let validationErrors = validate(payload, {
      email: {
        email: true
      }
    });

    if (validationErrors) {
      let error = "";

      for (var i = 0; i < validationErrors['email'].length; i++) {
        error += `${validationErrors['email'][i]}\n`; 
      }

      alert(error);
      return;
    }

    $.post('/createhuman', payload, function(data) {
      if (data.success) {
        alert("Human successfully created.");
      } else {
        alert(data.message);
      }
    });
  });
});