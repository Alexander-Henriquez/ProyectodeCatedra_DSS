<?php
    session_start();
    if(isset($_SESSION['id'])) {
        $usuarioId = $_SESSION['id'];
    } else {
        echo "La variable de sesión no está definida.";
    }
    $titulo = $_POST["titulo"];
    $contenido = $_POST["contenido"];
    $idnota = $_POST["idnota"];

    require_once "db_connection.php";
    
    $conexion = conexion(); // Conexión a la base de datos
    // Consulta SQL para mostrar las notas del usuario
    $ssql = "UPDATE notas SET titulo = '$titulo', contenido = '$contenido' WHERE `id`= '$idnota';"; 
    $result = $conexion->query($ssql); //Ejecutar consulta

    header("Location: Notes.php");


?>