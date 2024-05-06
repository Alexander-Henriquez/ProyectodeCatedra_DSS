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
    <div class="search-bar-container">
      <i class="fas fa-search"></i> 
      <input type="text" placeholder="Buscar..." class="search-bar" id="buscador" style="color: black;"> <!-- Campo de búsqueda -->
    </div>
    <div class="cerrar-sesion-container">
      <a href="../../inicio.html" class="cerrar-sesion-btn">Cerrar sesión</a>
    </div>
</header>

<div class="formulario-container">
    <p id="agregarRecordatorio">Crear Recordatorio...</p> <!-- Texto para agregar un recordatorio -->
    <form action="../php/crear_recordatorio.php" method="POST" id="formularioRecordatorio" style="display: none;">
        <input type="text" name="titulo" class="input-titulo" placeholder="Título del recordatorio" required><br>
        <textarea name="contenido" class="input-contenido" placeholder="Contenido del recordatorio" required></textarea><br>
        <input type="datetime-local" id="fecha_recordatorio" name="fecha_recordatorio" class="input-fecha" required><br>
        <input type="submit" class="btn-crear" value="Crear Recordatorio">
    </form>
</div>

<div class="recordatorios-container" id="lista-recordatorios">
  <?php include '../php/mostrar_recordatorio.php'; ?>
</div>

  <nav class="menu">
    <ul>
      <li><a href="Notes.php" id="notas"><img src="../img/documento.png" alt="Icono de notas" class="menu-icon"> Notas</a></li> <!-- Opción del menú para notas -->
      <li><a href="Reminder.php" id="recordatorio"><img src="../img/campana.png" alt="Icono de recordatorio" class="menu-icon"> Recordatorios</a></li> <!-- Opción del menú para recordatorios -->
      <li><a href="#" id="papelera"><img src="../img/tacho-de-reciclaje.png" alt="Icono de papelera" class="menu-icon"> Papelera</a></li> <!-- Opción del menú para la papelera -->
    </ul>
  </nav>
  
  <!-- Script para la búsqueda en tiempo real -->
  <script>
    document.getElementById("buscador").addEventListener("keyup", function(event) {
        var query = this.value.trim(); // Obtener el valor del campo de búsqueda
        if (query === "") {
            // Si el campo de búsqueda está vacío, no hacer nada
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../php/mostrar_recordatorio.php", true);
            xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualizar la lista de recordatorios en la página con todos los recordatorios
                    var recordatoriosContainer = document.getElementById("lista-recordatorios");
                    recordatoriosContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
            return;
        }

        // Realizar una solicitud AJAX al servidor para buscar recordatorios que coincidan con la consulta
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../php/mostrar_recordatorio.php?query=" + encodeURIComponent(query), true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Actualizar la lista de recordatorios en la página con los resultados de la búsqueda
                var recordatoriosContainer = document.getElementById("lista-recordatorios");
                recordatoriosContainer.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });
  </script>

  <script src="../js/recordatorios.js"></script> 
</body>
</html>
