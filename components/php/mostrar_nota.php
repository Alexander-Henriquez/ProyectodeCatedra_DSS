<?php
session_start();
// Verificar si existe una sesión activa
if (isset($_SESSION['id'])) {
    $usuarioId = $_SESSION['id']; // Obtener el ID de usuario de la sesión
} else {
    echo "La variable de sesión no está definida."; // Mensaje de error si la sesión no está definida
}

require_once "db_connection.php"; // Incluir el archivo de conexión a la base de datos

$conexion = conexion(); // Establecer la conexión a la base de datos

// Consulta SQL para mostrar las notas del usuario
if(isset($_GET['query']) && !empty($_GET['query'])) {
    // Si se proporciona un término de búsqueda, ajustar la consulta para buscar notas que coincidan con el término de búsqueda
    $query = $conexion->real_escape_string($_GET['query']); // Escapar caracteres especiales para evitar inyección de SQL
    $ssql = "SELECT `id`, `titulo`, `contenido`, `color_fondo` FROM `notas` WHERE `usuario_id` = '$usuarioId' AND (`titulo` LIKE '%$query%' OR `contenido` LIKE '%$query%')";
} else {
    // Si no se proporciona ningún término de búsqueda, ejecutar la consulta normal para mostrar todas las notas del usuario
    $ssql = "SELECT `id`, `titulo`, `contenido`, `color_fondo` FROM `notas` WHERE `usuario_id` = '$usuarioId'";
}

$result = $conexion->query($ssql); // Ejecutar la consulta SQL

// Mostrar los resultados
while ($row = $result->fetch_array()) {
    // Mostrar cada nota como un artículo con su título, contenido y color de fondo
    echo "<article class='notaMostrada' id='" . $row['id'] . "' style='background-color: " . $row['color_fondo'] . "'>";
    echo "<h2>Título:</h2> <h3>" . $row['titulo'] . "</h3><br>";
    echo "<h2>Contenido:</h2> <p>" . nl2br($row['contenido']) . "</p><br><br>";
    echo "<button class='button-eliminar' onclick='enviarAPapelera(" . $row['id'] . ")'>Eliminar</button>";
    echo "</article>";

    // Modal para editar la nota
    echo "<div id='myModal' class='modal'>";
    echo "<div class='modal-content'>";
    echo "<span class='close'>&times;</span>";
    // Iniciar el formulario de edición de la nota
    echo "<form action='../php/update_note.php' method='post'>";

    echo "<input type='text' id='idnota' name='idnota' value='" . htmlspecialchars($row['id']) . "' style='display: none;'><br>";
    // Campo de entrada para el título de la nota
    echo "<label for='titulo'>Título:</label>";
    echo "<input type='text' id='titulo' name='titulo' value='" . htmlspecialchars($row['titulo']) . "'><br>";
    // Campo de entrada para el contenido de la nota
    echo "<label for='contenido'>Contenido:</label>";
    echo "<textarea id='contenido' name='contenido'>" . htmlspecialchars($row['contenido']) . "</textarea><br>";
    // Botón de envío del formulario para guardar la nota editada
    echo "<input type='submit' value='Guardar'>";
    echo "</form>"; // Cerrar el formulario de edición de la nota
    echo "</div>"; // Cerrar el contenido del modal
    echo "</div>"; // Cerrar el modal
}
?>

<script>
    /* Utilizamos JavaScript para mostrar una alerta para confirmar la eliminación de la nota */
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
