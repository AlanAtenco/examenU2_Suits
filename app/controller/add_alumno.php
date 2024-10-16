<?php
session_start();
if ($_SESSION['roll'] != 'admin') {
    header('Location: index.php');
    exit;
}

require 'db.php';

// Obtener todos los usuarios con el rol de "alumno"
$usuarios_query = "SELECT id, usuario FROM t_usuario WHERE roll = 'alumno'";
$usuarios_result = $conn->query($usuarios_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $anio_ingreso = $_POST['anio_ingreso'];
    $carrera = $_POST['carrera'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $usuario_id = $_POST['usuario_id']; // Selección del usuario

    $query = $conn->prepare("INSERT INTO t_alumno (nombre, apellido, anio_ingreso, carrera, fecha_nacimiento, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param('ssissi', $nombre, $apellido, $anio_ingreso, $carrera, $fecha_nacimiento, $usuario_id);

    if ($query->execute()) {
        echo "Alumno registrado exitosamente";
        header('Location: admin_dashboard.php');
    } else {
        echo "Error en el registro";
    }
}
?>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellido" placeholder="Apellido" required>
    <input type="number" name="anio_ingreso" placeholder="Año de Ingreso" required>
    <input type="text" name="carrera" placeholder="Carrera" required>
    <input type="date" name="fecha_nacimiento" required>
    
    <!-- Selección de usuario -->
    <select name="usuario_id" required>
        <option value="">Selecciona un usuario</option>
        <?php
        while ($usuario = $usuarios_result->fetch_assoc()) {
            echo '<option value="' . $usuario['id'] . '">' . $usuario['usuario'] . '</option>';
        }
        ?>
    </select>

    <button type="submit">Agregar Alumno</button>
</form>
