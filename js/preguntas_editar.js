//BOTONES DEL ENCABEZADO
$(document).ready(function() {
  $('#back-button').on('click', function() {
    window.location.href = 'menu.php';
  });
});
//emergente de confirmacion para ir atras  
function confirmExit() {
  if (confirm('¿Estás seguro de que deseas salir de la creación del cuestionario?')) {
    window.location.href = 'menu.php';
    return true;
  } else {
      return false;
  }
}
// DESPLEGABLE PARA CONFIGURAR LAS PREGUNTAS
$(document).ready(function() {
  $(document).on('change', '[id^=opciones]', function() {
    var selectedValue = $(this).val();
    var form = $(this).closest('form'); // Obtiene el formulario al que pertenece el select
    var input = form.find('#cantidad_opciones');
    if (selectedValue >= 2 && selectedValue <= 6) {
      if (input.length == 0) { // Si el input no existe en el formulario, se agrega
        $(this).after('<input type="number" class="form-control" id="cantidad_opciones" placeholder="Cantidad de opciones">');
      } else {
        input.show(); // Si el input existe, se muestra
      }
    } else {
      if (input.length > 0) { // Si el input existe, se oculta
        input.hide();
      }
    }
  });
});

//ENVIO DEL PRIMER FORMULARIO Y DESPLIGUE DEL FORMULARIO EMERGENTE CUANDO ESTE SE ENVIA 

$(document).ready(function() {
  $('#survey-form').on('submit', function(e) {
    e.preventDefault();
    // Obtiene el texto del campo de texto y el DNI del usuario
    var pregunta = $('#pregunta').val();
    var cantidad_opciones;
    if ($("#cantidad_opciones").length) {
      cantidad_opciones = $("#cantidad_opciones").val();
    } else {
      cantidad_opciones = null;
    }                 
    var id_encuesta = $("#id_encuesta").val();
    var opciones = $('#opciones').val();
    // DEL POST ASIGNA LAS ID A CADA UNA DE LAS VARIABLES CREADA
    // Envía una solicitud POST a "nombre_encuesta.php" con el texto y el DNI como datos
    $.post("guardar_preguntas.php", {pregunta: pregunta, id_encuesta: id_encuesta, opciones: opciones, cantidad_opciones: cantidad_opciones }, function(response) {
      var data = JSON.parse(response);
      if (data.status == 'success') {
        var id_pregunta = data.id_pregunta;
        if (opciones == 1) {
          // Si opciones es igual a 1, muestra un mensaje de éxito y limpia las entradas
          $("#message").html('<div class="alert alert-success">Se ha guardado la pregunta.</div>');
          $('#survey-form')[0].reset();
          location.reload();
        } else {
          // Si opciones no es igual a 1, muestra el modal
          $("#message").html('<div class="alert alert-success">Se ha guardado la pregunta.</div>');
          $('#modalForm').modal('show');
          // Obtiene el número de opciones
          var numOpciones = cantidad_opciones;
          // Vacía el formulario del modal
          $('#emergent-form').empty();
          // Agrega los campos de entrada al formulario del modal
          for (var i = 1; i <= numOpciones; i++) {
            $('#emergent-form').append('<div class="form-group"><label for="opcion' + i + '">Opción ' + i + '</label><input type="text" class="form-control" id="opcion' + i + '" placeholder="Escribe la opción ' + i + '"></div>');        }
          // Agrega un campo de entrada oculto con la ID de la pregunta
          $('#emergent-form').append('<input type="hidden" name="id_pregunta" value="' + id_pregunta + '" />');
        }
      } else {
        // Si la respuesta del servidor no es "success", muestra un mensaje de error
        $("#message").html('<div class="alert alert-danger">Hubo un error al guardar la pregunta.</div>');
      }
    });
  });
});


//ENVIO DEL FORMULARIO EMERGENTE OPCIONES QUE DEPENDE DEL ESTATICO
function submitEmergentForm() {
  var opciones = [];
  $('#emergent-form .form-control').each(function() {
    opciones.push($(this).val());
  });
  var id_pregunta = $('#emergent-form input[name="id_pregunta"]').val();
  $.post("guardar_opciones.php", { opciones: opciones, id_pregunta: id_pregunta }, function(data) {
    if (data == "success") {
      $("#modal-message").html('<div class="alert alert-success">Las opciones han sido guardadas exitosamente.</div>');
      $('#modalForm').modal('hide');
      // Limpiar las entradas del formulario estático
      $('#survey-form')[0].reset();
      location.reload();
    } else {
      $("#modal-message").html('<div class="alert alert-danger">Hubo un error al guardar las opciones.</div>');
    }
  });
}
///////////////////////////////////BOTONES EDITAR///////////////////////////////////////////////////////////
//ENVIO DEL FORMULARIO EMERGENTE CARGAR ENCUESTADORES DEL BOTON DEL HEADER
$(document).ready(function() {
  $('#carga-encuestadores').click(function() {
    $('#modalForm-Encuestador').modal('show');
  });
});
$(document).ready(function() {
  $('#submit-btn-encuestador').click(function() {
    var nombre = $('#nombre').val();
    var apellido = $('#apellido').val();
    var edad = $('#edad').val();
    var dni = $('#dni').val();
    var numTramiteDNI = $('#numTramiteDNI').val();
    var id_encuesta = $('#id_encuesta').val();

    $.post("guardar_encuestador.php", { nombre: nombre, apellido: apellido, edad: edad, dni: dni, numTramiteDNI: numTramiteDNI, id_encuesta: id_encuesta }, function(data) {
      if (data == "success") {
        // Mostrar el mensaje de éxito
        $('#modal-message-encuestador').html('<div class="alert alert-success">Encuestador cargado</div>');
        // Limpiar los datos de las entradas
        $('#encuestador-form')[0].reset();
      } else {
        // Mostrar el mensaje de error
        $('#modal-message-encuestador').html('<div class="alert alert-danger">No se ha podido cargar el encuestador</div>');
      }
    });
  });
});
$(document).ready(function() {
  $('#modalForm-Encuestador').on('hidden.bs.modal', function () {
    location.reload();
  });
 });
 
