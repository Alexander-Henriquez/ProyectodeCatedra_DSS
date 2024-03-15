<?php
// Incluimos la conexión a la base de datos
include 'db_connection.php';

// Extraemos los datos ingresados por el usuario
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Encriptamiento de contraseña
$contrasena = hash('sha512', $contrasena);

// Preparar el procedimiento almacenado "VerificarCredenciales"
$query = "CALL VerificarCredenciales(?, ?, @resultado)";
$stmt = $conn->prepare($query);

// Vincular parámetros
$stmt->bindParam(1, $correo);
$stmt->bindParam(2, $contrasena);

// Ejecutar el procedimiento almacenado
$stmt->execute();

// Obtener el resultado del procedimiento almacenado
$resultado = $conn->query("SELECT @resultado as resultado")->fetch(PDO::FETCH_ASSOC);
$resultado_final = $resultado['resultado'];

// Cerrar el statement

// Redirigir según el resultado del procedimiento almacenado
if ($resultado_final == 1) {
    header("Location: ../html/Notes.html");
    exit();
} else {
    echo '
        <script>
            alert("Usuario no encontrado, favor registrarse");
            window.location = "login.php";
        </script>
    ';
}
