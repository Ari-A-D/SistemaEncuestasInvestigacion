$(document).ready(function() {
  $('#login-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'verificacion_creador.php',
      data: $(this).serialize(),
      success: function(data) {
        if (data === 'success') {
          window.location.href = 'menu.php';
        } else {
          $('#message').html('<div class="alert alert-danger">DNI o contraseña incorrectos. Por favor, intente de nuevo.</div>');
        }
      }
    });
  });
});
