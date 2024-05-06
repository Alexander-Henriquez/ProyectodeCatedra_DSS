<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NoteMinder</title>
  <link rel="stylesheet" href="../css/Notes.css"> 
  <link rel="stylesheet" href="../css/Reminder.css"> 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
</head>
<body>
<header class="header">
    <div class="logo">
      <img src="../img/reminders (1).png" alt="Icono de la aplicación" class="app-icon"> 
      <h3 class="app-name">NoteMinder</h3> 
    </div>
   
    <div class="cerrar-sesion-container">
      <a href="../../inicio.html" class="cerrar-sesion-btn">Cerrar sesión</a>
    </div>
</header>
<?php 
date_default_timezone_set('America/Mexico_City');
// Obtiene la hora actual
$hora_actual = date('H:i');
$fecha_actual = date('Y-m-d');
// Suma 30 minutos a la hora actual
$nueva_hora = date('H:i', strtotime($hora_actual . ' + 30 minutes'));
?>
<div class="formulario-container">
    <p id="agregarRecordatorio">Crear Recordatorio...</p> <!-- Texto para agregar un recordatorio -->
    <form action="../php/crear_recordatorio.php" method="POST" id="formularioRecordatorio" style="display: none;">
        <input type="text" name="titulo" class="input-titulo" placeholder="Título del recordatorio" required><br>
        <textarea name="contenido" class="input-contenido" placeholder="Contenido del recordatorio" required></textarea><br>
        
        <label for="color_fondo" >Seleccione un color de fondo</label> <!-- Etiqueta para el campo de color de fondo -->
        <input type="color" id="color_fondo" name="color_fondo" value="#464952" required><br><br> <!-- Campo para el color de fondo de la nota -->

        <input type="date" id="date" name="fecha_recordatorio" class="input-fecha" min="<?php echo $fecha_actual ?>" value="<?php echo $fecha_actual; ?>" required /><br>
        <input type="time" id="time" name="hora_recordatorio" class="input-fecha" value="<?php echo $hora_actual; ?>" required /><br>

        <input type="submit" class="btn-crear" value="Crear Recordatorio">
    </form>
</div>

<div class="recordatorios-container">
  <?php include '../php/mostrar_recordatorio.php'; ?>
</div>

  <nav class="menu">
    <ul>
      <li><a href="Notes.php" id="notas"><img src="../img/documento.png" alt="Icono de notas" class="menu-icon"> Notas</a></li> <!-- Opción del menú para notas -->
      <li><a href="Reminder.php" id="recordatorio"><img src="../img/campana.png" alt="Icono de recordatorio" class="menu-icon"> Recordatorios</a></li> <!-- Opción del menú para recordatorios -->
    </ul>
  </nav>
  
  

  <script src="../js/recordatorios.js"></script> 
</body>
</html>
