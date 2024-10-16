<?php
session_start();
if ($_SESSION['roll'] != 'admin') {
    header('Location: index.php');
    exit;
}

require 'db.php';

$query = "SELECT * FROM t_alumno";
$result = $conn->query($query);

echo '<div class="container">';
echo '<h1>Administrar Alumnos</h1>';
echo '<a href="add_alumno.php" class="btn-add">Agregar Alumno</a>';
echo '<table>';
echo '<thead><tr><th>Nombre</th><th>Apellido</th><th>Año de Ingreso</th><th>Carrera</th><th>Fecha de Nacimiento</th><th>Acciones</th></tr></thead>';
echo '<tbody>';

while ($alumno = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($alumno['nombre']) . '</td>';
    echo '<td>' . htmlspecialchars($alumno['apellido']) . '</td>';
    echo '<td>' . htmlspecialchars($alumno['anio_ingreso']) . '</td>';
    echo '<td>' . htmlspecialchars($alumno['carrera']) . '</td>';
    echo '<td>' . htmlspecialchars($alumno['fecha_nacimiento']) . '</td>';
    echo '<td>
            <button class="btn-edit" onclick="editarAlumno(' . $alumno['id'] . ')">Editar</button>
            <button class="btn-delete" onclick="eliminarAlumno(' . $alumno['id'] . ')">Eliminar</button>
          </td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';

echo '<form method="POST" action="logout.php" class="logout-form">';
echo '<button type="submit" class="btn-logout">Cerrar sesión</button>';
echo '</form>';
echo '</div>';
?>

<script>
function eliminarAlumno(id) {
    if (confirm('¿Estás seguro de eliminar este alumno?')) {
        fetch('delete_alumno.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alumno eliminado exitosamente');
                location.reload();
            } else {
                alert('Error al eliminar alumno');
            }
        });
    }
}

function editarAlumno(id) {
    window.location.href = `edit_alumno.php?id=${id}`;
}
</script>
<style>
    /* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

/* Fondo con degradado azul y morado */
body {
    background: linear-gradient(135deg, #ea00ff, #005eff); /* Fondo degradado */
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
}

/* Estilo del contenedor */
.container {
    background-color: rgba(255, 255, 255, 0.1); /* Fondo blanco más opaco */
    padding: 40px; /* Padding */
    border-radius: 20px; /* Bordes más redondeados */
    box-shadow: 0px 0px 20px 5px rgba(255, 255, 255, 0.752); /* Resplandor estático */
    max-width: 800px; /* Ancho más grande para la tabla */
    width: 100%;
}

/* Estilo de encabezado */
h1 {
    color: #ffffff; /* Color blanco */
    margin-bottom: 20px; /* Espacio debajo del título */
    font-size: 28px; /* Aumentar tamaño de fuente */
}

/* Estilo del enlace para agregar alumno */
.btn-add {
    background-color: #ff4081; /* Color del botón */
    color: #ffffff; /* Color del texto */
    padding: 10px 15px;
    border: none;
    border-radius: 5px; /* Bordes redondeados */
    text-decoration: none; /* Sin subrayado */
    margin-bottom: 20px; /* Espacio debajo del botón */
    display: inline-block; /* Para que el margen se aplique correctamente */
    transition: background 0.3s ease;
}

.btn-add:hover {
    background-color: #ff66b2; /* Color al pasar el mouse */
}

/* Estilo de la tabla */
table {
    width: 100%;
    border-collapse: collapse; /* Colapsar bordes */
    margin-top: 20px; /* Espacio entre el título y la tabla */
}

/* Estilo de las celdas de la tabla */
th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd; /* Línea inferior de las celdas */
}

/* Estilo de encabezado de la tabla */
th {
    background-color: #ff4081; /* Color del encabezado */
    color: white; /* Color del texto en el encabezado */
}

/* Estilo de filas de la tabla */
tr:nth-child(even) {
    background-color: rgba(255, 255, 255, 0.1); /* Color de fondo para filas pares */
}

tr:hover {
    background-color: rgba(255, 255, 255, 0.2); /* Efecto hover en filas */
}

/* Estilo de botones dentro de la tabla */
.btn-edit, .btn-delete {
    background-color: #005eff; /* Color de los botones */
    color: white; /* Color de texto */
    padding: 5px 10px; /* Espaciado interno */
    border: none; /* Sin borde */
    border-radius: 5px; /* Bordes redondeados */
    cursor: pointer; /* Cursor de puntero */
    transition: background 0.3s ease;
}

.btn-edit:hover {
    background-color: #007bff; /* Color al pasar el mouse */
}

.btn-delete {
    background-color: #ff4081; /* Color del botón eliminar */
}

.btn-delete:hover {
    background-color: #ff66b2; /* Color al pasar el mouse para eliminar */
}

/* Estilo del formulario de cierre de sesión */
.logout-form {
    margin-top: 20px; /* Espacio superior */
}

/* Estilo del botón de cerrar sesión */
.btn-logout {
    background-color: red; /* Color del botón de cerrar sesión */
    color: white; /* Color de texto */
    padding: 10px 20px;
    border: none;
    border-radius: 5px; /* Bordes redondeados */
    cursor: pointer; /* Cursor de puntero */
    transition: background 0.3s ease;
}

.btn-logout:hover {
    background-color: #ff66b2; /* Color al pasar el mouse */
}

</style>