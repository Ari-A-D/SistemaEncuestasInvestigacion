<?php
include 'template/conexion.php';
$id_encuesta = $_GET['id_encuesta']; // Obtén el id de la encuesta de la URL

//Numero de preguntas
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM preguntas WHERE Id_Encuesta = ?");
$stmt->bind_param('i', $id_encuesta);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$numero_de_preguntas = $row['total'];
//Nombre de la encuesta
$stmt = $conn->prepare("SELECT Nombre FROM encuesta WHERE ID = ?");
$stmt->bind_param('i', $id_encuesta);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$nombre_encuesta = $row['Nombre'];
//Total encuestados 
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM encuestados WHERE Id_Encuesta = ?");
$stmt->bind_param('i', $id_encuesta);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_encuestados = $row['total'];
//TRAE LAS PREGUNTAS CON SUS DETALLES DE RESPUESTAS
$sql = "
SELECT 
   preguntas.Detalle AS Pregunta, 
   respuestas.Detalle AS Respuesta, 
   COUNT(encuestados_respuestas.Id_Respuesta) AS Cantidad
FROM 
   preguntas
JOIN 
   respuestas ON preguntas.ID = respuestas.Id_Pregunta
JOIN 
   encuestados_respuestas ON respuestas.ID = encuestados_respuestas.Id_Respuesta
WHERE 
   preguntas.Id_Encuesta = $id_encuesta
GROUP BY 
   preguntas.Detalle, respuestas.Detalle;
";

$resultado = $conn->query($sql);

$histogramData = array();
foreach ($resultado as $row) {
   $histogramData[$row['Pregunta']][] = array('Respuesta' => $row['Respuesta'], 'Cantidad' => $row['Cantidad']);
}

// Devuelve los resultados como JSON
$datosJSON = json_encode($histogramData);

// Cierra la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Dashboard</title>
    <!-- Incluye Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/dashboard.css" type="text/css">
    <script src="js/dashboard.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
  <div class="container-fluid">
    <div class="d-flex justify-content-between w-100">
      <div class="d-flex">
      <button id="back-button" class="btn btn-secondary" type="button">Atrás</button>
      </div>
    </div>
  </div>
</nav>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron text-white">
                <h1 class="display-4"><?php echo $nombre_encuesta; ?></h1>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Número de preguntas</h5>
                                <p class="card-text"><?php echo $numero_de_preguntas; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Total de encuestados</h5>
                                <p class="card-text"><?php echo $total_encuestados; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
   .grid-container {
     display: grid;
     grid-template-columns: repeat(2, 1fr); /* Creates a 2-column grid */
     gap: 10px; /* Adds some space between the charts */
   }
   canvas {
     width: 100%; /* Makes each chart take up the full width of its cell */
   }
 </style>
</head>
<body>
 <style>
  .grid-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Creates a 2-column grid */
    gap: 10px; /* Adds some space between the charts */
  }
  .chart-container {
    width: 100%; /* Makes each chart take up the full width of its cell */
    height: 0; /* Allows the chart to take up any amount of vertical space */
    padding-bottom: 50%; /* Aspect ratio */
    position: relative; /* Needed for positioning the canvas */
  }
  canvas {
    position: absolute; /* Positions the canvas within its container */

  }
 </style>
 <div class="grid-container">
  <?php
   $index = 0;
   foreach ($histogramData as $pregunta => $datos) {
       echo '<div class="chart-container"><canvas id="miGrafico'.$index.'"></canvas></div>';
       $index++;
   }
  ?>
 </div>
 <script>
 window.onload = function() {
  // Get the data from the server
  var datos = <?php echo $datosJSON; ?>;

  // Convert the PHP array to a JSON string and parse it in JavaScript
  var dataArray = JSON.parse('<?php echo json_encode($histogramData); ?>');

  // Create the bar charts
  Object.keys(dataArray).forEach(function(pregunta, index) {
    var ctx = document.getElementById("miGrafico" + index).getContext("2d");
    var etiquetas = dataArray[pregunta].map(function(d) { return d.Respuesta; });
    var data = dataArray[pregunta].map(function(d) { return d.Cantidad; });

    var miGrafico = new Chart(ctx, {
      type: "bar",
      data: {
        labels: etiquetas,
        datasets: [{
          label: "Respuestas",
          data: data,
          backgroundColor: "rgba(75, 192, 192, 0.2)",
          borderColor: "rgba(75, 192, 192, 1)",
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, /* Make the chart responsive */
        plugins: {
          title: {
            display: true,
            text: pregunta,
            color: 'Black',
            position: 'top',
            align: 'center',
            font: {
              weight: 'bold',
              size: 20 // Increase the size of the title text
            },
            padding: 8,
            fullSize: true,
          }
        },
        layout: {
          padding: {
            left: 100,
            right: 100,
            top: 100,
            bottom: 100
          }
        }
      }
    });
  });
 }
 </script>

</body>
</html>
