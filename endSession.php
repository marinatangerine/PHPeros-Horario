<?php
    require("header.php");

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
?>
<div class="limiter">
    <div class="title-register">
        <h1>Sesión cerrada correctamente</h2>
    </div>
    <div class="subtitle-register">
        <p>Está siendo redireccionado a la página de login. Si no es redirigido automáticamente pulse <a href="index.php">aquí</a></p>
    </div>
    <!-- <script language="javascript">setTimeout(function(){window.location.href="index.php";}, 5000);</script> -->
    <div class="container-register">
        
    </div>
</div
<?php
    require("footer.php");
?>