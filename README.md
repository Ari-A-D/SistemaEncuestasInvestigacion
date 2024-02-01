<h1>Sistemas de encuesta - Fundacion Observar</h1>
<h2>Diagrama funcional</h2>
<div align="center">
  <img src="https://github.com/Ari-A-D/SistemaEncuestasInvestigacion/assets/54744627/322ebd8c-1d9f-4682-ace4-1a3de32b7c64" alt="Diagrama funcional" widht="80%">
  <p style="text-align: center;"><em>Esquema funcional del sistema. Herramienta: Draw.io. Fuente: Elaboracón propia.</em></p>
</div>
<h2>Resumen</h2>
Es un sistema de encuestas para la investigación y el desarrollo de actividades científicas. Se basa en la creacion de encuestas personlizadas, que crea el usuario que hace uso de esta herramienta, para cualquiera que sea su tarea. El mismo permite crear las preguntas, cargar encuestadores que trabajaran para la investigación (si el trabajo lo necesitara), también posee la opción de encuesta abierta, como se ve el en anterior diagrama, donde genera un QR y link, el cual se puede compartir por las redes para que este sea completado de manera personal. En su menu posee funciones como eliminar encuesta, editar, y la opción VER, que te lleva a dashboard que hace seguimiento de esa encuesta, te muestra graficas explicativas/interactivas, junto con un seguimiento de otras caracteristicas, tiene la opción de descargar los datos que se guardan en la base de datos en formato excel.
<h2>Tecnologías</h2>
Realizado con HTML, CSS, Boostrap, PHP, AJAX, JQuery, también se utiliza composer para el logeo, alta, seguridad y recuperación de contraseña.
La base de datos fue realizada en MySQL.
<h2>Caracteristicas</h2>
<ul>
  <li>CRUD para todas las caracteristicas, ya sea para la encuesta, para las preguntas y para la carga de encuestadores</li>
  <li>El borrado de encuesta no borra los datos recolectados en la misma para el usuario, sigue mostrando la información en el dashboard y creando el excel si re requiere</li>
  <li>Los botones activar y desactivar del menu, se refieren a modo, mientras esta activa, esta en modo encuesta abierta, por lo que se la puede completar accediendo por QR o el hipervinculo, sin necesidad de tener acceso a un login encuestador, este modo queda guardado en la memoria del navegador</li>
  <li>Boton SEARCH propuesto para buscar la encuesta por nombre o por numero.</li>
  <li>Las encuestas están ordenada de menor a mayor a medida que se fueron creando</li>
  <li>El ID de las encuestas se pasan por GET pero si un usuario al que no le pertenece intenta acceder a ella, es expulsado del sistema, los insert a base de datos tienen la funcion integrada de PHP anti-inyección de SQL</li>
  <li>El login se da de alta por mail, en su ventana de registro (modalidad realizada con composer), la recuperación de cuenta utiliza la misma tecnología, las contraseñas están encriptadas, tanto la de usuario como la de activación</li>
  <li>Los input de tipo texto tienen restricciones de teclado como también verificacion de parametros, tanto login como alta, el login tiene ocultar contraseña y registro tiene confirmación de contraseña en el momento y si existiera un error, cuando se envia también</li>
  <li>Los encuestadores se cargan cuando se crea la encuesta, junto con la carga de las preguntas y sus encuestadores habilitados, los encuestadores ingresan con otra ventana de login, solo con su DNI</li>
  <li>El dashboard se actualiza y es interactivo, la descarga de excel (no se incluye en el codigo) y el generador de informe del tipo de proyecto (no se incluye en el codigo)</li>
  <li>AVISO: Algunas de las funcionalidades no se cargaron completa, si quiere el codigo completo puede pedir acceso al privado al siguente mail: arianaaracelidiaz@gmail.com</li>
</ul>
<h2>Imagenes</h2>
<div align="center">
  <img src="https://github.com/Ari-A-D/SistemaEncuestasInvestigacion/assets/54744627/f164881f-8b9f-4c2e-84b1-b9074a7aa31b" alt="Diagrama funcional" widht="80%">
  <p style="text-align: center;"><em>Creacion de la encuesta.</em></p>
</div>
<div align="center">
  <img src="https://github.com/Ari-A-D/SistemaEncuestasInvestigacion/assets/54744627/c309c842-e09a-4860-9d09-5d9ee0160c00" alt="Diagrama funcional" widht="80%">
  <p style="text-align: center;"><em>Ventana de edición de la encuesta, cargar las preguntas y encuestadores si los hubiera.</em></p>
</div>
<div align="center">
  <img src="https://github.com/Ari-A-D/SistemaEncuestasInvestigacion/assets/54744627/8f5c3827-79ca-4c96-b69d-2b39b8c530c1" alt="Diagrama funcional" widht="80%">
  <p style="text-align: center;"><em>Ventana Login.</em></p>
</div>
<div align="center">
  <img src="https://github.com/Ari-A-D/SistemaEncuestasInvestigacion/assets/54744627/25a42960-10b4-46c3-881f-05363a3a20d8" alt="Diagrama funcional" widht="80%">
  <p style="text-align: center;"><em>Ventana alta de usuario.</em></p>
</div>
