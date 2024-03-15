<?php
// Incluimos la conexión a la base de datos
include 'db_connection.php';

// Extraemos los datos ingresados por el usuario 
$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Validar el formato de correo electrónico con expresiones regulares
if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $correo)) {
    // Mostrar una alerta JavaScript
    echo '<script>alert("El formato del correo electrónico no es válido"); window.history.back();</script>';
    exit(); // Detener el proceso de registro
}
 
// Validar la contraseña con expresiones regulares
if (!preg_match('/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $contrasena)) {
    // Mostrar una alerta JavaScript
    echo '<script>alert("La contraseña debe tener al menos 8 caracteres, una mayúscula y un número"); window.history.back();</script>';
    exit(); // Detener el proceso de registro
}

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
