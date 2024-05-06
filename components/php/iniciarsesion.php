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

    // Obtener el ID del usuario para guardarlo en la variable de sesión
    $conexion = conexion();
    $ssql = "SELECT `id` FROM `usuarios` WHERE `correo` = '$correo'";
    $result = $conexion->query($ssql);
    session_start();
    if ($result->num_rows > 0) {
        // Usuario autenticado correctamente, obtener su ID
    $row = $result->fetch_assoc();
    
    // Guardar el ID del usuario en una variable de sesión
    $_SESSION['id'] = $row['id'];
    }

    header("Location: Notes.php");
    exit();
} else {
    echo '
        <script>
            alert("Usuario no encontrado, favor registrarse");
            window.location = "login.php";
        </script>
    ';
}
