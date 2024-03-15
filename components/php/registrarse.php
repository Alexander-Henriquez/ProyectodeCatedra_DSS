<?php
// Incluimos la conexión a la base de datos
include 'connect.php';

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


// Encriptación de la contraseña
$contrasena = hash('sha512', $contrasena);


// Consultar la base de datos para verificar si el correo electrónico ya está registrado
$query = "SELECT correo FROM usuarios WHERE correo = '$correo'";
$resultado = mysqli_query($conn, $query);

// Verificar si se encontró algún resultado
if (mysqli_num_rows($resultado) > 0) {
    echo '<script>alert("Este correo electronico ya está registrado"); window.history.back();</script>';
    exit(); // Detener el proceso de registro
}

// Query a ejecutar, procedimiento almacenado "CrearUsuario"
$query = "CALL CrearUsuario('$usuario', '$correo', '$contrasena')";

// Ejecutar el query "Crear Usuario"
$ejecutar = mysqli_query($conn, $query);

// Mostrar un alerta según se haya creado o no el usuario y redirigir al login
if($ejecutar){
    echo '
        <script>
            alert("Usuario creado exitosamente, por favor inicia sesión");
            window.location = "../../login.php";
         </script>
    ';
} else {
    echo '
        <script>
            alert("Usuario no creado, inténtalo de nuevo");
            window.location = "../../login.php";
        </script>
    ';
}

mysqli_close($conn);
?>
