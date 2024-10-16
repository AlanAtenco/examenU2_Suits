<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require 'db.php';

$roll = $_SESSION['roll'];

if ($roll == 'admin') {
    header('Location: admin_dashboard.php');
    exit;
} else {
    // Obtener la información del alumno utilizando el id del usuario que ha iniciado sesión
    $usuario_id = $_SESSION['usuario_id'];
    $query = $conn->prepare("SELECT * FROM t_alumno WHERE usuario_id = ?");
    $query->bind_param('i', $usuario_id);
    $query->execute();
    $alumno = $query->get_result()->fetch_assoc();

    // Iniciar la salida de HTML
    echo '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Información del Alumno</title>
        <link rel="stylesheet" href="styles.css"> <!-- Cambia esta línea si tu CSS tiene otro nombre o ruta -->
    </head>
    <body>
        <div class="container">';

    // Verificar si hay información del alumno
    if ($alumno) {
        echo '<h1>Información del Alumno</h1>';
        echo '<p>Nombre: ' . $alumno['nombre'] . '</p>';
        echo '<p>Apellido: ' . $alumno['apellido'] . '</p>';
        echo '<p>Año de Ingreso: ' . $alumno['anio_ingreso'] . '</p>';
        echo '<p>Carrera: ' . $alumno['carrera'] . '</p>';
        echo '<p>Fecha de Nacimiento: ' . $alumno['fecha_nacimiento'] . '</p>';
    } else {
        echo '<p>No se ha registrado información de este alumno.</p>';
    }

    // Botón para cerrar sesión
    echo '<form method="POST" action="logout.php">';
    echo '<button type="submit">Cerrar sesión</button>';
    echo '</form>';

    echo '</div> <!-- Cierre del contenedor -->
    </body>
    </html>';
}
?>

<!-- CSS: styles.css -->
<style>
/* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

/* Fondo con degradado suave */
body {
    background: linear-gradient(135deg, #007bb8, #9b2c70);    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #333; /* Color de texto gris oscuro */
}

/* Estilo del contenedor */
.container {
    background-color: rgba(255, 255, 255, 0.0); /* Fondo blanco más transparente */
    padding: 30px 40px; /* Padding superior e inferior más pequeño */
    border-radius: 15px; /* Bordes más redondeados */
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Sombra suave */
    max-width: 500px; /* Ancho máximo */
    width: 100%;
    transition: box-shadow 0.3s ease-in-out; /* Transición suave */
}

/* Estilo de encabezado */
h1 {
    color: #fff; /* Color gris oscuro */
    margin-bottom: 20px; /* Espacio debajo del título */
    font-size: 26px; /* Tamaño de fuente */
    text-align: center; /* Centrar el título */
}

/* Estilo de párrafos */
p {
    color: #fff; /* Color gris medio */
    margin-bottom: 10px; /* Espacio inferior */
    font-size: 18px; /* Tamaño de fuente */
    line-height: 1.6; /* Espaciado de línea */
}

/* Botón de cerrar sesión */
button {
    background: linear-gradient(135deg, #ff4c4c, #ff8787); /* Fondo degradado rojo */
    border: none;
    padding: 10px 20px;
    color: white; /* Color de texto blanco */
    font-weight: bold;
    width: 100%;
    border-radius: 30px; /* Bordes redondeados */
    transition: all 0.3s ease-in-out;
    cursor: pointer; /* Cambia el cursor al pasar el mouse */
    margin-top: 20px; /* Espacio superior */
}

button:hover {
    background: #ff1a1a; /* Cambio de color más dinámico al pasar el mouse */
    transform: translateY(-3px); /* Levanta el botón al pasar el mouse */
}

/* Mensajes de error */
.error-message {
    color: #d9534f; /* Color rojo para el mensaje de error */
    margin-top: 10px; /* Espacio superior para el mensaje de error */
    font-size: 14px; /* Ajustar tamaño de fuente */
    text-align: center; /* Centrar texto */
}

/* Mensajes de éxito */
.success-message {
    color: #4CAF50; /* Verde para éxito */
    margin-top: 10px; /* Espacio superior para el mensaje */
    font-size: 14px; /* Ajustar tamaño de fuente */
    text-align: center; /* Centrar texto */
}
</style>
