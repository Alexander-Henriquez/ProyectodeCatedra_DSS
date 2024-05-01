<?php
session_start();
if (isset($_SESSION['id'])) {
    $usuarioId = $_SESSION['id'];
} else {
    echo "La variable de sesión no está definida.";
}

require_once "db_connection.php";

$conexion = conexion(); // Conexión a la base de datos

// Consulta SQL para mostrar las notas del usuario
$ssql = "SELECT `id`, `titulo`, `contenido`, `color_fondo` FROM `notas` WHERE `usuario_id` = '$usuarioId'";
$result = $conexion->query($ssql);

// Mostrar los resultados
while ($row = $result->fetch_array()) {
    echo "<article class='notaMostrada' id='" . $row['id'] . "' style='background-color: " . $row['color_fondo'] . "'>";
    echo "<h2>Título:</h2> <h3>" . $row['titulo'] . "</h3><br>";
    echo "<h2>Contenido:</h2> <p>" . nl2br($row['contenido']) . "</p><br><br>";
    echo "<button class='button-eliminar' onclick='enviarAPapelera(" . $row['id'] . ")'>Eliminar</button>";
    echo "</article>";



    echo "<div id='myModal' class='modal'>";
    echo "<div class='modal-content'>";
    echo "<span class='close'>&times;</span>";
    // Iniciar el formulario
    echo "<form action='../php/update_note.php' method='post'>";

    echo "<input type='text' id='idnota' name='idnota' value='" . htmlspecialchars($row['id']) . "' style='display: none;'><br>";
    // Campo de entrada para el título
    echo "<label for='titulo'>Título:</label>";
    echo "<input type='text' id='titulo' name='titulo' value='" . htmlspecialchars($row['titulo']) . "'><br>";
    // Campo de entrada para el contenido
    echo "<label for='contenido'>Contenido:</label>";
    echo "<textarea id='contenido' name='contenido'>" . htmlspecialchars($row['contenido']) . "</textarea><br>";
    // Botón de envío del formulario
    echo "<input type='submit' value='Guardar'>";
    echo "</form>"; // Cerrar el formulario
    echo "</div>";
    echo "</div>";
}

?>


<script> /*Utilizamos javascript para mostrar una alert 
            para confirmar la eliminación de la nota */
            
    function enviarAPapelera(idNota) {
    if (confirm("¿Estás seguro de que quieres eliminar esta nota?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Actualizar la página después de eliminar la nota
                location.reload();
            }
        };
        xhr.open("POST", "eliminar_nota.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("idNota=" + idNota);
    }
}
</script>
