<?php
    require("config.php");
    if(isset($_SESSION["role"])) {
        $isAdmin = $_SESSION["role"] == ROLES[1];
    }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="PHPeros">
    <title>PHPeros School</title>

    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="index.css">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>

    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lato&family=Raleway&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="title">
            <a href="index.php"><strong>PHP</strong>eros</a>
        </div>
        <ul id="menu">
            <?php if(isset($_SESSION["userName"])) {?>
            <li><a href="calendar.php">Calendario</a></li>
            <?php if($isAdmin) {?>
            <li><a href="listItems.php?itemType=<?php echo TEACHERITEM;?>">Profesores</a></li>
            <?php }?>
            <li><a href="listItems.php?itemType=<?php echo COURSEITEM;?>">Cursos</a></li>
            <?php if($isAdmin) {?>
            <li><a href="listItems.php?itemType=<?php echo CLASSITEM;?>">Clases</a></li>
            <?php }?>
            <?php }?>
        </ul>
        <div class="session">
            <?php if(isset($_SESSION["role"])) {?>
                <div>
                    Bienvenid@ <?php echo $_SESSION["name"];?>!
                </div>
                <div>
                    <a class="icon" href="editUser.php">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                    </a>
                    <a class="icon" href="endSession.php">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
                </div>
            <?php }?>
        </div>
    </div>