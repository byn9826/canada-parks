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
$searchTerm = $_POST["searchTerm"];
$offset = $_POST["offset"];
$totalNumber = $_POST["totalNumber"];
$currentPage = $_POST["currentPage"];
$bSearch = $_POST["bSearch"];
//var_dump($bSearch);
//$admins = AdminUser::searchUsersByEmailOrUsername($db, $searchTerm);
//var_dump($searchTerm);
//var_dump(intval($offset));
//var_dump($currentPage);


$admins = AdminUser::searchUsersWithTermAndPagination($db, $_SESSION["user_id"], $searchTerm, $offset);
if ($searchTerm != "")
{
    $totalNumber = count(AdminUser::searchUsersByEmailOrUsername($db, $_SESSION["user_id"], $searchTerm));
    //var_dump($totalNumber);
}

?>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item ">
            <a class="page-link">Previous</a>
        </li>
        <?php
        $num = ceil($totalNumber/10);
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
                                        <input class='btn btn-warning deleteUser' type='button' name='delete' value='Delete'/>
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
<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item ">
            <a class="page-link">Previous</a>
        </li>
        <?php
        $num = ceil($totalNumber/10);
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

<script>
    $(document).ready(function (){
        $('.deleteUser').click(function(){
            var theForm = $(this).parent();
            bootbox.confirm({
                size: "small",
                message: "Are you sure to delete the user?",
                callback: function(result){
                    if (result){
                        theForm.submit();
                    }
                }
            });
        });

        $("#totalNumber").val(<?php echo $totalNumber; ?>);
        //$(".pagination a:contains('Previous')").parent().addClass('disabled');
        $(".pagination a:contains('<?php echo (intval($offset)/10 + 1); ?>')").parent().addClass('active');

        $(".pagination a").click(function(){
            var search = $("#searchTerm").val();
            var offset = ($(this)[0].innerText === 0 || !$.isNumeric($(this)[0].innerText)) ? 0 : (($(this)[0].innerText-1) * 10);
            var totalNumber = $("#totalNumber").val();
            //var currentPage = $(".pagination li a")[0].innerText;
            var currentPage = $(".pagination li[class*='active'] a")[0].innerText;
            console.log("Text : " + $(this)[0].innerText);
            if ($(this)[0].innerText === 'Next'){
                if (totalNumber - ((currentPage-1)*10) > 10) // check if it's not the last page
                    offset = currentPage * 10;
                else
                    return false;
            }
            if ($(this)[0].innerText === 'Previous'){
                if (currentPage != 1) // check if it's not the first page
                    offset = (currentPage -2) * 10;
                else
                    return false;
            }
            $(".loader").show();
            $("#result").hide();
            console.log("totalNumber : " + totalNumber);
            console.log("offset : " + offset);
            console.log("currentPage : " + currentPage);
            $.post('admin-searchuser.php', { searchTerm: search , offset : offset, totalNumber: totalNumber, currentPage : currentPage, bSearch : false}, function(data){
                //console.log(data);
                $("#result").html(data);
                $(".loader").hide();
                $("#result").show();
            });
        });
    });
</script>