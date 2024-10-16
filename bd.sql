
CREATE DATABASE escuela;
USE escuela;

CREATE TABLE t_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    roll ENUM('admin', 'alumno') NOT NULL
);

CREATE TABLE t_alumno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    anio_ingreso INT NOT NULL,
    carrera VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES t_usuario(id)
);

ALTER TABLE t_alumno ADD CONSTRAINT fk_usuario_id FOREIGN KEY (usuario_id) REFERENCES t_usuario(id);

