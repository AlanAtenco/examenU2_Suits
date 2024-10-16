<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM t_usuario WHERE usuario = ?");
    $query->bind_param('s', $usuario);
    $query->execute();
    $result = $query->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['roll'] = $result['roll'];
        $_SESSION['usuario_id'] = $result['id'];
        header('Location: index.php');
        exit;
    } else {
        echo "<p class='error-message'>Usuario o contraseña incorrectos</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../../public/login.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>

        <!-- Botón para registrarse -->
        <form action="register.php" method="get">
            <button type="submit" class="register-button">Registrarse</button>
        </form>
    </div>
</body>
</html>
