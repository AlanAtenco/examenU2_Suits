<?php
session_start();
if ($_SESSION['roll'] != 'admin') {
    header('Location: index.php');
    exit;
}

require 'db.php';

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $id = $data->id;
    $query = $conn->prepare("DELETE FROM t_alumno WHERE id = ?");
    $query->bind_param('i', $id);

    if ($query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
