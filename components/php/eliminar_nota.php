<?php
session_start();
if (isset($_SESSION['id'])) {
    $usuarioId = $_SESSION['id'];
} else {
    echo "La variable de sesión no está definida.";
    exit;
}

if (isset($_POST['idNota'])) {
    $idNota = $_POST['idNota'];

    require_once "db_connection.php";
    $conexion = conexion(); // Conexión a la base de datos

    $ssql = "DELETE FROM notas WHERE id = '$idNota' AND usuario_id = '$usuarioId'";
    $resultado = $conexion->query($ssql);

    if ($resultado) {
        echo "La nota se eliminó correctamente.";
    } else {
        echo "Error al eliminar la nota.";
    }
} else {
    echo "No se proporcionó un ID de nota válido.";
}