//EDITAR PREGUNTA
$(document).ready(function() {
  $('.edit-button').click(function() {
    var id = $(this).data('id');
    var newDetalle = prompt("Ingrese el nuevo detalle");

    if (newDetalle) {
      $.ajax({
        url: 'update_preguntas.php',
        type: 'POST',
        data: {
          id: id,
          detalle: newDetalle
        },
        success: function(response) {
          location.reload();
        }
      });
    }
  });
});
 
//EDITAR TIPO DE PREGUNTA
$(document).ready(function() {
  $('.edit-button-tipo').click(function() {
    var id = $(this).data('id');
    var tipoNuevo = prompt("Nuevo tipo de pregunta");

    if (tipoNuevo) {
      $.ajax({
        url: 'update_tipo_pregunta.php',
        type: 'POST',
        data: {
          id: id,
          tipo: tipoNuevo
        },
        success: function(response) {
          location.reload();
        }
      });
    }
  });
});
//EDITAR OPCIONES DE RESPUESTA
$(document).ready(function() {
  $('.edit-button-opcion').click(function() {
    var id = $(this).data('id');
    var newDetalle = prompt("Ingrese el nuevo detalle de la respuesta");

    if (newDetalle) {
      $.ajax({
        url: 'update_opciones.php',
        type: 'POST',
        data: {
          id: id,
          detalle: newDetalle
        },
        success: function(response) {
          location.reload();
        }
      });
    }
  });
});
///////////////////////////////////BOTONES ELIMINAR///////////////////////////////////////////////////////////
$(document).ready(function() {
$('.delete-button-opcion').on('click', function() {
  var respuestaID = $(this).data('id');
  $.ajax({
    url: 'eliminar_respuesta.php',
    type: 'POST',
    data: {id_respuesta: respuestaID},
    success: function(response) {
      if (response == 'Respuesta eliminada con éxito') {
        alert(response);
        location.reload();
      } else {
        alert('Error al eliminar la respuesta');
      }
    }
  });
});
});
$(document).ready(function() {
  $('.delete-button-pregunta').on('click', function() {
    var preguntaID = $(this).data('id');
    $.ajax({
      url: 'eliminar_pregunta.php',
      type: 'POST',
      data: {id_preguntas: preguntaID},
      success: function(response) {
        if (response == 'Pregunta eliminada con exito') {
          alert(response);
          location.reload();
        } else {
          alert('Error al eliminar la pregunta');
        }
      }
    });
  });
});

//EDITAR ENCUESTADOR 
$(document).ready(function() {
  $('.edit-Nombre, .edit-Apellido, .edit-DNI, .edit-NumTramiteDNI').on('click', function() {
      // Obtener el nuevo valor del atributo "data-id"
      var nuevoValor = prompt("Por favor, introduce el nuevo valor:");
 
      // Obtener el ID del elemento
      var id = $(this).data('id');
 
      // Obtener el nombre del atributo a actualizar
      var atributo = $(this).attr('class');
      atributo = atributo.replace('edit-', '');
 
      // Enviar una solicitud AJAX al servidor
      $.ajax({
          url: 'update_encuestadores.php',
          type: 'post',
          data: {
              id: id,
              atributo: atributo,
              valor: nuevoValor
          },
          success: function(response) {
              location.reload();
              alert('Los datos se han actualizado correctamente.'); 
          }
      });
  });
 });
 //ELIMINAR ENCUESTADOR
 $(document).ready(function() {
  $('.delete-button-encuestador').on('click', function() {
    // Obtener el ID del elemento
    var id = $(this).data('id');
 
    // Enviar una solicitud AJAX al servidor
    $.ajax({
        url: 'eliminar_encuestador.php',
        type: 'post',
        data: {
            id: id
        },
        success: function(response) {
            alert('Los datos se han eliminado correctamente.');
            // Aquí puedes eliminar la fila de la tabla en el DOM si es necesario
           $(this).closest('tr').remove();
           location.reload();
        }
    });
  });
 });
 //DESCRIPCION VISUAL DEL TIPO DE PREGUNTA
 function changeImageAndText(select) {
  var image = document.getElementById('optionImage');
  var text = document.getElementById('optionText');
  switch(select.value) {
  case '1':
   image.src = 'image/image1.jpg';
   text.innerHTML = 'El encuestado responde con sus propias palabras.';
   break;
  case '2':
   image.src = 'image/image2.jpg';
   text.innerHTML = 'El encuestado solo puede elegir una opción de entre las opciones que se le presentan.';
   break;
  case '3':
   image.src = 'image/image3.jpg';
   text.innerHTML = 'El encuestado puede elegir, de entre las opciones que se le presentan, todas las que considere necesarias.';
   break;
  case '4':
   image.src = 'image/image4.jpg';
   text.innerHTML = 'El encuestado pueda escribir su respuesta si no encuentra ninguna apropiada entre las predefinidas';
   break;
  case '5':
   image.src = 'image/image5.jpg';
   text.innerHTML = 'El encuestado puede elegir más de una opción y, además, escribir una respuesta extra.';
   break;
  default:
   image.src = '';
   text.innerHTML = '';
   break;
  }
 }
 
 window.onload = function() {
  changeImageAndText(document.getElementById('opciones'));
 }
