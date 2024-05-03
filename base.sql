CREATE DATABASE IF NOT EXISTS inventario;

USE inventario;

CREATE TABLE usuario (
	usuario_id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_nombre VARCHAR(40),
    usuario_apellido VARCHAR(40),
    usuario_usuario VARCHAR(20),
    usuario_clave VARCHAR(200),
    usuario_email VARCHAR(70)
);

CREATE TABLE categoria (
	categoria_id INT PRIMARY KEY AUTO_INCREMENT,
    categoria_nombre VARCHAR(50),
    categoria_ubicacion VARCHAR(150)
);

CREATE TABLE producto (
	producto_id INT PRIMARY KEY AUTO_INCREMENT,
    producto_codigo VARCHAR(70),
    producto_nombre VARCHAR(70),
    producto_precio DECIMAL(30,2),
    producto_stock INT,
    producto_foto VARCHAR(500),
    categoria_id INT,
    usuario_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categoria (categoria_id),
    FOREIGN KEY (usuario_id) REFERENCES usuario (usuario_id)
);