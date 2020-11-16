<?php
//includes
include('conexion.php');

//comprobación de la conexión con la base de datos
echo "Éxito!: Se realizó una conexión apropiada a MySQL" . PHP_EOL;
echo "Información del host: " . mysqli_get_host_info($connection) . PHP_EOL;

//cierre de la conexión con la base de datos
mysqli_close($connection);

?>