<?php 
    
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="description" content="Admin page for have CRUD actions on Users and Parks"/>
        <meta name="author" content="Duc Nguyen"/>
        <title>Admin page</title>
        <?php
            include_once "header.php";
        ?>
    </head>
    <body>
        <h1>Select your choice</h1>
        <div id="adminSelect" class="container">
            <div class="row">
                <div class="col-sm-6">
                    <a href="user.php">User</a>
                </div>
                <div class="col-sm-6">
                    <a href="park.php">Park</a>
                </div>
            </div>
        </div>
    </body>
</html>
