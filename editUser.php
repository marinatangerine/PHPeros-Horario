<?php 
    require("header.php");

    $validationErrors = 0;
    $errorEmail = "";
    $errorUsername = "";
    $errorNIF = "";

    $userName = $_SESSION["userName"];
    $email = $_SESSION["email"];
    $name = $_SESSION["name"];
    $userId = $_SESSION["userId"];
    $surname = $_SESSION["surname"];
    $telephone = $_SESSION["telephone"];
    $nif = $_SESSION["nif"];
    $isAdmin = $_SESSION["role"] == roles[1];

    function loadData() {
        global $connection;
        global $userId;
        global $isAdmin;
        global $surname;
        global $telephone;
        global $nif;
        global $userName;
        global $email;
        global $name;

        if($isAdmin){
            $sql = "SELECT username, email, name FROM users_admin WHERE id_user_admin='$userId'";
            $result = $connection->query($sql);
            $row = $result->fetch_assoc();
            
            $userName = $row["username"];
            $email = $row["email"];
            $name = $row["name"];
        } else {
            $sql = "SELECT username, email, name, surname, telephone, nif FROM students WHERE id='$userId'";
            $result = $connection->query($sql);
            $row = $result->fetch_assoc();

            $username = $row["username"];
            $email = $row["email"];
            $name = $row["name"];
            $surname = $row["surname"];
            $telephone = $row["telephone"];
            $nif = $row["nif"];
        }
    }

    function saveChanges() {        
        global $connection;
        global $validationErrors;
        global $errorEmail;
        global $errorUsername;
        global $errorNIF;

        global $userId;
        global $isAdmin;

        //recuperar las variables
        $userName=mysqli_real_escape_string($connection, $_POST['username']);
        $name=mysqli_real_escape_string($connection, $_POST['name']);
        $pass=mysqli_real_escape_string($connection, $_POST['pass']);
        $email=mysqli_real_escape_string($connection, $_POST['email']);

        if(!$isAdmin){ //student
            $surname=mysqli_real_escape_string($connection, $_POST['surname']);
            $nif=mysqli_real_escape_string($connection, $_POST['nif']);
            $telephone=mysqli_real_escape_string($connection, $_POST['telephone']);
        }

        //validación de email
        $sql = "SELECT sum(cuenta) as cuenta from ((select count(*) as cuenta FROM users_admin where email = '$email') union (select count(*) from students where email = '$email')) as a";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $count = $row["cuenta"];
        if ($count > 0 && strcasecmp($_SESSION["email"], $email) != 0) {
            $errorEmail = "Ya existe un usuario registrado con ese email";
            $validationErrors++;
        }
        
        //validación de username
        $sql = "SELECT sum(cuenta) as cuenta from ((select count(*) as cuenta FROM users_admin where username = '$userName') union (select count(*) from students where username = '$userName')) as a";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $count = $row["cuenta"];
        if ($count > 0 && strcasecmp($_SESSION["userName"], $userName) != 0) {
            $errorUsername = "Ya existe un usuario registrado con ese numbre de usuario";
            $validationErrors++;
        }

        //validación de nif de alumnos
        if(!$isAdmin){
            $sql = "SELECT count(*) as cuenta FROM students WHERE nif='$nif'";
            $result = $connection->query($sql);
            $row = $result->fetch_assoc();
            $count = $row["cuenta"];
            if ($count > 0 && strcasecmp($_SESSION["nif"], $nif) != 0) {
                $errorNIF = "Ya existe un usuario registrado con ese NIF";
                $validationErrors++;
            }
        }

        if($validationErrors == 0) {
            if($isAdmin) {
                if($pass == "")
                    $sql="UPDATE users_admin SET username = '$userName', name = '$name', email = '$email' WHERE id_user_admin = '$userId'";
                else {
                    //cifrado de password
                    $pass = password_hash($pass, PASSWORD_DEFAULT);
                    $sql="UPDATE users_admin SET username = '$userName', name = '$name', email = '$email', password = '$pass' WHERE id_user_admin = '$userId'";
                }
            } else {
                if($pass == "")
                    $sql="UPDATE students SET username = '$userName', name = '$name', email = '$email', surname = '$surname', nif = '$nif', telephone = '$telephone' WHERE id = '$userId'";
                else {
                    //cifrado de password
                    $pass = password_hash($pass, PASSWORD_DEFAULT);
                    $sql="UPDATE students SET username = '$userName', name = '$name', email = '$email', pass = '$pass', surname = '$surname', nif = '$nif', telephone = '$telephone' WHERE id = '$userId'";
                }
            }

            //ejecutar sentencia sql
            $go=mysqli_query($connection, $sql);

            if($isAdmin)
                updateSessionData($userName, $name, $userId, $email, $_SESSION["role"], "", "", "");
            else
                updateSessionData($userName, $name, $userId, $email, $_SESSION["role"], $nif, $telephone, $surname);

            mysqli_close($connection);
        }
    }

    if(isset($_POST['submit'])) {
        saveChanges();
    } else {
        loadData();
    }
