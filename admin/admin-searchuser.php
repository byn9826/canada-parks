<?php
/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 3/29/2017
 * Time: 1:20 PM
 */
require_once "header.php";
require_once "model/database.php";
require_once "model/admin.php";
$db = Database::getDB();
$search = $_POST["searchTerm"];
$admins = AdminUser::searchUsersByEmailOrUsername($db, $search);
?>

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
            echo "<td>". AdminUser::findRoleNameByRoleID($db, $admin->role_id)->role_name ."</td>";
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