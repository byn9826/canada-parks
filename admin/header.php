<?php
    include "../templates/meta.php";
    if (empty($_SESSION))
    {
        session_start();
    }

?>

<link href="../static/css/admin.css" type="text/css" rel="stylesheet"/>




<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
            </button>

            <?php
            if(!empty($_SESSION)){
                //var_dump(isset($_SESSION["user_name"]));
                if (isset($_SESSION["user_name"])) { //var_dump($_SESSION["admin_fullname"])
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

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li>
                    <a class="page-scroll" href="../">Public Page</a>
                </li>
                <li>
                    <a class="page-scroll" href="index.php">Admin Home Page</a>
                </li>
                <li>
                    <a class="page-scroll" href="#team">Team</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

