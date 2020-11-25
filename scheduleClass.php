<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];

    if(!$isAdmin) {
        redirectHome();
    }

    if(isset($_POST["submit"])) {
        $classId = $_POST["classId"];
    } else {
        $classId = $_GET["classId"];
    }

    $timeError = "";
    $dateError = "";
    $returnUrl = "listItems.php?itemType=".CLASSITEM;
    $courseDateStart = "";
    $courseDateEnd = "";
    $className = "";

    function drawHeader() {
        global $itemType;

        echo "<table class=\"data-table\"><tr>";
        echo "<th>Fecha</th><th>Hora inicio</th><th>Hora fin</th><th>Curso</th><th>Profesor</th><th>Acciones</th>";
        echo "</tr>";
    }

    function drawFooter() {
        echo "</table>";
    }

    function addDeleteAction($itemId) {
        global $itemType;
        echo "<a class=\"icon\" href=\"deleteItem.php?itemType=".SCHEDULEITEM."&itemId=".$itemId."\"><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a>";
    }

    function drawLine($row) {
        global $itemType;
        echo "<tr>";
        echo "<td>".$row["scheduleddate"]."</td><td>".$row["scheduledstart"]."</td><td>".$row["scheduledend"]."</td><td>".$row["coursename"]."</td><td>".$row["teachername"]."</td><td>";
        addDeleteAction($row["scheduleid"]);
        echo "</td>";
        echo "</tr>";
    }

    function drawtable() {
        global $connection;
        global $classId;
        
        $sql = "select s.id_schedule as scheduleid, s.day as scheduleddate, s.time_start as scheduledstart, s.time_end as scheduledend, co.name as coursename, CONCAT(t.name, ' ', t.surname) as teachername from schedule s inner join class c on s.id_class = c.id_class inner join teachers t on c.id_teacher = t.id_teacher inner join courses co on c.id_course = co.id_course where c.id_class = $classId and co.active = 1 order by s.day, s.time_start, s.time_end";

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
        global $classId;
        global $dateError;
        global $timeError;
        global $courseDateStart;
        global $courseDateEnd;

        //recuperar las variables
        $scheduledate=mysqli_real_escape_string($connection, $_POST['scheduledate']);
        $timestart=mysqli_real_escape_string($connection, $_POST['timestart']);
        $timeend=mysqli_real_escape_string($connection, $_POST['timeend']);
        
        //validación de fecha
        $datestartCmp = strtotime($courseDateStart);
        $dateendCmp = strtotime($courseDateEnd);
        $scheduledateCmp = strtotime($scheduledate);

        if(($scheduledateCmp > $dateendCmp) || ($scheduledateCmp < $datestartCmp)) {
            $dateError = "La fecha debe estar entre el $courseDateStart y el $courseDateEnd";
        } else {
            $sql="insert into schedule(id_class, time_start, time_end, day) values($classId, '$timestart', '$timeend', '$scheduledate')";
            $go=mysqli_query($connection, $sql);
        }
    }

    function loadData() {
        global $connection;
        global $classId;
        global $courseDateStart;
        global $courseDateEnd;
        global $className;

        $sql = "select co.date_start as coursedatestart, co.date_end as coursedateend from class c inner join courses co on c.id_course = co.id_course where c.id_class = $classId";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc(); //sabemos que el curso de la clase existe, por lo que asumimos que hay files
        $courseDateStart = $row["coursedatestart"];
        $courseDateEnd = $row["coursedateend"];

        $sql = "select name from class where id_class = $classId";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $className = $row["name"];
    }

    loadData();
    if(isset($_POST['submit'])) {
        saveChanges();
    }
?>
<div class="limiter">
    <div class="title-register">
        <h1><?php echo $className;?></h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
        <div class="half-wrapper">
                <div class="big-icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                    <form action="scheduleClass.php" method="POST">
                        <span class="register-form-title"><p>Programar clase (<?php echo "$courseDateStart - $courseDateEnd";?>)</p> </span>
                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register <?php if($dateError != "") echo "validation-error"; ?>"
                                title="<?php if($dateError != "") echo $dateError; ?>"
                                value="<?php if($dateError != "") echo $_POST['scheduledate'];?>" 
                                type="date" 
                                name="scheduledate" 
                                placeholder="Fecha" 
                                required>
                        </div>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register <?php if($timeError != "") echo "validation-error"; ?>"
                                title="<?php if($timeError != "") echo $timeError; ?>"
                                value="<?php if($timeError != "") echo $_POST['timestart'];?>" 
                                type="time" 
                                name="timestart" 
                                placeholder="Hora inicio" 
                                required>
                        </div>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register <?php if($timeError != "") echo "validation-error"; ?>"
                                title="<?php if($timeError != "") echo $timeError; ?>"
                                value="<?php if($timeError != "") echo $_POST['timeend'];?>" 
                                type="time" 
                                name="timeend" 
                                placeholder="Hora fin" 
                                required>
                        </div>

                        <input name="classId" value="<?php echo $classId; ?>" style="display: none;">

                        <br>
                        <div class="btn-register">
                            <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                        </div>
                    </form>
                    <?php if(isset($_POST['submit']) && $dateError == "" && $timeError == "") {?>
                        <div class="register-success">
                            <p>Cambios guardados correctamente</p>
                        </div>
                    <?php } else if ($dateError != "" || $timeError != ""){?>
                        <div class="register-error">
                            <p>Revise los campos marcados e inténtelo de nuevo</p>
                        </div>
                    <?php } ?>
                    <p><a href="<?php echo $returnUrl?>">Volver</a></p>
                </div>
            </div>
            <?php drawtable();?>
        </div>
    </div>
</div>
<?php
    require("footer.php");
?>