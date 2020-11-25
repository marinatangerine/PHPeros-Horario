<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];

    $studentId = "";
    if(!$isAdmin) {
        $studentId = $_SESSION["userId"];
    }

    $today =  date("Y-m-d");

    if(isset($_GET["date"])) {
        $selectedDate = $_GET["date"];
    } else {
        $selectedDate = $today;
    }

    if(isset($_GET["month"])) {
        $selectedMonth = $_GET["month"];
    } else {
        $selectedMonth = date('m', strtotime($today));
    }

    if(isset($_GET["year"])) {
        $selectedYear = $_GET["year"];
    } else {
        $selectedYear = date('Y', strtotime($today));
    }

    if(isset($_GET["view"])) {
        $selectedView = $_GET["view"];
    } else {
        $selectedView = "month";
    }

    $data = array();

    function drawHeader() {
        global $itemType;
        global $selectedView;
        global $selectedMonth;
        global $selectedYear;

        if($selectedMonth == 12){
            $nextMonth = 1;
            $nextYear = $selectedYear + 1;
        } else {
            $nextMonth = $selectedMonth + 1;
            $nextYear = $selectedYear;
        }

        if($selectedMonth == 1){
            $previousMonth = 12;
            $previousYear = $selectedYear - 1;
        } else {
            $previousMonth = $selectedMonth - 1;
            $previousYear = $selectedYear;
        }

        if($selectedView == "month") {
            echo "<div class=\"calendar-header\">";
            echo "<a class=\"icon\" href=\"calendar.php?month=$previousMonth&year=$previousYear\"><i class=\"fa fa-arrow-left\" aria-hidden=\"true\"></i></a>";
            echo "<span class=\"name\">".MONTHS[$selectedMonth - 1]." de $selectedYear</span>";
            echo "<a class=\"icon\" href=\"calendar.php?month=$nextMonth&year=$nextYear\"><i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></a>";
            echo "</div>";
            echo "<table class=\"calendar-table\"><tr>";
            echo "<th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th><th>Sábado</th><th>Domingo</th>";
            echo "</tr>";
        }
    }

    function drawCalendarLines() {
        global $itemType;
        global $today;
        global $selectedMonth;
        global $selectedYear;
        global $selectedView;

        $counter = 0;

        if ($selectedView == "month") {
            $lastMonthDay = date("t", strtotime($selectedYear."-".$selectedMonth."-1"));

            $monthStartWeekDay = date('w', strtotime($selectedYear."-".$selectedMonth."-1"));
            if($monthStartWeekDay == 0) {
                $monthStartWeekDay = 7;
            }

            while ($counter < $lastMonthDay) {
                echo "<tr>";
                for ($i=1; $i < 8; $i++) {
                    if(($counter == 0 && $i == $monthStartWeekDay) || ($counter > 0 && $counter < $lastMonthDay)) {
                        $counter++;
                        echo "<td><div class=\"calendarItem\">";
                        echo "<span>$counter</span>";
                        drawScheduledClass("$selectedYear-$selectedMonth-$counter");
                        echo "</div></td>";
                    } else {
                        echo "<td class=\"inactive\"></td>";
                    }
                }
                echo "</tr>";
            }
        }
    }

    function drawFooter() {
        echo "</table>";
    }

    function drawScheduledClass($date) {
        global $data;

        for ($i=0; $i < count($data); $i++) { 
            $schedule = $data[$i];
            $scheduleDate = strtotime($schedule["scheduleddate"]);
            $dayDate = strtotime($date);
            if($scheduleDate == $dayDate) {
                $bgcolor = $schedule["color"];
                if($schedule["whitetext"] == 1) {
                    $color = "#FFF";
                } else {
                    $color = "#000";
                }
                $className = $schedule["className"];
                $start = $schedule["scheduledstart"];
                $end = $schedule["scheduledend"];
                $courseName = $schedule["coursename"];
                $teacherName = $schedule["teachername"];

                echo "<div class=\"scheduleElement\" style=\"background-color: #$bgcolor; color: $color\" title=\"$courseName con $teacherName\">";
                echo "$className $start-$end";
                echo "</div>";
            }
        }
    }

    function loadData() {
        global $connection;
        global $selectedView;
        global $studentId;
        global $selectedMonth;
        global $isAdmin;
        global $selectedDate;
        global $today;

        global $data;
        
        if($isAdmin) {
            $sql = "select s.day as scheduleddate, s.time_start as scheduledstart, s.time_end as scheduledend, c.name as className, col.hex as color, col.whitetext, co.name as coursename, CONCAT(t.name, ' ', t.surname) as teachername from schedule s inner join class c on s.id_class = c.id_class inner join teachers t on c.id_teacher = t.id_teacher inner join courses co on c.id_course = co.id_course inner join colors col on c.color = col.name where co.active = 1 order by s.day, s.time_start, s.time_end";
        } else {
            $sql = "select s.day as scheduleddate, s.time_start as scheduledstart, s.time_end as scheduledend, c.name as className, col.hex as color, col.whitetext, co.name as coursename, CONCAT(t.name, ' ', t.surname) as teachername from schedule s inner join class c on s.id_class = c.id_class inner join teachers t on c.id_teacher = t.id_teacher inner join courses co on c.id_course = co.id_course inner join colors col on c.color = col.name inner join enrollment e on e.id_course = co.id_course where co.active = 1 and e.status = 1 and e.id_student = $studentId order by s.day, s.time_start, s.time_end";
        }

        $result = $connection->query($sql);
        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                $data[] = $row;
            }
        }
    }

    loadData();
?>
<div class="limiter">
    <div class="title-register">
        <h1>Calendario</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            <?php 
                drawHeader();
                drawCalendarLines();
                drawFooter();
            ?>
        </div>
    </div>
</div>
<?php
    require("footer.php");
?>