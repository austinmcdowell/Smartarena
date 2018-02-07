$(document).ready(function() {
  const STEPPER_SELECTOR_HEIGHT = 84;
  let stepperContent = $('.step-content');


  function resizeStepper() {
    let stepperSize = stepperContent.prop('scrollHeight') + STEPPER_SELECTOR_HEIGHT;
    $('.stepper').css('height', stepperSize);
  }

  $('.stepper').activateStepper();
  resizeStepper();
  
  $('.stepper').on('stepchange', function() {
    resizeStepper();
  });
  
});