<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];

    if(!$isAdmin || !isset($_GET["itemType"])) {
        redirectHome();
    }

    $itemType = $_GET["itemType"];

    switch ($itemType) {
        case TEACHERITEM:
            $listName = "Profesores";
            $editItemUrl = "editTeacher.php";
            $editItemName = "teacherId";
            break;
        case CLASSITEM:
            $listName = "Clases";
            $editItemUrl = "editClass.php";
            $editItemName = "classId";
            break;
        case COURSEITEM:
            $listName = "Cursos";
            $editItemUrl = "editCourse.php";
            $editItemName = "courseId";
            break;
    }

    function drawHeader() {
        global $itemType;

        echo "<table class=\"data-table\"><tr>";
        switch ($itemType) {
            case TEACHERITEM:
                echo "<th>#</th><th>Nombre</th><th>Apellidos</th><th>Teléfono</th><th>NIF</th><th>Email</th><th>Acciones</th>";
                break;
            case CLASSITEM:
                echo "<th>#</th><th>Nombre</th><th>Color</th><th>Profesor</th><th>Curso</th><th>Fecha</th><th>Hora Inicio</th><th>Hora Fin</th><th>Acciones</th>";
                break;
            case COURSEITEM:
                echo "<th>#</th><th>Nombre</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Activo</th><th>Acciones</th>";
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

    function drawLine($row) {
        global $itemType;
        echo "<tr>";
        switch ($itemType) {
            case TEACHERITEM:
                echo "<td>".$row["id_teacher"]."</td><td>".$row["name"]."</td><td>".$row["surname"]."</td><td>".$row["telephone"]."</td><td>".$row["nif"]."</td><td>".$row["email"]."</td><td>";
                addEditAction($row["id_teacher"]);
                addDeleteAction($row["id_teacher"]);
                echo "</td>";
                break;
            case CLASSITEM:
                echo "<td>".$row["id_class"]."</td><td>".$row["name"]."</td><td>".$row["color"]."</td><td>".$row["teacherName"]."</td><td>".$row["courseName"]."</td><td>".$row["scheduleDate"]."</td><td>".$row["scheduleTimeStart"]."</td><td>".$row["scheduleTimeEnd"]."</td><td>";
                addEditAction($row["id_class"]);
                addDeleteAction($row["id_class"]);
                echo "</td>";
                break;
            case COURSEITEM:
                echo "<td>".$row["id_course"]."</td><td>".$row["name"]."</td><td>".$row["description"]."</td><td>".$row["date_start"]."</td><td>".$row["date_end"]."</td><td>".$row["active"]."</td><td></td>";
                addEditAction($row["id_course"]);
                addDeleteAction($row["id_course"]);
                echo "</td>";
                break;
        }
        echo "</tr>";
    }

    function drawtable() {
        global $connection;
        global $itemType;
        
        switch ($itemType) {
            case TEACHERITEM:
                $sql = "SELECT id_teacher, name, surname, telephone, nif, email FROM teachers";
                break;
            case CLASSITEM:
                $sql = "select c.id_class, c.name, c.color, CONCAT(t.name, ' ', t.surname) as teacherName, co.name as courseName, s.day as scheduleDate, s.time_start as scheduleTimeStart, s.time_end as scheduleTimeEnd FROM class c INNER JOIN teachers t ON c.id_teacher = t.id_teacher INNER JOIN courses co on c.id_course = co.id_course INNER JOIN schedule s on c.id_schedule = s.id_schedule";
                break;
            case COURSEITEM:
                $sql = "SELECT id_course, name, description, date_start, date_end, active from courses";
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

        mysqli_close($connection);
    }
?>
<div class="limiter">
    <div class="title-register">
        <h1><?php echo $listName;?></h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            <?php drawtable();?>
        </div>
    </div>
</div>
<?php
    require("footer.php");
?>