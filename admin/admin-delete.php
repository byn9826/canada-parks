<?php
    require_once "header.php";
    require_once "model/database.php";
    require_once "model/admin.php";

    if (isset($_POST['delete'])){
        $id = $_POST['id'];
        $row = AdminUser::deleteAdminByID($id);
        if ($row == 1) {
            header("Location: admin-list.php");
        }
    }
?>

<h1>Something went wrong. Cannot delete the record!</h1>

<?php
require_once "footer.php";
?>