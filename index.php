<?php require './inc/session_start.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php require './inc/head.php'; ?>
</head>

<body>
    <?php

    if (!isset($_GET['vista']) || $_GET['vista'] == '') {
        $_GET['vista'] = "login";
    }

    if (
        is_file("./vistas/" . $_GET['vista'] . ".php") &&
        $_GET['vista'] != 'login' && $_GET['vista'] != '404'
    ) {
        #Cerrar sesion
        if ((!isset($_SESSION['id'])) || (empty($_SESSION['id']))) {
            include './vistas/logout.php';
            exit();
        }
        include './inc/navbar.php';
        include "./vistas/" . $_GET['vista'] . ".php";
        include './inc/script.php';
    } else {
        if ($_GET['vista'] == 'login') {
            include "./vistas/login.php";
        } else {
            include "./vistas/404.php";
        }
    }

    ?>
</body>

</html>