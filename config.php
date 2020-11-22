<?php
session_start();

//conexión a base de datos
$connection = mysqli_connect("localhost", "root", "", "calendario") or die($connection);

//comprobación de la conexión
if (!$connection) {
    echo "Error" . PHP_EOL;
    echo "Error de depuración: " . mysqli_connect_errno() . PHP_EOL;
}

define("roles", ["student", "admin"]); //roles 0, 1 y 2

function redirectHome(){
    switch($_SESSION["role"]) {
        case roles[0]: 
            header("Location: student.php");
            exit();
            break;
        case roles[1]:
            header("Location: admin.php");
            exit();
            break;
    }
}

function endSession() {
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    header("Location: index.php");
}

function updateSessionData($userName, $name, $userId, $email, $role, $nif, $telephone, $surname) {
    $_SESSION["userName"] = $userName;
    $_SESSION["name"] = $name;
    $_SESSION["userId"] = $userId;
    $_SESSION["email"] = $email;
    $_SESSION["role"] = $role;
    $_SESSION["nif"] = $nif;
    $_SESSION["telephone"] = $telephone;
    $_SESSION["surname"] = $surname;
}
?>