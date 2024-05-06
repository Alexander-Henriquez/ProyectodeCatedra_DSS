<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NoteMinder</title>
  <link rel="stylesheet" href="../css/Notes.css"> 
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
  </header>
  <div class="formulario-container">
    <p id="agregarNota">Crear una nota...</p> <!-- Texto para agregar una nota -->
    <form action="../php/crear_nota.php" method="POST" id="formulario" style="display: none;"> <!-- Formulario para crear una nota -->
      <input type="text" id="titulo" name="titulo" placeholder="Titulo" required><br> <!-- Campo para el título de la nota -->
      <textarea id="contenido" name="contenido" rows="2" cols="50" placeholder="Crear una nota" required></textarea><br> <!-- Área para el contenido de la nota -->
      <label for="color_fondo">Seleccione un color de fondo</label> <!-- Etiqueta para el campo de color de fondo -->
      <input type="color" id="color_fondo" name="color_fondo" value="#464952" required><br> <!-- Campo para el color de fondo de la nota -->
      <input type="hidden" name="usuario_id" value="1"> <!-- Campo oculto para el ID del usuario -->
      <input type="submit" value="Crear Nota"> <!-- Botón para enviar el formulario y crear la nota -->
    </form>
  </div>

  <div class="formulario-container" id="lista-notas">
    <?php include '../php/mostrar_nota.php';?> <!-- Contenido de las notas -->
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
            xhr.open("GET", "../php/mostrar_nota.php", true);
            xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                    // Actualizar la lista de notas en la página con todas las notas
                    var notasContainer = document.getElementById("lista-notas");
                    notasContainer.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
            return;
        }

        // Realizar una solicitud AJAX al servidor para buscar notas que coincidan con la consulta
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../php/mostrar_nota.php?query=" + encodeURIComponent(query), true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Actualizar la lista de notas en la página con los resultados de la búsqueda
                var notasContainer = document.getElementById("lista-notas");
                notasContainer.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });
  </script>

  <script src="../js/Notes.js"></script> 
</body>
</html>
