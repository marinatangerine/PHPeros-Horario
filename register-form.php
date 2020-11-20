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
}


//recuperar las variables
$username=$_POST['username'];
$name=$_POST['name'];
$surname=$_POST['surname'];
$nif=$_POST['nif'];
$email=$_POST['email'];
$telephone=$_POST['telephone'];
$pass=$_POST['pass'];

//sentencia sql
$sql="INSERT INTO students (date_registered, email, name, nif, pass, surname, telephone, username) VALUES(NOW(), '$email', '$name', '$nif', '$pass', '$surname', '$telephone', '$username')";

//ejecutar sentencia sql
$go=mysqli_query($connection, $sql);

//verificamos la ejecución
if(!$go){
    echo"Error" . $sql . "<br>" . mysqli_errno($connection);
}else{
    echo"Datos Guardados Correctamente<br><a href='index.html'>Volver</a>";
}
mysqli_close($connection);
?>