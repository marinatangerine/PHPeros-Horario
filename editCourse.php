<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];

    if(!$isAdmin || (!isset($_GET["courseId"]) && !isset($_POST["courseId"]))) {
        redirectHome();
    }

    if(isset($_GET["courseId"])) {
        $courseId = $_GET["courseId"];
    } else {
        $courseId = $_POST["courseId"];
    }

    $name = "";
    $description = "";
    $datestart = "";
    $dateend = "";
    $active = 0;

    $datesError = "";

    //$title = 
    if($courseId != NEWITEM) {
        $title = "Editar curso";
    } else {
        $title = "Crear curso";
    }

    $returnUrl = "listItems.php?itemType=".COURSEITEM."&itemId=$courseId";

    function loadData() {
        global $connection;
        global $courseId;
        global $isAdmin;
        global $name;
        global $description;
        global $datestart;
        global $dateend;
        global $active;

        $sql = "SELECT id_course, name, description, date_start, date_end, active from courses WHERE id_course='$courseId'";
        $result = $connection->query($sql);
        if($result) {
            $row = $result->fetch_assoc();

            $name = $row["name"];
            $description = $row["description"];
            $datestart = $row["date_start"];
            $dateend = $row["date_end"];
            $active = $row["active"];
        }

        mysqli_close($connection);
    }

    function saveChanges() {        
        global $connection;
        global $courseId;
        global $datesError;

        //recuperar las variables
        $name=mysqli_real_escape_string($connection, $_POST['name']);
        $description=mysqli_real_escape_string($connection, $_POST['description']);
        $datestart=mysqli_real_escape_string($connection, $_POST['datestart']);
        $dateend=mysqli_real_escape_string($connection, $_POST['dateend']);
        if (isset($_POST['active'])) {
            $active = "1";
        } else {
            $active = "0";
        }

        $datestartCmp = strtotime($datestart);
        $dateendCmp = strtotime($dateend);
        if($datestartCmp >= $dateendCmp) {
            $datesError = "La fecha de fin debe ser posterior a la fecha de inicio";
        } else {
            if($courseId == NEWITEM) {
                $sql="INSERT INTO courses(name, description, date_start, date_end, active) VALUES('$name', '$description', '$datestart', '$dateend', '$active')";
            } else {
                $sql="UPDATE courses SET name = '$name', description = '$description', date_start = '$datestart', date_end = '$dateend', active = '$active' WHERE id_course = '$courseId'";
            }
            $go=mysqli_query($connection, $sql);
    
            mysqli_close($connection);
        }
    }

    if(isset($_POST['submit'])) {
        saveChanges();
    } else if ($courseId != NEWITEM){
        loadData();
    }
?>
<div class="limiter">
    <div class="title-register">
        <h1><?php echo $title;?></h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            <div class="half-wrapper">
                <div class="big-icon"><i class="fa fa-book" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                    <?php if(!isset($_POST['submit']) || $datesError != "") {?>
                    <form action="editCourse.php" method="POST">
                        <span class="register-form-title"><p><?php if (isset($_POST['name'])) echo $_POST['name'] ; else echo $name;?></p> </span>
                        
                        <div class="wrap-input validate-input">
                            <input class="input-register" type="text" name="name" placeholder="Nombre" 
                            value="<?php if (isset($_POST['name'])) echo $_POST['name']; else echo $name;?>" required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <input class="input-register" type="text" name="description" placeholder="Descripción" 
                            value="<?php if (isset($_POST['description'])) echo $_POST['description']; else echo $description;?>" required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register <?php if($datesError != "") echo "validation-error"; ?>"
                                title="<?php if($datesError != "") echo $datesError; ?>"
                                value="<?php if(isset($_POST['datestart'])) echo $_POST['datestart']; else echo $datestart;?>" 
                                type="date" 
                                name="datestart" 
                                placeholder="Fecha inicio" 
                                required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register <?php if($datesError != "") echo "validation-error"; ?>"
                                title="<?php if($datesError != "") echo $datesError; ?>"
                                value="<?php if(isset($_POST['dateend'])) echo $_POST['dateend']; else echo $dateend;?>" 
                                type="date" 
                                name="dateend" 
                                placeholder="Fecha fin" 
                                required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <span>Activo</span>
                            <input class="input-register" type="checkbox" name="active" placeholder="Activo" 
                            <?php 
                                if (isset($_POST['active'])) {
                                    if ($_POST['active'] == 1) {
                                        echo "checked";
                                    }
                                } else if ($active == 1) {
                                    echo "checked";
                                }
                            ?>
                            value="1">
                            <span class="focus-input"></span>
                        </div>

                        <input name="courseId" value="<?php echo $courseId; ?>" style="display: none;">

                        <br>
                        <div class="btn-register">
                            <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                        </div>
                        <p><a href="<?php echo $returnUrl?>">Cancelar</a></p>
                    </form>
                    <?php } else {?>
                        <div class="register-success">
                            <p>Cambios guardados correctamente</p>
                        </div>
                        <p><a href="<?php echo $returnUrl?>">Volver</a></p>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require("footer.php");
?>