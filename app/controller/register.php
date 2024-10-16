<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $roll = $_POST['roll'];

    $query = $conn->prepare("INSERT INTO t_usuario (usuario, password, roll) VALUES (?, ?, ?)");
    $query->bind_param('sss', $usuario, $password, $roll);

    if ($query->execute()) {
        // Mensaje de éxito y redirección
        echo "<div class='success-message'>Usuario registrado!.</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'login.php';
                }, 3000); // Esperar 3 segundos antes de redirigir
              </script>";
    } else {
        echo "<div class='error-message'>Error en el registro</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../../public/registro.css"> <!-- Asegúrate de que este enlace apunte a tu CSS -->
</head>
<body>
    <div class="container">
        <h2>Registrar Usuario</h2>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <select name="roll" required>
                <option value="admin">Admin</option>
                <option value="alumno">Alumno</option>
            </select>
            <button type="submit">Registrar</button>
        </form>
        <div class="footer-message">
            <p>¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
        </div>
    </div>
</body>
</html>
