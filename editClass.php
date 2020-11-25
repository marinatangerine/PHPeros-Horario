<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];

    if(!$isAdmin || (!isset($_GET["classId"]) && !isset($_POST["classId"]))) {
        redirectHome();
    }

    if(isset($_GET["classId"])) {
        $classId = $_GET["classId"];
    } else {
        $classId = $_POST["classId"];
    }

    $teacherid = "";
    $courseid = "";
    $name = "";
    $color = "";
    $emptyDropdowns = 0;

    //$title = 
    if($classId != NEWITEM) {
        $title = "Editar clase";
    } else {
        $title = "Crear clase";
    }

    $returnUrl = "listItems.php?itemType=".CLASSITEM."&itemId=$classId";

    function loadTeachers() {
        global $connection;
        global $emptyDropdowns;
        global $teacherid;
        global $classId;
        
        if($teacherid == ""){
            $sql = "SELECT id_teacher AS value, CONCAT(name, ' ', surname) AS name FROM teachers t WHERE NOT EXISTS(SELECT 1 FROM class c WHERE t.id_teacher = c.id_teacher)";
        } else {
            $sql = "SELECT id_teacher AS value, CONCAT(name, ' ', surname) AS name FROM teachers t WHERE NOT EXISTS(SELECT 1 FROM class c WHERE t.id_teacher = c.id_teacher) OR id_teacher = $teacherid";
        }

        $result = $connection->query($sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<label for=\"teacherid\">Profesor</label><select name=\"teacherid\" class=\"input-register\" placeholder=\"Profesor\">";
            while ($row = $result->fetch_assoc()) {
                if(($classId != NEWITEM) && ($row["value"] == $teacherid)) {
                    $selected = "selected=selected";
                } else {
                    $selected = "";
                }
                echo "<option value=\"".$row["value"]."\" ".$selected.">".$row["name"]."</option>";
            }
            echo "</select>";
        } else {
            echo "No hay profesores disponibles";
            $emptyDropdowns++;
        }
    }

    function loadCourses() {
        global $connection;
        global $emptyDropdowns;
        global $courseid;
        global $classId;
        
        $sql = "SELECT id_course AS value, name FROM courses WHERE active = 1";
        $result = $connection->query($sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<label for=\"courseid\">Curso</label><select name=\"courseid\" class=\"input-register\" placeholder=\"Curso\">";
            while ($row = $result->fetch_assoc()) {
                if(($classId != NEWITEM) && ($row["value"] == $courseid)) {
                    $selected = "selected=selected";
                } else {
                    $selected = "";
                }
                echo "<option value=\"".$row["value"]."\" ".$selected.">".$row["name"]."</option>";
            }
            echo "</select>";
        } else {
            echo "No hay cursos activos";
            $emptyDropdowns++;
        }
    }

    function loadColors() {
        global $connection;
        global $emptyDropdowns;
        global $color;
        global $classId;
        
        if($color == ""){
            $sql = "SELECT name AS value FROM colors co WHERE NOT EXISTS(SELECT 1 FROM class c WHERE co.name = c.color)";
        } else {
            $sql = "SELECT name AS value FROM colors co WHERE NOT EXISTS(SELECT 1 FROM class c WHERE co.name = c.color) OR name = '$color'";
        }

        $result = $connection->query($sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<label for=\"color\">Color</label><select name=\"color\" class=\"input-register\" placeholder=\"Color\">";
            while ($row = $result->fetch_assoc()) {
                if(($classId != NEWITEM) && ($row["value"] == $color)) {
                    $selected = "selected=selected";
                } else {
                    $selected = "";
                }
                echo "<option value=\"".$row["value"]."\" ".$selected.">".$row["value"]."</option>";
            }
            echo "</select>";
        } else {
            echo "No hay profesores disponibles";
            $emptyDropdowns++;
        }
    }

    function loadData() {
        global $connection;
        global $isAdmin;
        global $classId;
        global $teacherid;
        global $courseid;
        global $name;
        global $color;

        $sql = "SELECT id_teacher, id_course, name, color FROM class WHERE id_class='$classId'";
        $result = $connection->query($sql);
        if($result) {
            $row = $result->fetch_assoc();

            $teacherid = $row["id_teacher"];
            $courseid = $row["id_course"];
            $name = $row["name"];
            $color = $row["color"];
        }
    }

    function saveChanges() {        
        global $connection;
        global $classId;

        //recuperar las variables
        $teacherid=mysqli_real_escape_string($connection, $_POST['teacherid']);
        $courseid=mysqli_real_escape_string($connection, $_POST['courseid']);
        $name=mysqli_real_escape_string($connection, $_POST['name']);
        $color=mysqli_real_escape_string($connection, $_POST['color']);

        if($classId == NEWITEM) {
            $sql="INSERT INTO class(id_teacher, id_course, id_schedule, name, color) VALUES('$teacherid', '$courseid', 0, '$name', '$color')";
        } else {
            $sql="UPDATE class SET id_teacher = '$teacherid', id_course = '$courseid', name = '$name', color = '$color' WHERE id_class = '$classId'";
        }
        $go=mysqli_query($connection, $sql);
    }

    if(isset($_POST['submit'])) {
        saveChanges();
    } else if ($classId != NEWITEM){
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
                <div class="big-icon"><i class="fa fa-child" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                    <?php if(!isset($_POST['submit'])) {?>
                    <form action="editClass.php" method="POST">
                        <span class="register-form-title"><p><?php if (isset($_POST['name'])) echo $_POST['name'] ; else echo $name;?></p> </span>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register"
                                value="<?php if(isset($_POST['name'])) echo $_POST['name']; else echo $name;?>" 
                                type="text" 
                                name="name" 
                                placeholder="Nombre" 
                                required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <?php loadTeachers();?>
                        </div>

                        <div class="wrap-input validate-input">
                            <?php loadCourses();?>
                        </div>

                        <div class="wrap-input validate-input">
                            <?php loadColors();?>
                        </div>

                        <input name="classId" value="<?php echo $classId; ?>" style="display: none;">

                        <br>
                        <?php if($emptyDropdowns == 0) {?>
                        <div class="btn-register">
                            <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                        </div>
                        <?php } else echo "Faltan datos para poder crear una clase";?>
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