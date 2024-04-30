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
