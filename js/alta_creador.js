$(document).ready(function() {
  $('#register-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: 'alta_creador.php',
      data: $(this).serialize(),
      success: function(data) {
        if (data === 'success') {
          $('#message').html('<div class="alert alert-success">Un mail ha sido enviado a su correo para dar el alta a su cuenta. Redirigiendo a la página de inicio...</div>');
          setTimeout(function() {
            window.location.href = 'index.php';
          }, 5000);
        } else if (data === 'El dni ya existe') {
          $('#message').html('<div class="alert alert-danger">El dni ya existe. Por favor, intente de nuevo con un dni diferente.</div>');
        } else if (data === 'La password ya existe') {
          $('#message').html('<div class="alert alert-danger">La password ya existe. Por favor, intente de nuevo con una password diferente.</div>');
        } else {
          $('#message').html('<div class="alert alert-danger">Error en el registro. Por favor, intente de nuevo.</div>');
        }
      }
    });
  });
});
