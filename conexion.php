<?php

//variables de conexión
$server = "localhost";
$user = "root";
$pass = "";
$db = "calendario";

//conexión a la base de datos
$connection = mysqli_connect($server, $user, $pass, $db);

//comprobación de la conexión
if (!$connection) {
    echo "Error" . PHP_EOL;
    echo "Error de depuración: " . mysqli_connect_errno() . PHP_EOL;
    exit;
}


?>