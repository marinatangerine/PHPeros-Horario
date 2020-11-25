<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];

    if($isAdmin) {
        redirectHome();
    }

    if(isset($_POST["submit"])) {
        $courseId = $_POST["courseId"];
    } else {
        $courseId = $_GET["courseId"];
    }
    $studentId = $_SESSION["userId"];

    $returnUrl = "listItems.php?itemType=".COURSEITEM;
    $courseName = "";
    $courseDateStart = "";
    $courseDateEnd = "";
    $currentStatus = "";

    function drawHeader() {
        global $itemType;

        echo "<table class=\"data-table\"><tr>";
        echo "<th>Fecha</th><th>Hora inicio</th><th>Hora fin</th><th>Clase</th><th>Profesor</th><th></th>";
        echo "</tr>";
    }

    function drawFooter() {
        echo "</table>";
    }

    function drawLine($row) {
        global $itemType;
        echo "<tr>";
        echo "<td>".$row["scheduleddate"]."</td><td>".$row["scheduledstart"]."</td><td>".$row["scheduledend"]."</td><td>".$row["classname"]."</td><td>".$row["teachername"]."</td><td></td>";
        echo "</tr>";
    }

    function drawtable() {
        global $connection;
        global $courseId;
        
        $sql = "select s.id_schedule as scheduleid, s.day as scheduleddate, s.time_start as scheduledstart, s.time_end as scheduledend, c.name as classname, CONCAT(t.name, ' ', t.surname) as teachername from schedule s inner join class c on s.id_class = c.id_class inner join teachers t on c.id_teacher = t.id_teacher inner join courses co on c.id_course = co.id_course where co.id_course = $courseId and co.active = 1 order by s.day, s.time_start, s.time_end";

        $result = $connection->query($sql);
        if(mysqli_num_rows($result) > 0) {
            echo "<div><span class=\"register-form-title\"><p>Programación actual</p> </span></div>";
            drawHeader();
            while ($row = $result->fetch_assoc()) {
                drawLine($row);
            }
            drawFooter();
        }
    }

    function saveChanges() {        
        global $connection;
        global $courseId;
        global $studentId;
        global $currentStatus;

        if($currentStatus == "") {
            $sql="insert into enrollment(id_student, id_course, status) values($studentId, '$courseId', 1)"; //no está en la tabla de enrollment => insertamos
        } else {
            if($currentStatus == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $sql="update enrollment set status = $status where id_student = $studentId and id_course = $courseId"; //está en la tabla de enrollment => actualizamos
        }

        $go=mysqli_query($connection, $sql);
    }

    function loadData() {
        global $connection;
        global $courseId;
        global $studentId;
        global $courseDateStart;
        global $courseDateEnd;
        global $courseName;
        global $currentStatus;

        $sql = "select date_start as coursedatestart, date_end as coursedateend from courses where id_course = $courseId";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $courseDateStart = $row["coursedatestart"];
        $courseDateEnd = $row["coursedateend"];

        $sql = "select name from courses where id_course = $courseId";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $courseName = $row["name"];

        $sql = "select status from enrollment where id_student = $studentId and id_course = $courseId";
        $result = $connection->query($sql);
        if(mysqli_num_rows($result) > 0) {
            $row = $result->fetch_assoc();
            $currentStatus = $row["status"];
        }
    }

    loadData();
    if(isset($_POST['submit'])) {
        saveChanges();
    }
?>
<div class="limiter">
    <div class="title-register">
        <h1><?php echo "$courseName ($courseDateStart - $courseDateEnd)";?></h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
        <div class="half-wrapper">
                <div class="big-icon"><i class="fa fa-folder-open" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                    <?php if(!isset($_POST['submit'])) {?>
                        <form action="enroll.php" method="POST">
                            <?php if($currentStatus != 1){?>
                                <span class="register-form-title"><p>¿Quieres matricularte en este curso?</p> </span>
                                <br>
                                <div class="btn-register">
                                    <input type="submit" class="register-form-btn" name="submit" value="Matricular"></input>
                                </div>
                            <?php } else {?>
                                <span class="register-form-title"><p>Actualmente estás matriculado en este curso. ¿Quieres anular tu matricula?</p> </span>
                                <br>
                                <div class="btn-register">
                                    <input type="submit" class="register-form-btn" name="submit" value="Anular matrícula"></input>
                                </div>
                            <?php }?>

                            <input name="studentId" value="<?php echo $studentId; ?>" style="display: none;">
                            <input name="courseId" value="<?php echo $courseId; ?>" style="display: none;">
                        </form>
                    <?php } else {?>
                        <div class="register-success">
                            <p>Cambios guardados correctamente</p>
                        </div>
                    <?php }?>
                    <p><a href="<?php echo $returnUrl?>">Volver</a></p>
                </div>
            </div>
            <?php drawtable();?>
        </div>
    </div>
</div>
<?php
    require("footer.php");
    mysqli_close($connection);
?>