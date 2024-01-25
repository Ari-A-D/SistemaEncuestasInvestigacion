$(document).ready(function() {
    $('#logout-button').on('click', function() {
      $.ajax({
        type: 'POST',
        url: 'destructor_sesion_creador.php',
        success: function() {
          window.location.href = 'acceso_creador.php';
        }
      });
    });
  });


  $(document).ready(function() {
    $('#survey-form').on('submit', function(e) {
      e.preventDefault();
  
      // Obtiene el texto del campo de texto y el DNI del usuario
      var nombre = $('#nombre').val();
      var descripcion = $('#descripcion').val();
      var objetivo = $('#objetivo').val();
      var fecha = $('#fecha').val();
      var id_usuario = $("#id_usuario").val();
     // DEL POST ASIGNA LAS ID A CADA UNA DE LAS VARIABLES CREADA
      // Envía una solicitud POST a "nombre_encuesta.php" con el texto y el DNI como datos
      $.post("nombre_encuesta.php", {nombre: nombre, descripcion: descripcion, objetivo: objetivo, fecha:fecha, id_usuario: id_usuario}, function(data) {
        // Si la respuesta del servidor es "success", muestra un mensaje de éxito
        if (data == "success") {
          $("#message").html('<div class="alert alert-success">La encuesta ha sido guardada exitosamente.</div>');
          setTimeout(function() {
            window.location.href = 'menu.php';
          }, 500);
        } else {
          // Si la respuesta del servidor no es "success", muestra un mensaje de error
          $("#message").html('<div class="alert alert-danger">Hubo un error al guardar la encuesta.</div>');
        }
      });
      // Cierra el modal
      $('#myModal').modal('hide');
    });
  });

///ELIMINAR ENCUESTA
function eliminarEncuesta(idEncuesta) {
  // Confirmar la eliminación
  if (!confirm('¿Estás seguro de que quieres eliminar esta encuesta?')) {
    return;
  }
  // Enviar la solicitud de eliminación al servidor
  $.ajax({
    url: 'destructor_encuesta.php',
    type: 'POST',
    data: {
      id_encuesta: idEncuesta
    },
    success: function(response) {
      // Mostrar un mensaje de confirmación
      var mensaje = $("<div class='alert alert-success'></div>")
        .text("Encuesta eliminada con éxito")
        .appendTo('#mensaje'); // Aquí es donde se selecciona el div
        
      // Eliminar el mensaje después de 2 segundos
      setTimeout(function(){
        mensaje.fadeOut('slow');
      }, 2000);
    },
    error: function() {
      alert('Hubo un error al eliminar la encuesta');
    }
  });
}
//BOTON SEARCH
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().trim().toLowerCase();
    if (value === '') {
      $("#tablaEncuestas tr").show();
    } else {
      $("#tablaEncuestas tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    }
  });
 });

//CONTADOR DE ID ENCUESTAS
function updateRowNumber() {
  $("#tablaEncuestas tbody tr").each(function(index) {
      $(this).find('td:first').html(index + 1);
  });
}

$(document).ready(function() {
  updateRowNumber();
  $("#tablaEncuestas").on('click', '.btn-danger', function() {
      $(this).parents('tr').remove();
      updateRowNumber();
  });
});

//BOTONES ACTIVAR DESACTIVAR FUNCION ACTIVAR O DESACTIVAR LA ENCUESTA
$(document).ready(function(){
  $('.activar').click(function(event){
      event.preventDefault();
      var id_encuesta = $(this).data('id');
      $(this).hide();
      $(this).closest('td').find('.desactivar').show();
      var url = 'formulario_abierto.php?id_encuesta=' + id_encuesta;
      $(this).closest('td').find('.url-link').attr('href', url).text(url).show();
      $.post('set_desactivado.php', {id_encuesta: id_encuesta, accion: 'activar'});
      var qrcode = new QRCode(document.getElementById("qrcode-" + id_encuesta), {
          text: url,
          width: 100,
          height: 100,
      });
      // Guardar el estado en localStorage
      localStorage.setItem('estado-' + id_encuesta, 'activar');
  });
 
  $('.desactivar').click(function(){
      $(this).hide();
      $(this).closest('td').find('.activar').show();
      $(this).closest('td').find('.url-link').hide();
      var id_encuesta = $(this).closest('td').find('.activar').data('id');
      $.post('set_desactivado.php', {id_encuesta: id_encuesta, accion: 'desactivar'});
      document.getElementById("qrcode-" + id_encuesta).innerHTML = "";
      // Guardar el estado en localStorage
      localStorage.setItem('estado-' + id_encuesta, 'desactivar');
  });
 });

 $(document).ready(function(){
  $('.activar, .desactivar').each(function(){
     var id_encuesta = $(this).data('id');
     var estado = localStorage.getItem('estado-' + id_encuesta);
     if (estado === 'activar') {
         $(this).hide();
         $(this).closest('td').find('.desactivar').show();
         $(this).closest('td').find('.url-link').attr('href', 'formulario_abierto.php?id_encuesta=' + id_encuesta).text('formulario_abierto.php?id_encuesta=' + id_encuesta).show();
         var url = 'formulario_abierto.php?id_encuesta=' + id_encuesta;
         var qrcode = new QRCode(document.getElementById("qrcode-" + id_encuesta), {
             text: url,
             width: 100,
             height: 100,
         });
     } else if (estado === 'desactivar') {
         $(this).hide();
         $(this).closest('td').find('.activar').show();
         $(this).closest('td').find('.url-link').hide();
     }
  });
 });
