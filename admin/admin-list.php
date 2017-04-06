<?php
    require_once "header.php";
    require_once "model/database.php";
    require_once "model/admin.php";
    $db = Database::getDB();
    $numberOfAdmins = count(AdminUser::getAllUsers($db, $_SESSION["user_id"]));
    $admins = AdminUser::getAllUsersWithPagination($db, $_SESSION["user_id"]);
    //var_dump($numberOfAdmins);
    //var_dump($_SESSION["role_id"]);
//    $search = "";
//    if (isset($_POST["searchBtn"])){
//        $search = $_POST["searchTerm"];
//        $admins = AdminUser::searchUsersByEmailOrUsername($search);
//    }
?>

<script>
    $(document).ready(function (){
        $("#btnSearch").click(function(){
            var search = $("#searchTerm").val();
            var offset = "";
            var totalNumber = $("#totalNumber").val();
            var currentPage = "";
            $.post('admin-searchuser.php', { searchTerm: search , offset : offset, totalNumber : totalNumber, currentPage : currentPage, bSearch : true}, function(data){
                //console.log(data);
                $("#result").html(data);
            });
        });

        $("#searchTerm").keyup(function (event) {
            if (event.keyCode == 13) {
                $("#btnSearch").trigger("click");
            }
        });

        //$(".pagination a:contains('Previous')").parent().addClass('disabled');
        $(".pagination a:contains('1')").parent().addClass('active');

        $(".pagination a").click(function(){
            //alert($(this)[0].innerText);
            var search = $("#searchTerm").val();
            var offset = ($(this)[0].innerText === 0) ? 0 : (($(this)[0].innerText-1) * 10);
            var totalNumber = $("#totalNumber").val();
            var currentPage = $(".pagination li[class*='active'] a")[0].innerText;
            $.post('admin-searchuser.php', { searchTerm: search , offset : offset, totalNumber: totalNumber, currentPage : currentPage, bSearch : false}, function(data){
                //console.log(data);
                $("#result").html(data);
            });
        });
    });
</script>

<h1>Administration page</h1>

<div class="container">
    <!--<div id="button-create">
        <a href="admin-create.php" class="btn btn-info" role="button">Create New Admin</a>
    </div>-->

<!--    <form class="form-horizontal" method="post" action="admin-list.php">-->
    <p>Search for user:
        <input type="text" class="form-control" id="searchTerm" placeholder="Enter username or email here" name="searchTerm" value="" style="margin:5px;"/>
        <input type="hidden" id="totalNumber" name="totalNumber" value="<?php echo $numberOfAdmins; ?>"/>
        <button type="submit" class="btn btn-default" name="searchBtn" id="btnSearch">
            <span class="glyphicon glyphicon-search"></span> Search
        </button>
    </p>
<!--    </form>-->
    <h2>Admin List</h2>
    <div id="result">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item ">
                    <a class="page-link">Previous</a>
                </li>
                <?php
                    $num = ceil($numberOfAdmins/10);
                    for ($x = 1; $x <= $num; $x++) {
                        echo "<li class='page-item '>";
                        echo "<a class='page-link'>$x</a>";
                        echo "</li>";
                    }
                ?>
                <li class="page-item">
                    <a class="page-link">Next</a>
                </li>
            </ul>
        </nav>
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
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <?php
                $num = ceil($numberOfAdmins/10);
                for ($x = 1; $x <= $num; $x++) {
                    echo "<li class='page-item '>";
                    echo "<a class='page-link'>$x</a>";
                    echo "</li>";
                }
                ?>
                <li class="page-item">
                    <a class="page-link">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php

require_once "footer.php";
?>