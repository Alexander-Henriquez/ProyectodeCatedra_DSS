<?php
session_start();

// Verifica si la solicitud HTTP es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Requiere el archivo de conexión a la base de datos
    require_once "db_connection.php";

    // Recupera los datos del formulario enviado por el método POST
    $nota_id = $_POST["nota_id"];
$fecha_recordatorio = $_POST["fecha_recordatorio"];
$titulo = $_POST["titulo"];
$contenido = $_POST["contenido"];

    if (isset($_SESSION['id'])) {
        $usuario_id = $_SESSION['id'];
    } else {
        echo "La variable de sesión 'id_usuario' no está definida.";
        exit();
    }

    try {
        // Prepara la consulta SQL para insertar un nuevo recordatorio en la base de datos
        $stmt = $conn->prepare("INSERT INTO recordatorios (usuario_id, nota_id, fecha_recordatorio, titulo, contenido) VALUES (:usuario_id, :nota_id, :fecha_recordatorio, :titulo, :contenido)");
    
        // Vincula los parámetros de la consulta con las variables obtenidas del formulario
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':nota_id', $nota_id);
        $stmt->bindParam(':fecha_recordatorio', $fecha_recordatorio);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':contenido', $contenido);
        
        // Ejecuta la consulta SQL
        $stmt->execute();
        
        // Redirige al usuario a la página Notes.php con un mensaje indicando que el recordatorio se ha creado correctamente
        header("Location: Reminder.php?recordatorio_creado=true");
        exit();
    } catch (PDOException $e) {
        // Muestra un mensaje de error si la operación de inserción falla
        echo "Error al crear el recordatorio: " . $e->getMessage();
    }
} else {
    // Si la solicitud no es de tipo POST, redirige al usuario a la página Notes.php
    header("");
    exit();
}
?>
