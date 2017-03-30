<?php
#author: Bao
#get park id
$parkId = intval($_GET['id']);
#get db connection
require_once('../lib/DatabaseAccess.php');
$db = DatabaseAccess::getConnection();
#Init attitude calss
require_once('../lib/attitude.php');
$Attitude = new Attitude($db);
$allAttitude = $Attitude->getAttitude($parkId);
#count total rate
$totalRate = 0;
#count number of rate_num
$numberRate = 0;
#count number of worth visitor
$numberWorth = 0;
#count number of come back
$numberBack = 0;
foreach ($allAttitude as $r) {
    if (isset($r['attitude_rate'])) {
        $totalRate += $r['attitude_rate'];
        $numberRate += 1;
    }
    if ($r['attitude_worth'] == 1) {
        $numberWorth += 1;
    }
    if ($r['attitude_back'] == 1) {
        $numberBack += 1;
    }
}
if ($numberRate !== 0) {
    #get avarage rate, 1 decimal
    $averageRate = round($totalRate / $numberRate, 1);
    #get rate set for stars
    $starRate = floor($totalRate / $numberRate);
} else {
    $averageRate = 0;
    $starRate = 0;
}
#get blank stars for rate
$emptyRate = 5 - $starRate;
?>

<!-- #The rating star css and js is come from https://github.com/irfan/jquery-star-rating -->
<link rel="stylesheet" type="text/css" href="../static/vendor/rating/rating.css" />
<script>
$(function(){                   // Start when document ready
    $('#rating-stars').rating(); // Call the rating plugin
});
</script>

<section id="attitude" class="col-md-12">
    <div id="attitude-rate">
        <?php
        echo '<h5>Rate ' . $averageRate . ' from<br />' . $numberRate . ' Travelers</h5>';
        #show full stars according to average rate
        for($i = 1; $i <= $starRate; $i++) {
            echo '<a class="star fullStar" title="' . $i . '"></a>';
        }
        #show empty stars according to average rate
        for ($j = 1; $j <= $emptyRate; $j++) {
            echo '<a class="star" title="' . $i . '"></a>';
        }
        ?>
    </div>
    <div class="attitude-vote">
        <h5>
            ✓ Worthing Visit<br />
            by <?php echo $numberWorth; ?> Visitor
        </h5>
    </div>
    <div class="attitude-vote">
        <h5>
            ✓ Will Come Back<br />
            by <?php echo $numberBack; ?> Visitor
        </h5>
    </div>
</section>
<script type="text/javascript" src="../static/vendor/rating/rating.js"></script>
