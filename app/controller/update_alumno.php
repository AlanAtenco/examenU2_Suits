<?php
session_start();
if ($_SESSION['roll'] != 'admin') {
    header('Location: index.php');
    exit;
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $anio_ingreso = $_POST['anio_ingreso'];
    $carrera = $_POST['carrera'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $query = $conn->prepare("UPDATE t_alumno SET nombre = ?, apellido = ?, anio_ingreso = ?, carrera = ?, fecha_nacimiento = ? WHERE id = ?");
    $query->bind_param('ssissi', $nombre, $apellido, $anio_ingreso, $carrera, $fecha_nacimiento, $id);

    if ($query->execute()) {
        echo "Alumno actualizado exitosamente";
        header('Location: admin_dashboard.php');
    } else {
        echo "Error al actualizar";
    }
}
?>
