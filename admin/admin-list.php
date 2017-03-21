<?php
    require_once "header.php";
    require_once "model/database.php";
    require_once "model/admin.php";
    $admins = AdminUser::getAllUsers($_SESSION["user_id"]);

    //var_dump($_SESSION["role_id"]);
    $search = "";
    if (isset($_POST["searchBtn"])){
        $search = $_POST["searchTerm"];
        $admins = AdminUser::searchUsersByEmailOrUsername($search);
    }
?>

<h1>Administration page</h1>

<div class="container">
    <!--<div id="button-create">
        <a href="admin-create.php" class="btn btn-info" role="button">Create New Admin</a>
    </div>-->

    <form class="form-horizontal" method="post" action="admin-list.php">
    <p>Search for user:
        <input type="text" class="form-control" id="searchTerm" placeholder="Enter username or email here" name="searchTerm" value="<?php echo $search ?>" style="margin:5px;"/>
        <button type="submit" class="btn btn-default" name="searchBtn">
            <span class="glyphicon glyphicon-search"></span> Search
        </button>
    </p>
    </form>
    <h2>Admin List</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Registered Date</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                <?php
                if (isset($admins)){
                    foreach($admins as $admin) {
                        echo "<tr>";
                        echo "<td>$admin->user_id</td>";
                        echo "<td>$admin->user_name</td>";
                        echo "<td>$admin->user_email</td>";
                        echo "<td>$admin->user_reg</td>";
                        echo "<td>". AdminUser::findRoleNameByRoleID($admin->role_id)->role_name ."</td>";
                        echo "<td class='control-td'>";
                        if ($_SESSION["role_id"] == 2)
                        {
                            /*echo "<form method='post' action='admin-edit.php'>
                                        <input type='hidden' name='id' value='$admin->user_id'/>
                                        <input class='btn btn-warning' type='submit' name='edit' value='Edit'/>
                                  </form>";*/
                            echo "<form method='post' action='admin-delete.php'>
                                        <input type='hidden' name='id' value='$admin->user_id'/>
                                        <input class='btn btn-warning' type='submit' name='delete' value='Delete' onClick=\"javascript: return confirm('Do you really want to delete this user?');\"/>
                                  </form>";
                            echo "<form method='post' action='admin-update-role.php'>
                                        <input type='hidden' name='id' value='$admin->user_id'/>
                                        <input class='btn btn-success' type='submit' name='privilege' value='Privilege'/>
                                  </form>";
                        }else {
                            echo "No action";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
        </tbody>
    </table>
</div>

<?php

require_once "footer.php";
?>