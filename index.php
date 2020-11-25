<?php
require("header.php");
$errorLogin = false;

function login() {
    global $connection;
    global $errorLogin;
    
    //Obtener los datos cargados en el formulario de login
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    //Consulta segura para evitar inyecciones SQL
    $sql = sprintf("SELECT username, name, id, email, pass, nif, telephone, surname FROM students WHERE email='%s'", mysqli_real_escape_string($connection, $email));
    $result = $connection->query($sql);
    //Verificando si el usuario existe en la tabla students en la base de datos
    if(mysqli_num_rows($result) > 0){
        $row = $result->fetch_assoc();
        if(password_verify($pass, $row["pass"])){
            //Guardo en la sesión en username del estudiante
            updateSessionData($row["username"], $row["name"], $row["id"], $row["email"], ROLES[0], $row["nif"], $row["telephone"], $row["surname"]);
            //Redirecciono a su home
            redirectHome();
        }else{
            $errorLogin = true;
        }
        
    }else{
        $sql = sprintf("SELECT username, name, id_user_admin, email, password FROM users_admin WHERE email='%s'", mysqli_real_escape_string($connection, $email));
        $result = $connection->query($sql);
        //Verificando si el usuario es un administrador
        if(mysqli_num_rows($result) > 0){
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row["password"])) {
                //Guardo en la sesión el username del administrador
                updateSessionData($row["username"], $row["name"], $row["id_user_admin"], $row["email"], ROLES[1], "", "", "");
                //Redirecciono a su home
                redirectHome();
            }
        }else{
            $errorLogin = true;
        }
    }
}

if(isset($_POST['submit'])) {
    login();
}elseif(isset($_SESSION["role"])){
    redirectHome();
}
?>
<div class="limiter">
    <div class="container-login">
        <div class="wrap-login">
            <div class="login-pic">
                <img src="images/img-02.png" alt="Imagen Login">
            </div>
            <form action="index.php" method="POST" class = "login-form validate-form col-6">
                <span class="login-form-title"><p> Accede a PHPeros School</p> </span>

                <div class="wrap-input validate-input">
                    <input class="input-login" type="email" name="email" placeholder="Email" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>
                <br>
                <div class="wrap-input validate-input">
                    <input class="input-login" type="password" name="pass" placeholder="Contraseña" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                        <i class="fa fa-lock" aria-hidden="false"></i>
                    </span>
                </div>
                <br>
                <?php if($errorLogin) {?>
                    <div class="login-error">
                        <p>Usuario o contraseñas incorrectos</p>
                    </div>
                <?php }?>
                <div class="btn-login">
                    <input type="submit" class="login-form-btn" name="submit" value="Entrar"></input>
                </div>
                <div class="register">
                    <span><a href="register.php"> <p>Regístrate </a>para formar parte de nuestra comunidad</p> </span>
                </div>

            </form>

        </div>
    </div>
</div>
<?php
    require("footer.php");
?>