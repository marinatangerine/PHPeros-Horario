<?php 
    require("header.php");

    $validationErrors = 0;
    $errorEmail = "";
    $errorUsername = "";
    $errorNIF = "";

    function registerStudent() {        
        global $connection;
        global $validationErrors;
        global $errorEmail;
        global $errorUsername;
        global $errorNIF;

        //recuperar las variables
        $username=$_POST['username'];
        $name=$_POST['name'];
        $surname=$_POST['surname'];
        $nif=$_POST['nif'];
        $email=$_POST['email'];
        $telephone=$_POST['telephone'];
        $pass=$_POST['pass'];

        //cifrado de password
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        //validación de email
        $sql = sprintf("SELECT count(*) as cuenta FROM students WHERE email='%s'", mysqli_real_escape_string($connection, $email));
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $count = $row["cuenta"];
        if ($count > 0) {
            $errorEmail = "Ya existe un usuario registrado con ese email";
            $validationErrors++;
        }
        //validación de username
        $sql = sprintf("SELECT count(*) as cuenta FROM students WHERE username='%s'", mysqli_real_escape_string($connection, $username));
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $count = $row["cuenta"];
        if ($count > 0) {
            $errorUsername = "Ya existe un usuario registrado con ese numbre de usuario";
            $validationErrors++;
        }
        //validación de nif
        $sql = sprintf("SELECT count(*) as cuenta FROM students WHERE nif='%s'", mysqli_real_escape_string($connection, $nif));
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $count = $row["cuenta"];
        if ($count > 0) {
            $errorNIF = "Ya existe un usuario registrado con ese NIF";
            $validationErrors++;
        }

        if($validationErrors == 0) {
            //sentencia sql
            $sql="INSERT INTO students (date_registered, email, name, nif, pass, surname, telephone, username) VALUES(NOW(), '$email', '$name', '$nif', '$pass', '$surname', '$telephone', '$username')";

            //ejecutar sentencia sql
            $go=mysqli_query($connection, $sql);
            mysqli_close($connection);
        }
    }

    if(isset($_POST['submit'])) {
        registerStudent();
    } else if(isset($_SESSION["role"])){
        redirectHome();
    }
?>
<div class="limiter">
<div class="title-register">
    <h1> Conviértete en PHPero<br/></h1>
</div>
<div class="container-register">
    <div class="wrap-register">
        <div class="half-wrapper">
            <div class="big-icon"><i class="fa fa-bug" aria-hidden="true"></i></div>
        </div>
        <div class="half-wrapper">
            <div class="form-body">
                <?php if(!isset($_POST['submit']) || $validationErrors > 0) {?>
                <form action="register.php" method="POST">

                    <span class="register-form-title"><p>Registro de alumnos</p> </span>

                    <div class="wrap-input validate-input">
                        <input 
                            class="input-register <?php if($errorUsername != "") echo "validation-error"; ?>"
                            title="<?php if($errorUsername != "") echo $errorUsername; ?>"
                            value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" 
                            type="text" 
                            name="username" 
                            placeholder="Nombre de usuario" 
                            required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input class="input-register" type="text" name="name" placeholder="Nombre" value="<?php if (isset($_POST['name'])) {
                    echo $_POST['name'];
                } ?>" required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input class="input-register" type="text" name="surname" placeholder="Apellidos" value="<?php if (isset($_POST['surname'])) {
                    echo $_POST['surname'];
                } ?>" required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input 
                            class="input-register <?php if($errorNIF != "") echo "validation-error"; ?>"
                            title="<?php if($errorNIF != "") echo $errorNIF; ?>"
                            value="<?php if(isset($_POST['nif'])) echo $_POST['nif']; ?>" 
                            type="text" 
                            name="nif" 
                            placeholder="DNI" 
                            required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input 
                            class="input-register <?php if($errorEmail != "") echo "validation-error"; ?>"
                            title="<?php if($errorEmail != "") echo $errorEmail; ?>"
                            value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" 
                            type="email" 
                            name="email" 
                            placeholder="Email" 
                            required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input class="input-register" type="tel" name="telephone" placeholder="Teléfono" value="<?php if (isset($_POST['telephone'])) {
                    echo $_POST['telephone'];
                } ?>" required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input class="input-register" type="password" name="pass" placeholder="Contraseña" required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-lock" aria-hidden="false"></i>
                    </span>
                    </div>

                    <br>
                    <?php if($validationErrors > 0) {?>
                        <div class="register-error">
                            <p>Revise los campos marcados e inténtelo de nuevo</p>
                        </div>
                    <?php }?>
                    <div class="btn-register">
                        <input type="submit" class="register-form-btn" name="submit" value="Registrarse"></input>
                    </div>

                </form>
                <?php } else {?>
                    <div class="register-success">
                        <p>Registro completado. Bienvenido a PHPeros</p>
                        <p>Está siendo redireccionado a la página de login. Si no es redirigido automáticamente pulse <a href="index.php">aquí</a></p>
                        <script language="javascript">setTimeout(function(){window.location.href="index.php";}, 5000);</script>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php
    require("footer.php");
?>