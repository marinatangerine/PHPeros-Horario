<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];

    if(!$isAdmin || (!isset($_GET["teacherId"]) && !isset($_POST["teacherId"]))) {
        redirectHome();
    }

    if(isset($_GET["teacherId"])) {
        $teacherId = $_GET["teacherId"];
    } else {
        $teacherId = $_POST["teacherId"];
    }

    $validationErrors = 0;
    $errorEmail = "";
    $errorNIF = "";

    $email = "";
    $name = "";
    $surname = "";
    $telephone = "";
    $nif = "";

    function loadData() {
        global $connection;
        global $teacherId;
        global $isAdmin;
        global $surname;    
        global $telephone;
        global $nif;
        global $email;
        global $name;

        $sql = "SELECT name, surname, telephone, nif, email FROM teachers WHERE id_teacher='$teacherId'";
        $result = $connection->query($sql);
        if($result) {
            $row = $result->fetch_assoc();

            $email = $row["email"];
            $name = $row["name"];
            $surname = $row["surname"];
            $telephone = $row["telephone"];
            $nif = $row["nif"];
        }

        mysqli_close($connection);
    }

    function saveChanges() {        
        global $connection;
        global $validationErrors;
        global $errorEmail;
        global $errorNIF;
        global $teacherId;

        //recuperar las variables
        $name=mysqli_real_escape_string($connection, $_POST['name']);
        $email=mysqli_real_escape_string($connection, $_POST['email']);
        $surname=mysqli_real_escape_string($connection, $_POST['surname']);
        $nif=mysqli_real_escape_string($connection, $_POST['nif']);
        $telephone=mysqli_real_escape_string($connection, $_POST['telephone']);

        $originalNif=mysqli_real_escape_string($connection, $_POST['originalNif']);
        $originalEmail=mysqli_real_escape_string($connection, $_POST['originalEmail']);

        //validación de email
        $sql = "SELECT sum(cuenta) as cuenta from ((select count(*) as cuenta FROM users_admin where email = '$email') union (select count(*)as cuenta from students where email = '$email') union (select count(*) as cuenta from teachers where email = '$email')) as a";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $count = $row["cuenta"];
        if ($count > 0 && strcasecmp($originalEmail, $email) != 0) {
            $errorEmail = "Ya existe una persona registrada con ese email";
            $validationErrors++;
        }

        //validación de nif
        $sql = "SELECT sum(cuenta) as cuenta from ((select count(*) as cuenta from students where nif = '$nif') union (select count(*) as cuenta from teachers where nif = '$nif')) as a";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $count = $row["cuenta"];
        if ($count > 0 && strcasecmp($originalNif, $nif) != 0) {
            $errorNIF = "Ya existe una persona registrada con ese NIF";
            $validationErrors++;
        }

        if($validationErrors == 0) {
            if($teacherId == NEWITEM) {
                $sql="INSERT INTO teachers(name, surname, nif, telephone, email) VALUES('$name', '$surname', '$nif', '$telephone', '$email')";
            } else {
                $sql="UPDATE teachers SET name = '$name', email = '$email', surname = '$surname', nif = '$nif', telephone = '$telephone' WHERE id_teacher = '$teacherId'";
            }
            $go=mysqli_query($connection, $sql);

            mysqli_close($connection);
        }
    }

    if(isset($_POST['submit'])) {
        saveChanges();
    } else if ($teacherId != NEWITEM){
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
            <form action="editTeacher.php" method="POST">
                <span class="register-form-title"><p><?php if (isset($_POST['name'])) echo $_POST['name'] . " " . $_POST['surname'] ; else echo $name . " " . $surname;?></p> </span>
                <div class="wrap-input validate-input">
                    <input class="input-register" type="text" name="name" placeholder="Nombre" 
                    value="<?php if (isset($_POST['name'])) echo $_POST['name']; else echo $name;?>" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
                </div>

                <div class="wrap-input validate-input">
                    <input class="input-register" type="text" name="surname" placeholder="Apellidos" 
                    value="<?php if (isset($_POST['surname'])) echo $_POST['surname']; else echo $surname;?>" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
                </div>

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
                <input name="originalNif" value="<?php if(isset($_POST['originalNif'])) echo $_POST['originalNif']; else echo $nif;?>" style="display: none;">

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
                <input name="originalEmail" value="<?php if(isset($_POST['originalEmail'])) echo $_POST['originalEmail']; else echo $email; ?>" style="display: none;">

                <div class="wrap-input validate-input">
                    <input class="input-register" type="tel" name="telephone" placeholder="Teléfono" 
                    value="<?php if (isset($_POST['telephone'])) echo $_POST['telephone']; else echo $telephone?>" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>

                <input name="teacherId" value="<?php echo $teacherId; ?>" style="display: none;">

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