<?php
    require_once "header.php";
    require_once "model/database.php";
    require_once "model/admin.php";
    $db = Database::getDB();
    $admins = AdminUser::getAllAdminUser();

?>

<h1>Administration page</h1>

<div class="container">
    <div id="button-create">
        <a href="admin-create.php" class="btn btn-info" role="button">Create New Admin</a>
    </div>

    <h2>Admin List</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                <?php
                if (isset($admins)){
                    foreach($admins as $admin) {
                        echo "<tr>";
                        echo "<td>$admin->user_id</td>";
                        echo "<td>$admin->first_name</td>";
                        echo "<td>$admin->last_name</td>";
                        echo "<td>$admin->gender</td>";
                        echo "<td>$admin->email</td>";
                        echo "<td class='control-td'>";
                        echo "<form method='post' action='admin-edit.php'>
                                    <input type='hidden' name='id' value='$admin->user_id'/>
                                    <input class='btn btn-warning' type='submit' name='edit' value='Edit'/>
                              </form>";
                        echo "<form method='post' action='admin-delete.php'>
                                    <input type='hidden' name='id' value='$admin->user_id'/>
                                    <input class='btn btn-danger' type='submit' name='delete' value='Delete' onClick=\"javascript: return confirm('Do you really want to delete this user?');\"/>
                              </form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
        </tbody>
    </table>
</div>