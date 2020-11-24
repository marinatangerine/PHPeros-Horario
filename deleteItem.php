<?php 
    require("header.php");

    $isAdmin = $_SESSION["role"] == ROLES[1];

    if((!$isAdmin || !isset($_GET["itemType"]) || !isset($_GET["itemId"])) && !isset($_POST["submit"])) {
        redirectHome();
    }

    if(isset($_POST["submit"])) {
        $itemType = $_POST["itemType"];
        $itemId = $_POST["itemId"];
    } else {
        $itemType = $_GET["itemType"];
        $itemId = $_GET["itemId"];
    }

    $itemName = "";
    $errorText = "";
    $returnUrl = "listItems.php?itemType=$itemType";

    switch ($itemType) {
        case TEACHERITEM:
            $itemTypeError = "El profesor no se puede eliminar. Tiene datos asociados";
            $itemTypeSuccess = "Profesor eliminado correctamente";
            $itemTypeText = "¿Seguro que desea eliminar el profesor?";
            break;
        case CLASSITEM:
            $itemTypeError = "La clase no se puede eliminar. Tiene datos asociados";
            $itemTypeSuccess = "Clase eliminada correctamente";
            $itemTypeText = "¿Seguro que desea eliminar la clase?";
            break;
        case COURSEITEM:
            $itemTypeError = "El curso no se puede eliminar. Tiene datos asociados";
            $itemTypeSuccess = "Curso eliminado correctamente";
            $itemTypeText = "¿Seguro que desea eliminar el cruso?";
            break;
    }
    

    function loadData() {
        global $connection;
        global $itemType;
        global $itemId;
        global $itemName;
        
        switch ($itemType) {
            case TEACHERITEM:
                $sql = "SELECT CONCAT(name, ' ', surname) as itemdesc FROM teachers WHERE id_teacher = $itemId";
                break;
            case CLASSITEM:
                $sql = "SELECT CONCAT(name, ' (', color, ')') as itemdesc FROM class WHERE id_class = $itemId";
                break;
            case COURSEITEM:
                $sql = "SELECT CONCAT(name, '. ', description) as itemdesc FROM courses WHERE id_course = $itemId";
                break;
            default:
                redirectHome();
                break;
        }

        $result = $connection->query($sql);
        if($result) {
            $row = $result->fetch_assoc();
            $itemName = $row["itemdesc"];
        }

        mysqli_close($connection);
    }

    function deleteItem() {        
        global $connection;
        global $itemType;
        global $itemId;
        global $itemName;
        global $errorText;
        global $itemTypeError;
        
        switch ($itemType) {
            case TEACHERITEM:
                $sql = "DELETE FROM teachers WHERE id_teacher = $itemId";
                break;
            case CLASSITEM:
                $sql = "DELETE FROM class WHERE id_class = $itemId";
                break;
            case COURSEITEM:
                $sql = "DELETE FROM courses WHERE id_course = $itemId";
                break;
            default:
                redirectHome();
                break;
        }

        try {
            $go=mysqli_query($connection, $sql);
        } catch (\Throwable $th) {
            $errorText = $itemTypeError;
        }

        mysqli_close($connection);
    }

    if(isset($_POST['submit'])) {
        deleteItem();
    } else {
        loadData();
    }
?>
<div class="limiter">
    <div class="container-register">
        <div class="wrap-register">
            <div class="hello-pic">
                <img src="images/hello.png" alt="Hola">
            </div>
            <?php if(!isset($_POST['submit'])) {?>
            <form action="deleteItem.php" method="POST">
                <p><?php echo $itemTypeText;?></p>
                <span class="register-form-title"><p><?php echo $itemName;?></p></span>
                <input name="itemType" value="<?php echo $itemType; ?>" style="display: none;">
                <input name="itemId" value="<?php echo $itemId; ?>" style="display: none;">
                <div class="btn-register">
                    <input type="submit" class="register-form-btn" name="submit" value="Aceptar"></input>
                </div>
                <p><a href="<?php echo $returnUrl?>">Cancelar</a></p>
            </form>
            <?php } else if ($errorText != "") {?>
                <div class="register-success">
                    <p><?php echo $errorText;?></p>
                    <p><a href="<?php echo $returnUrl?>">Volver</a></p>
                </div>
            <?php } else {?>
                <div class="register-success">
                    <p><?php echo $itemTypeSuccess;?></p>
                    <p><a href="<?php echo $returnUrl?>">Volver</a></p>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<?php
    require("footer.php");
?>