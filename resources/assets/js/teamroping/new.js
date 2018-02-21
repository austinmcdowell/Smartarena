$(document).ready(function() {
  const STEPPER_SELECTOR_HEIGHT = 84;
  let stepperContent = $('.step-content');
  let stepper = $('.stepper');
  let form = $('#runForm');
  let nextButton = $('.next-step-button');
  let isSaving = false;

  // Form elements
  let dateField   = $('#date');
  let eventSelect = $('#event-select');
  let ropingField = $('#roping');
  let roundField  = $('#round');
  let timeField   = $('#time');
  let headerSelect = $('#header-select');
  let headerCatchCheckbox = $('header_did_catch');
  let heelerSelect = $('#heeler-select');
  let heelerCatchCheckbox = $('heeler_did_catch');


  function resizeStepper() {
    let stepperSize = stepperContent.prop('scrollHeight') + STEPPER_SELECTOR_HEIGHT;
    stepper.css('height', stepperSize);
  }

  stepper.activateStepper();
  resizeStepper();
  
  stepper.on('stepchange', function() {
    resizeStepper();
  });

  dateField.pickadate({
    selectMonths: true, 
    selectYears: 15,
    today: 'Today',
    clear: 'Clear',
    close: 'Ok',
    closeOnSelect: true 
  });
  
  form.validate({
    rules: {
      'date': {
        date: true
      },
      'event-select': {
        required: true
      },
      'time': {
        required: true
      },
      'header-select': {
        required: true
      },
      'heeler-select': {
        required: true
      }
    },
    errorPlacement: function(error, element) {
      let errorText = error[0].innerText;
      let siblingLabel = $(element.siblings('label')[0]);
      siblingLabel.text(errorText);
      siblingLabel.css('color', '#ee6e73')
    }
  });

  nextButton.on('click', function(e) {
    e.preventDefault();
    if (isSaving) { return; }
    isSaving = true;

    if (form.valid()) {
      nextButton.text('Saving...');
      nextButton.css('background-color', '#ee6e73');

      let payload = {};
      payload.date = dateField.val();
      payload.eventId = eventSelect.val();
      payload.roping = ropingField.val();
      payload.round  = roundField.val();
      payload.time   = timeField.val();
      payload.headerId = headerSelect.val();
      payload.headerDidCatch = headerCatchCheckbox.val();
      payload.heelerId = heelerSelect.val();
      payload.heelerDidPatch = heelerCatchCheckbox.val();

      $.post('/teamroping', payload, function(data) {
        stepper.nextStep();
      }).fail(function() {
        alert('Something went wrong. Please try again later.');
      }).always(function() {
        nextButton.text('Continue');
        nextButton.css('background-color', '#26a69a');
        isSaving = false;
      });

    } else {
      console.log('abort!');
      isSaving = false;
    }
  });

});