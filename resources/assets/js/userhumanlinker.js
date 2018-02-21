$(document).ready(function() {
  let userSelect = $('#user-select');
  let humanSelect = $('#human-select');

  $('.link-button').on('click', function(e) {
    e.preventDefault();
    let userId = userSelect.val();
    let humanId = humanSelect.val();

    $.post('/userhumanlinker', { userId: userId, humanId: humanId }, function(data) {
      if (data.success) {
        alert("Human and User successfully linked.");
      } else {
        alert(data.message);
      }
    });
  });
});