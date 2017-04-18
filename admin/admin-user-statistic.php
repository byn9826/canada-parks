<?php
/**
 * Created by PhpStorm.
 * User: Lenoir
 * Date: 4/7/2017
 * Time: 4:03 PM
 */
require_once "header.php";
require_once "model/database.php";
require_once "model/admin.php";

$db = Database::getDB();
$users = AdminUser::getUserRoleAndQuantity($db);
$users = json_encode($users);
//var_dump($users);

$month = AdminUser::getNumberOfRegisteredEachMonth($db);
$month = json_encode($month);

$male = AdminUser::getNumberOfRegisteredEachMonthByMale($db);
$male = json_encode($male);
//var_dump($male);
$female = AdminUser::getNumberOfRegisteredEachMonthByFeMale($db);
$female = json_encode($female);

$otherSex = AdminUser::getNumberOfRegisteredEachMonthByNotMaleOrFemale($db);
$otherSex = json_encode($otherSex);
?>

<h1>User Statistic</h1>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><i style="font-size:24px" class="fa">&#xf080;</i> <b>Statistics:</b></div>
        <div class="panel-body">
            <p>
                Here are some statistics about Users in our website. Hope it can bring some useful information to whom it may concern.
            </p>
        </div>
    </div>
</div>
<div id="role-and-quantity" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
<div id="monthly-reg" style="height: 400px"></div>
<div id="man-and-woman" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script>
    var userAndQuantity = <?php echo $users; ?>;
    var month = <?php echo $month; ?>;
    var male = <?php echo $male; ?>;
    var female = <?php echo $female; ?>;
    var otherSex = <?php echo $otherSex; ?>;
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="../static/js/admin/user-statistic.js"></script>
