<?php
session_start();

// Verifica si la solicitud HTTP es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Requiere el archivo de conexión a la base de datos
    require_once "db_connection.php";

    // Recupera los datos del formulario enviado por el método POST
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $color_fondo = $_POST["color_fondo"];

    // Verifica si la variable de sesión 'id' está definida
    if (isset($_SESSION['id'])) {
        $usuario_id = $_SESSION['id'];
    } else {
        echo "La variable de sesión 'id' no está definida.";
        exit(); // Sale del script si la variable de sesión no está definida
    }

    try {
        // Prepara la consulta SQL para insertar una nueva nota en la base de datos
        $stmt = $conn->prepare("INSERT INTO notas (usuario_id, titulo, contenido, color_fondo) VALUES (:usuario_id, :titulo, :contenido, :color_fondo)");

        // Vincula los parámetros de la consulta con las variables obtenidas del formulario
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':contenido', $contenido);
        $stmt->bindParam(':color_fondo', $color_fondo);
        
        // Ejecuta la consulta SQL
        $stmt->execute();
        
        // Redirige al usuario a la página Notes.php con un mensaje indicando que la nota se ha creado correctamente
        header("Location: Notes.php?nota_creada=true");
        exit();
    } catch (PDOException $e) {
        // Muestra un mensaje de error si la operación de inserción falla
        echo "Error al crear la nota: " . $e->getMessage();
    }
} else {
    // Si la solicitud no es de tipo POST, redirige al usuario a la página Notes.php
    header("Location: Notes.php");
    exit();
}



