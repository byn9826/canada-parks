<?php
    include "../templates/meta.php";
    if (empty($_SESSION))
    {
        session_start();
    }
?>

<link href="../static/css/admin.css" type="text/css" rel="stylesheet"/>

<?php
if(!empty($_SESSION)){
    if (isset($_SESSION["user_name"]) || $_SESSION["user_name"] != null) { //var_dump($_SESSION["admin_fullname"])
    ?>
        <div class="dropdown admin-header-drop-down-div">
            <a href="#" class="dropdown-toggle admin-header-drop-down" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome back
                <strong><?php echo $_SESSION["user_name"]; ?></strong><span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="admin-edit.php">Edit profile</a></li>
                <li><a href="admin-changepassword.php">Change password</a></li>
                <li role="separator" class="divider"></li>
        <!--        <li class="dropdown-header">Nav header</li>-->
                <li><a href="admin-logout.php?">Sign out</a></li>
            </ul>
        </div>
<?php }} ?>
