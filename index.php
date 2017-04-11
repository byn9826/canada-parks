<?php
//author : BAO

//get db connection
require_once('./lib/DatabaseAccess.php');
$db = DatabaseAccess::getConnection();
require_once('./lib/globe/default.php');
$globe = new Globe($db);
//get highest three parks
$recommend_parks = $globe->getRecommend();
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$team_route_custom = "./";
			include_once "templates/meta.php";
		?>
		<meta name="author" content="Bao">
		<title>Marvel Canada</title>
        <link href="static/css/home.css" rel="stylesheet" type="text/css">
		<!-- rate plugin from http://rateyo.fundoocode.ninja/ -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.css">
		<!-- rate plugin from http://rateyo.fundoocode.ninja/ -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.2.0/jquery.rateyo.min.js"></script>
	</head>
	<body>
        <div class="container-fluid">
			<?php
				include "templates/header.php";
			?>
            <main id="main" class="row">
				<img id="banner-img" class="visible-lg visible-md visible-sm" alt="go to parks on map page" src="static/img/home/marvel.jpg" />
				<!--Granted copyright by Paul-->
				<h3 id="banner-list" class="visible-lg visible-md visible-sm">
					<a href="./parks">
						Explore Marvel <br />
						for your next trip
					</a>
				</h3>
				<section class="section col-md-12 col-sm-12 col-xs-12">
					<h3 class="col-md-12 col-sm-12 col-xs-12">
						Parks You might like
						<span class="section-icon glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
					</h3>
					<div id="display" class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1">
						<?php foreach ($recommend_parks as $i=>$r) { ?>
							<div class="col-md-4 col-sm-4 col-xs-12">
								<div class="thumbnail">
									<a href="<?php echo './park/?id=' . $r['id']; ?>">
										<img class="thumbnail-image" src="<?php echo $r['banner']; ?>" alt="Banff National Parks">
									</a>
									<!-- Modified from image Labeled for reuse with modification, https://c1.staticflickr.com/8/7112/7667662212_90b01ac9fe_b.jpg 2017-01-06 -->
									<div class="caption">
								  		<h5><?php echo $r['name']; ?></h5>
									</div>
									<div id="<?php echo $i; ?>" class="thumbnail-rate"></div>
									<script>
										$(function () {
											$("<?php echo '#' . $i; ?>").rateYo({
												rating: <?php echo $r['total']; ?>,
												starWidth: "20px",
												readOnly: true
											});
										});
									</script>
							  	</div>
							</div>
						<?php } ?>
					</div>
				</section>
				<a href="./park/?id=105">
					<img id="banner" class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 visible-lg visible-md visible-sm" src="static/img/home/banner.jpg" alt="Marvel Activity" />
				</a>
				<!-- Modified from image Labeled for reuse with modification, https://upload.wikimedia.org/wikipedia/commons/e/e1/Georgian_Bay,_Ontario,_Canada.jpg 2017-01-06 -->
				<section class="section col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
					<h3 class="col-md-12 col-sm-12 col-xs-12">
						Marvels around Canada
						<span class="section-icon glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
					</h3>
				</section>
            </main>
			<?php
				include "templates/footer.php";
			?>
        </div>
	</body>
</html>
