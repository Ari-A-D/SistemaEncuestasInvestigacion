<?php
session_start();
if (isset($_POST['id_encuesta']) && isset($_POST['accion'])) {
    if ($_POST['accion'] == 'desactivar') {
        $_SESSION['desactivado'][$_POST['id_encuesta']] = true;
    } else if ($_POST['accion'] == 'activar') {
        unset($_SESSION['desactivado'][$_POST['id_encuesta']]);
    }
}
?>
