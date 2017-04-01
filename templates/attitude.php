<link rel="stylesheet" type="text/css" href="../static/css/attitude.css" />
<div id="root"></div>
<script type="text/javascript" src="../static/source/attitude.bundle.js"></script>




<?php

/*
#author: Bao
#get park id
$parkId = intval($_GET['id']);
#get db connection
require_once('../lib/DatabaseAccess.php');
$db = DatabaseAccess::getConnection();
#Init attitude calss
require_once('../lib/attitude/attitude.php');
$Attitude = new Attitude($db);
$allAttitude = $Attitude->getAttitude($parkId);
#count total rate
$totalRate = 0;
#count number of rate_num
$numberRate = 0;
#count number of worth visitor
$numberWorth = 0;
#count number of total vote 1 for worth
$yesWorth = 0;
#count number of come back
$numberBack = 0;
#count number of total vote 1 for back
$yesBack = 0;
foreach ($allAttitude as $r) {
    if (isset($r['attitude_rate'])) {
        $totalRate += $r['attitude_rate'];
        $numberRate += 1;
    }
    if ($r['attitude_worth'] == 1 || $r['attitude_worth'] === 0) {
        $numberWorth += 1;
    }
    if ($r['attitude_worth'] == 1) {
        $yesWorth += 1;
    }
    if ($r['attitude_back'] == 1 || $r['attitude_back'] === 0) {
        $numberBack += 1;
    }
    if ($r['attitude_back'] == 1) {
        $yesBack += 1;
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
#check if user has logged in
if (isset($_SESSION['user_id'])){
    $yourAttitude = $Attitude->yourAttitude($parkId, $_SESSION['user_id']);
}

var_dump($yourAttitude);
?>

<link rel="stylesheet" type="text/css" href="../static/css/attitude.css" />
<!-- #The rating star css and js is come from https://github.com/irfan/jquery-star-rating -->
<link rel="stylesheet" type="text/css" href="../static/vendor/rating/rating.css" />
<script>
$(function(){                   // Start when document ready
    $('.star-rating').rating(); // Call the rating plugin
});
</script>

<section id="attitude" class="col-md-12 attitude">
    <div class="attitude-rate">
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
            by <?php echo $yesWorth . '/' . $numberWorth; ?> Visitor
        </h5>
    </div>
    <div class="attitude-vote">
        <h5>
            ✓ Will Come Back<br />
            by <?php echo $yesBack . '/' . $numberBack; ?> Visitor
        </h5>
    </div>
</section>

<?php if (isset($_SESSION['user_id'])) { ?>
    <section id="tell" class="col-md-12 attitude">
        <div class="attitude-rate">
            <h5>Your Rate</h5>
            <?php if (isset($yourAttitude->attitude_rate)) { ?>
                <div class="star-rating">
                    <input type="radio" name="example" class="rating" value="1" <?php if($yourAttitude->attitude_rate == 1) echo 'checked'; ?> />
                    <input type="radio" name="example" class="rating" value="2" <?php if($yourAttitude->attitude_rate == 2) echo 'checked'; ?> />
                    <input type="radio" name="example" class="rating" value="3" <?php if($yourAttitude->attitude_rate == 3) echo 'checked'; ?> />
                    <input type="radio" name="example" class="rating" value="4" <?php if($yourAttitude->attitude_rate == 4) echo 'checked'; ?> />
                    <input type="radio" name="example" class="rating" value="5" <?php if($yourAttitude->attitude_rate == 5) echo 'checked'; ?> />
                </div>
            <?php } else { ?>
                <div class="star-rating">
                    <input type="radio" name="example" class="rating" value="1" />
                    <input type="radio" name="example" class="rating" value="2" />
                    <input type="radio" name="example" class="rating" value="3" />
                    <input type="radio" name="example" class="rating" value="4" />
                    <input type="radio" name="example" class="rating" value="5" />
                </div>
            <?php } ?>
        </div>
        <div class="attitude-title">
            <h5>
                Is it worth visiting?
            </h5>
            <button class="vote">Yes</button>
            <button class="vote">No</button>
        </div>
        <div class="attitude-title">
            <h5>
                Will you come back?
            </h5>
            <button class="vote">Yes</button>
            <button class="vote">No</button>
        </div>
    </section>
<?php } ?>

<script type="text/javascript" src="../static/vendor/rating/rating.js"></script>
<script type="text/javascript" src="../static/js/attitude.js"></script>
*/
