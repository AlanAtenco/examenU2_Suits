<?php
session_start();
if ($_SESSION['roll'] != 'admin') {
    header('Location: index.php');
    exit;
}

require 'db.php';

$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM t_alumno WHERE id = ?");
$query->bind_param('i', $id);
$query->execute();
$alumno = $query->get_result()->fetch_assoc();
?>

<form method="POST" action="update_alumno.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="text" name="nombre" value="<?php echo $alumno['nombre']; ?>" required>
    <input type="text" name="apellido" value="<?php echo $alumno['apellido']; ?>" required>
    <input type="number" name="anio_ingreso" value="<?php echo $alumno['anio_ingreso']; ?>" required>
    <input type="text" name="carrera" value="<?php echo $alumno['carrera']; ?>" required>
    <input type="date" name="fecha_nacimiento" value="<?php echo $alumno['fecha_nacimiento']; ?>" required>
    <button type="submit">Guardar Cambios</button>
</form>
