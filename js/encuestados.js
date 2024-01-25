//BOTON LOGOUT DEL ENCABEZADO
//Cuando se aprieta el boton logout aparece un mensaje de pregunta y destruye la session correspondiente al DNI de usuario
//si es exitosa la destruccion, vuelve a la pagina de acceso
$(document).ready(function() {
    $('#logoutButton').click(function(e) {
        e.preventDefault();
        if (confirm('¿Estás seguro de que quieres cerrar la sesión?')) {
            $.ajax({
                url: 'destructor_sesion_encuestador.php',
                type: 'get',
                success: function(data) {
                    window.location.href = 'acceso_encuestador.php';
                }
            });
        }
    });
});

//FUNCION DEL BOTON SUBMIT DEL ESTATICO FORMULARIO DE DATOS BASICOS
//Cuando se ennvia el formulario con exito muestra un mensaje de exito en cargar datos y luego pone visible al formulario Dinamico
$(document).ready(function() {
    $('#submitButtonStatic').click(function() {
        $.ajax({
            url: 'insertar_encuestado.php',
            type: 'post',
            data: $('#staticForm').serialize(),
            success: function(response) {
                // Muestra el mensaje de éxito
                $('#successMessage').show();
                // Oculta el mensaje de éxito después de 2 segundos
                setTimeout(function() {
                    $('#successMessage').fadeOut('slow');
                }, 2000); // 2000 milisegundos = 2 segundos
    
                // Oculta el formulario
                $('#staticForm').closest('.card').hide();                
                $("#autoconstructor").show();
                // Muestra el ID del encuestado
                console.log(response);
            }
        });
    });       
});
//MANTIENE EL AUCONSTRUCTOR BLOQUEADO HASTA QUE SE ENVIE EL FORMULARIO ESTATICO
function showAutoconstructor() {
    document.getElementById('autoconstructor').style.display = 'block';
 }

