<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];
    $itemType = $_GET["itemType"];

    if(!$isAdmin && $itemType != COURSEITEM) {
        redirectHome();
    }

    if(!$isAdmin){
        $studentId = $_SESSION["userId"];
    }

    switch ($itemType) {
        case TEACHERITEM:
            $listName = "Profesores";
            $editItemUrl = "editTeacher.php";
            $editItemName = "teacherId";
            $newItemText = "Crear profesor";
            break;
        case CLASSITEM:
            $listName = "Clases";
            $editItemUrl = "editClass.php";
            $editItemName = "classId";
            $newItemText = "Crear clase";
            break;
        case COURSEITEM:
            $listName = "Cursos";
            $editItemUrl = "editCourse.php";
            $editItemName = "courseId";
            $newItemText = "Crear curso";
            break;
    }

    function drawHeader() {
        global $itemType;
        global $isAdmin;

        echo "<table class=\"data-table\"><tr>";
        switch ($itemType) {
            case TEACHERITEM:
                echo "<th>#</th><th>Nombre</th><th>Apellidos</th><th>Teléfono</th><th>NIF</th><th>Email</th><th>Acciones</th>";
                break;
            case CLASSITEM:
                echo "<th>#</th><th>Nombre</th><th>Color</th><th>Profesor</th><th>Curso</th><th>Acciones</th>";
                break;
            case COURSEITEM:
                if ($isAdmin) {
                    echo "<th>#</th><th>Nombre</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Activo</th><th>Acciones</th>";
                } else {
                    echo "<th>#</th><th>Nombre</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Matriculado</th><th>Acciones</th>";
                }
                break;
        }
        echo "</tr>";
    }

    function drawFooter() {
        echo "</table>";
    }

    function addEditAction($itemId) {
        global $editItemUrl;
        global $editItemName;
        echo "<a class=\"icon\" href=\"".$editItemUrl."?".$editItemName."=".$itemId."\"><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></a>";
    }

    function addDeleteAction($itemId) {
        global $itemType;
        echo "<a class=\"icon\" href=\"deleteItem.php?itemType=".$itemType."&itemId=".$itemId."\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>";
    }

    function addScheduleAction($itemId) {
        global $itemType;
        echo "<a class=\"icon\" href=\"scheduleClass.php?classId=".$itemId."\"><i class=\"fa fa-calendar\" aria-hidden=\"true\"></i></a>";
    }

    function addEnrollAction($itemId) {
        global $itemType;
        echo "<a class=\"icon\" href=\"enroll.php?courseId=".$itemId."\"><i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i></a>";
    }

    function addStatusIcon($status){
        //0 no, 1 sí
        if($status == 1) {
            echo "<td class=\"status-icon ok\"><span class=\"icon\"><i class=\"fa fa-check fa-sm\" aria-hidden=\"true\"></i></span></td>";
        } else {
            echo "<td class=\"status-icon nok\"><span class=\"icon\"><i class=\"fa fa-close fa-sm\" aria-hidden=\"true\"></i></span></td>";
        }
    }

    function drawLine($row) {
        global $itemType;
        global $isAdmin;

        echo "<tr>";
        switch ($itemType) {
            case TEACHERITEM:
                echo "<td>".$row["id_teacher"]."</td><td>".$row["name"]."</td><td>".$row["surname"]."</td><td>".$row["telephone"]."</td><td>".$row["nif"]."</td><td>".$row["email"]."</td><td>";
                addEditAction($row["id_teacher"]);
                addDeleteAction($row["id_teacher"]);
                echo "</td>";
                break;
            case CLASSITEM:
                echo "<td>".$row["id_class"]."</td><td>".$row["name"]."</td><td>".$row["color"]."</td><td>".$row["teacherName"]."</td><td>".$row["courseName"]."</td><td>";
                addEditAction($row["id_class"]);
                addDeleteAction($row["id_class"]);
                if($row["courseActive"] == 1) {
                    addScheduleAction($row["id_class"]);
                }
                echo "</td>";
                break;
            case COURSEITEM:
                if($isAdmin) {
                    echo "<td>".$row["id_course"]."</td><td>".$row["name"]."</td><td>".$row["description"]."</td><td>".$row["date_start"]."</td><td>".$row["date_end"]."</td>";
                    addStatusIcon($row["active"]);
                    echo "<td>";
                    addEditAction($row["id_course"]);
                    addDeleteAction($row["id_course"]);
                } else {
                    echo "<td>".$row["id_course"]."</td><td>".$row["name"]."</td><td>".$row["description"]."</td><td>".$row["date_start"]."</td><td>".$row["date_end"]."</td>";
                    addStatusIcon($row["status"]);
                    echo "<td>";
                    addEnrollAction($row["id_course"]);
                }
                echo "</td>";
                break;
        }
        echo "</tr>";
    }

    function drawtable() {
        global $connection;
        global $itemType;
        global $isAdmin;
        global $studentId;
        
        switch ($itemType) {
            case TEACHERITEM:
                $sql = "SELECT id_teacher, name, surname, telephone, nif, email FROM teachers";
                break;
            case CLASSITEM:
                $sql = "select c.id_class, c.name, c.color, CONCAT(t.name, ' ', t.surname) as teacherName, co.name as courseName, co.active as courseActive FROM class c INNER JOIN teachers t ON c.id_teacher = t.id_teacher INNER JOIN courses co on c.id_course = co.id_course";
                break;
            case COURSEITEM:
                if($isAdmin) {
                    $sql = "SELECT id_course, name, description, date_start, date_end, active from courses";
                } else {
                    $sql = "SELECT c.id_course, c.name, c.description, c.date_start, c.date_end, (select e.status from enrollment e where e.id_student = $studentId and e.id_course = c.id_course) as status from courses c";
                }
                break;
        }

        $result = $connection->query($sql);
        if(mysqli_num_rows($result) > 0) {
            drawHeader();
            while ($row = $result->fetch_assoc()) {
                drawLine($row);
            }
            drawFooter();
        } else {
            echo "No hay datos para mostrar";
        }
    }
?>
<div class="limiter">
    <div class="title-register">
        <h1><?php echo $listName;?></h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            <?php if($isAdmin) { ?>
            <div class="add-items-actions">
                <a href="<?php echo $editItemUrl."?".$editItemName."=".NEWITEM;?>"><?php echo $newItemText;?></a>
            </div>
            <?php }?>
            <?php drawtable();?>
        </div>
    </div>
</div>
<?php
    require("footer.php");
?>