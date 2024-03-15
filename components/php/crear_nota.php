<?php

// Verifica si la solicitud HTTP es de tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Requiere el archivo de conexión a la base de datos
    require_once "db_connection.php";

    // Recupera los datos del formulario enviado por el método POST
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $usuario_id = $_POST["usuario_id"]; 

    try {
        // Prepara la consulta SQL para insertar una nueva nota en la base de datos
        $stmt = $conn->prepare("INSERT INTO notas (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)");

        // Vincula los parámetros de la consulta con las variables obtenidas del formulario
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':contenido', $contenido);
        
        // Ejecuta la consulta SQL
        $stmt->execute();
        
        // Redirige al usuario a la página Notes.html con un mensaje indicando que la nota se ha creado correctamente
        header("Location: ../html/Notes.html?nota_creada=true");
        exit();
    } catch (PDOException $e) {
        // Muestra un mensaje de error si la operación de inserción falla
        echo "Error al crear la nota: " . $e->getMessage();
    }
} else {
    // Si la solicitud no es de tipo POST, redirige al usuario a la página Notes.html
    header("Location: ../html/Notes.html");
    exit();
}
?>


