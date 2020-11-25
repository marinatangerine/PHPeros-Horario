<?php
session_start();

//conexión a base de datos
$connection = mysqli_connect("localhost", "root", "", "calendario") or die($connection);

//comprobación de la conexión
if (!$connection) {
    echo "Error" . PHP_EOL;
    echo "Error de depuración: " . mysqli_connect_errno() . PHP_EOL;
}

define("ROLES", ["student", "admin"]); //roles 0, 1 y 2
define("NEWITEM", "new"); //para identificar creación de nuevos elementos

define("CLASSITEM", "class"); //identificador de clases
define("TEACHERITEM", "teacher");  //identificador de procesores
define("COURSEITEM", "course");  //identificador de alumnos
define("SCHEDULEITEM", "schedule");  //identificador de horario

define("MONTHS", ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]);


function redirectHome(){
    switch($_SESSION["role"]) {
        case ROLES[0]: 
            header("Location: student.php");
            exit();
            break;
        case ROLES[1]:
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