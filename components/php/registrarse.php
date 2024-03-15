<?php
// Incluimos la conexión a la base de datos
include 'db_connection.php';

// Extraemos los datos ingresados por el usuario 
$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Encriptamiento de contraseña
$contrasena = hash('sha512', $contrasena);

// Preparar el procedimiento almacenado "CrearUsuario"
$query = "CALL CrearUsuario(:usuario, :correo, :contrasena)";
$stmt = $conn->prepare($query);

// Vincular parámetros
$stmt->bindParam(':usuario', $usuario);
$stmt->bindParam(':correo', $correo);
$stmt->bindParam(':contrasena', $contrasena);

// Ejecutar el procedimiento almacenado
$stmt->execute();

// Muestra una alerta según se creó o no el usuario y redirige al login
if($stmt->rowCount() > 0) {
    echo '
        <script>
            alert("Usuario creado exitosamente, por favor iniciar sesión");
            window.location = "login.php";
         </script>
    ';
} else {
    echo '
        <script>
            alert("Usuario no creado, inténtalo de nuevo");
            window.location = "login.php";
        </script>
    ';
}

?>
