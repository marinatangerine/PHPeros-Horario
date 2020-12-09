<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="PHP3ros">
    <title>PHP3ros School</title>

    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>

    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lato&family=Raleway&display=swap" rel="stylesheet">
    <link href="{{URL::asset('css/app.css')}}" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="header">
        <div class="title">
            <a href="index.php"><strong>PHP</strong>3ros</a>
        </div>
        <ul id="menu">
            @if(Session::has('role'))
                <li><a href="calendar.php">Calendario</a></li>
                @if(Session::get('role') === 1)
                <li><a href="listItems.php?itemType=teacher">Profesores</a></li>
                @endif
                <li><a href="listItems.php?itemType=course">Cursos</a></li>
                @if(Session::get('role') < 3)
                <li><a href="listItems.php?itemType=class">Clases</a></li>
                @endif
            @endif
        </ul>
        <div class="session">
            @if(Session::has('role'))
                <div>
                    Bienvenid@ {{ Session::get('user')->name }}!
                </div>
                <div>
                    <a class="icon" href="editUser.php">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                    </a>
                    <a class="icon" href="logout">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>