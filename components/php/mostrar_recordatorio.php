<?php
session_start();
if (isset($_SESSION['id'])) {
    $usuarioId = $_SESSION['id'];
} else {
    echo "La variable de sesión no está definida.";
}

require_once "db_connection.php";

$conexion = conexion(); // Conexión a la base de datos

// Consulta SQL para mostrar las notas del usuario
$ssql = "SELECT `id`, `titulo`, `contenido`, `fecha_recordatorio`,`hora_recordatorio`, `color_fondo` FROM `recordatorios` WHERE `usuario_id` = '$usuarioId'";
$result = $conexion->query($ssql);

echo   "<link rel='stylesheet' href='../css/reminder2.css'> ";
echo "<link rel='stylesheet' href='../css/Eliminarbtn.css'> ";
// Mostrar los resultados
while ($row = $result->fetch_array()) {
    $hora_alerta = $row['hora_recordatorio'];
    $fecha_alerta = $row['fecha_recordatorio'];
    $titulo = $row['titulo'];

    echo "<article class='notaMostrada' id='" . $row['id'] . "' style='background-color: " . $row['color_fondo'] . "'>
    <h2>Título:</h2> <h3>" . $row['titulo'] . "</h3><br>
    <h2>Contenido:</h2> <p>" . nl2br($row['contenido']) . "</p><br>
    <div class='container'>
        <div class='fecha'>
            <h3>Fecha:</h3> 
            <p>" . nl2br($row['fecha_recordatorio']) . "</p>
        </div>
        <div class='hora'>
            <h3>Hora:</h3> 
            <p>" . nl2br($row['hora_recordatorio']) . "</p>
        </div>
        
        <div style='text-align: center;' class='button-container'>
            <button class='button' onclick='enviarAPapelera(".$row['id'].")'>Eliminar</button>
        </div>
    </div>

    </article>";

    // Utilizar javascript para mostrar la notificación
    echo "<script>
    function checkHora() {
        var titulo = '$titulo';
        var fechaAlerta = '$fecha_alerta';
        var horaAlerta = '$hora_alerta';

        var fechaActual = new Date().toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
        fechaActual = fechaActual.split('/').reverse().join('-'); // Formatea la fecha como YYYY-MM-DD
        var fechaActualReordenada = fechaActual.split('-')[0] + '-' + fechaActual.split('-')[2] + '-' + fechaActual.split('-')[1]; // Reordena la fecha actual como YYYY-DD-MM
        var horaActual = new Date().toLocaleTimeString('en-US', {hour12: false});

        console.log('Esperando la fecha de: ' + titulo);
        console.log('Fecha actual: ' + fechaActualReordenada);
        console.log('Fecha alerta: ' + fechaAlerta);
        console.log('Hora actual: ' + horaActual);

        if(fechaActualReordenada === fechaAlerta) {
            if (horaActual === horaAlerta) {
                console.clear();
                toggleNotification();
            }
        } else {console.log('La fecha no coincide');}
    }
    function clear () {console.clear();}
    setInterval(checkHora, 1000);
    setInterval(clear, 60000);
    </script>";
    
    // Componente oculto de la notificacion
    echo "<figure class='notification hide none' style='display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;'>
    <div class='notification__body'>
        <div class='notification__body__first'>
            <svg focusable='false' viewBox='0 0 24 24'>
                <path d='M20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,
                         8 0 0,1 12,4C12.76,4 13.5,4.11 14.2, 
                         4.31L15.77,2.74C14.61,2.26 13.34,2 
                         12,2A10,10 0 0,0 2,12A10,10 0 0,0 
                         12,22A10,10 0 0, 0 22,12M7.91,10.08L6.5,11.5L11,
                         16L21,6L19.59,4.58L11,13.17L7.91,10.08Z'
                ></path>
            </svg>
            <h3>
                Es hora del recordatorio: '$titulo' &#128640; <br>
                que estaba programado el <b>'$fecha_alerta'</b> a las <b>'$hora_alerta'</b>
            </h3>
            <p>
            </p>
        </div>
        <svg
            onclick='toggleNotification()'
            xmlns='http://www.w3.org/2000/svg'
            width='24'
            height='24'
            viewBox='0 0 24 24'
            stroke-width='2'
            stroke='currentColor'
            fill='none'
            stroke-linecap='round'
            stroke-linejoin='round'
        >
            <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
            <path d='M18 6l-12 12'></path>
            <path d='M6 6l12 12'></path>
        </svg>
    </div>
</figure>";
    /*
    echo "<div id='myModal' class='modal'>";
    echo "<div class='modal-content'>";
    echo "<span class='close'>&times;</span>";
    // Iniciar el formulario
    echo "<form action='../php/update_note.php' method='post'>";

    echo "<input type='text' id='idnota' name='idnota' value='" . htmlspecialchars($row['id']) . "' style='display: none;'><br>";
    // Campo de entrada para el título
    echo "<label for='titulo'>Título:</label>";
    echo "<input type='text' id='titulo' name='titulo' value='" . htmlspecialchars($row['titulo']) . "'><br>";
    // Campo de entrada para el contenido
    echo "<label for='contenido'>Contenido:</label>";
    echo "<textarea id='contenido' name='contenido'>" . htmlspecialchars($row['contenido']) . "</textarea><br>";
    // Botón de envío del formulario
    echo "<input type='submit' value='Guardar'>";
    echo "</form>"; // Cerrar el formulario
    echo "</div>";
    echo "</div>";*/
}

?>


<script> /*Utilizamos javascript para mostrar una alert 
            para confirmar la eliminación de la nota */
            
    function enviarAPapelera(idNota) {
    if (confirm("¿Estás seguro de que quieres eliminar esta nota?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Actualizar la página después de eliminar la nota
                location.reload();
            }
        };
        xhr.open("POST", "eliminar_recordatorio.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("nota_id=" + idNota);
    }
}

</script>


<script src="../js/scriptNotificacion.js"></script>           