?>
<div class="limiter">
    <div class="container-register">
        <div class="wrap-register">
            <div class="hello-pic">
                <img src="images/hello.png" alt="Hola">
            </div>
            <?php if(!isset($_POST['submit']) || $validationErrors > 0) {?>
            <form action="editUser.php" method="POST">
                <span class="register-form-title"><p>Si no desea cambiar su contraseña déjela en blanco</p> </span>
                <div class="wrap-input validate-input">
                    <input 
                        class="input-register <?php if($errorUsername != "") echo "validation-error"; ?>"
                        title="<?php if($errorUsername != "") echo $errorUsername; ?>"
                        value="<?php if(isset($_POST['username'])) echo $_POST['username']; else echo $userName;?>" 
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
                    <input class="input-register" type="text" name="name" placeholder="Nombre" 
                    value="<?php if (isset($_POST['name'])) echo $_POST['name']; else echo $name;?>" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
                </div>

                <?php if(!$isAdmin) {?>
                    <div class="wrap-input validate-input">
                        <input class="input-register" type="text" name="surname" placeholder="Apellidos" 
                        value="<?php if (isset($_POST['surname'])) echo $_POST['surname']; else echo $surname;?>" required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                    </div>
                <?php }?>

                <?php if(!$isAdmin) {?>
                    <div class="wrap-input validate-input">
                        <input 
                            class="input-register <?php if($errorNIF != "") echo "validation-error"; ?>"
                            title="<?php if($errorNIF != "") echo $errorNIF; ?>"
                            value="<?php if(isset($_POST['nif'])) echo $_POST['nif']; else echo $nif;?>" 
                            type="text" 
                            name="nif" 
                            placeholder="DNI" 
                            required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                    </div>
                <?php }?>

                <div class="wrap-input validate-input">
                    <input 
                        class="input-register <?php if($errorEmail != "") echo "validation-error"; ?>"
                        title="<?php if($errorEmail != "") echo $errorEmail; ?>"
                        value="<?php if(isset($_POST['email'])) echo $_POST['email']; else echo $email;?>" 
                        type="email" 
                        name="email" 
                        placeholder="Email" 
                        required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
                </div>

                <?php if(!$isAdmin) {?>
                <div class="wrap-input validate-input">
                    <input class="input-register" type="tel" name="telephone" placeholder="Teléfono" 
                    value="<?php if (isset($_POST['telephone'])) echo $_POST['telephone']; else echo $telephone?>" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
                </div>
                <?php }?>

                <div class="wrap-input validate-input">
                    <input class="input-register" type="password" name="pass" placeholder="Contraseña">
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
                    <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                </div>

            </form>
            <?php } else {?>
                <div class="register-success">
                    <p>Cambios guardados correctamente</p>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<?php
    require("footer.php");
?>