<?php
require_once "main.php";

#Almacenando datos
$nombre = limpiar_cadeda($_POST['usuario_nombre']);
$apellido = limpiar_cadeda($_POST['usuario_apellido']);
$usuario = limpiar_cadeda($_POST['usuario_usuario']);
$email = limpiar_cadeda($_POST['usuario_email']);
$clave_1 = limpiar_cadeda($_POST['usuario_clave_1']);
$clave_2 = limpiar_cadeda($_POST['usuario_clave_2']);

#Verificar campos obligatorios
if (
    empty($nombre) || empty($apellido) || empty($usuario)
    || empty($clave_1) || empty($clave_2)
) {
    echo '
    <div class="notification is-danger">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        No has llenado todos los campos que son obligatorios
    </div>';
    exit();
}

#Verificando integridad de los datos
if (verificacion_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
    echo '
    <div class="notification is-danger">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El nombre no coincide con el formato solicitado
    </div>';
    exit();
}

if (verificacion_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
    echo '
    <div class="notification is-danger">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El apellido no coincide con el formato solicitado
    </div>';
    exit();
}

if (verificacion_datos("[a-zA-Z0-9]{4,20}", $usuario)) {
    echo '
    <div class="notification is-danger">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El usuario no coincide con el formato solicitado
    </div>';
    exit();
}

if (verificacion_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_1) || verificacion_datos("[a-zA-Z0-9$@.-]{7,100}", $clave_2)) {
    echo '
    <div class="notification is-danger">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        Las claves no coincide con el formato solicitado
    </div>';
    exit();
}

#verificando email
if (!empty($email)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $check_email = conexion();
        $check_email = $check_email->query(
            "SELECT usuario_email FROM usuario WHERE usuario_email = '$email'"
        );
        if ($check_email->rowCount() > 0) {
            echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El email ingresado ya se encuentra registrado
        </div>';
            exit();
        }
        $check_email = null;
    } else {
        echo '
    <div class="notification is-danger">
        <strong>¡Ocurrio un error inesperado!</strong><br>
        El email ingresado no es valido
    </div>';
        exit();
    }
}

#verificando el usuario
$check_usuario = conexion();
$check_usuario = $check_usuario->query(
    "SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'"
);
if ($check_usuario->rowCount() > 0) {
    echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El usuario ingresado ya se encuentra registrado
        </div>';
    exit();
}
$check_usuario = null;


# Verificando claves
if ($clave_1 != $clave_2) {
    echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Las claves no coinciden
        </div>';
    exit();
} else {
    $clave = password_hash($clave_2, PASSWORD_BCRYPT, ["cost" => 10]);
}

#Guardar datos
$guardar_usuario = conexion();
$guardar_usuario = $guardar_usuario->prepare(
    "INSERT INTO usuario 
    (usuario_nombre, usuario_apellido, usuario_usuario, usuario_clave, usuario_email)
    VALUES (:nombre,:apellido,:usuario, :clave, :email)"
);

$marcadores = [
    "nombre" => $nombre,
    "apellido" => $apellido,
    "usuario" => $usuario,
    "clave" => $clave,
    "email" => $email
];

$guardar_usuario->execute($marcadores);

if ($guardar_usuario->rowCount() == 1) {
    echo '
        <div class="notification is-info">
            <strong>¡USUARIO REGISTRADO!</strong><br>
            El usuario se registro con exito
        </div>';
} else {
    echo '
        <div class="notification is-danger">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            Error al registrar el usuario
        </div>';
}

$guardar_usuario = null;
