$(document).ready(function() {
    $('#login-form').on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: 'verificacion_encuestador.php',
        data: $(this).serialize(),
        success: function(data) {
          if (data === 'success') {
            window.location.href = 'formulario_encuestado.php';
          } else {
            $('#message').html('<div class="alert alert-danger">El DNI no esta registrado o no es corrector. Por favor, intente de nuevo.</div>');
          }
        }
      });
    });
  });