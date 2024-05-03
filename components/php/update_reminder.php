<?php
session_start();

// Verifica si la variable de sesión 'id' está definida
if(isset($_SESSION['id'])) {
    $usuarioId = $_SESSION['id']; // Obtiene el ID del usuario de la sesión
} else {
    echo "La variable de sesión 'id' no está definida."; // Muestra un mensaje si la variable de sesión no está definida
}

// Obtiene los valores del formulario de actualización de recordatorio
$titulo = $_POST["titulo"];
$contenido = $_POST["contenido"];
$idRecordatorio = $_POST["idRecordatorio"];

// Incluye el archivo de conexión a la base de datos
require_once "db_connection.php";

// Establece la conexión con la base de datos
$conexion = conexion();

// Construye la consulta SQL para actualizar el recordatorio en la base de datos
$ssql = "UPDATE recordatorios SET titulo = '$titulo', contenido = '$contenido' WHERE id = '$idRecordatorio' AND usuario_id = '$usuarioId'";

// Ejecuta la consulta SQL para actualizar el recordatorio
$resultado = $conexion->query($ssql);

// Redirige al usuario a la página de recordatorios después de actualizar el recordatorio en la base de datos
header("Location: Reminder.php");
?>
