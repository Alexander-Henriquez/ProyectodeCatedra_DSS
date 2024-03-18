<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "app_notas";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Conexión exitosa";
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
function conexion(){
    $mysqli_conexion = new mysqli("localhost", "root", "", "app_notas");
    if($mysqli_conexion->connect_errno){
        echo "Fallo al conectar a MySQL: (" . $mysqli_conexion->connect_errno . ") " . $mysqli_conexion->connect_error;
    }
    return $mysqli_conexion;
}
?>
