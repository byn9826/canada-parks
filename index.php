<?php
//author : BAO

//get db connection
require_once('./lib/DatabaseAccess.php');
$db = DatabaseAccess::getConnection();
//Get header navigation names and links
require_once($team_route_src . 'lib/globe/default.php');
$globe = new Globe($db);
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
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="thumbnail">
								<img src="static/img/park/0/profile.jpg" alt="Banff National Parks">
								<!-- Modified from image Labeled for reuse with modification, https://c1.staticflickr.com/8/7112/7667662212_90b01ac9fe_b.jpg 2017-01-06 -->
								<div class="caption">
							  		<h3>Banff</h3>
							  		<p class="display-content">Banff National Park /ˈbæmf/ is Canada's oldest national park, established in 1885 in the Rocky Mountains.</p>
							  		<p>
								  		<a href="#" class="btn btn-primary" role="button">Explore</a>
								  		<a href="#" class="btn btn-default" role="button">Save</a>
									</p>
								</div>
						  	</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="thumbnail">
								<img src="static/img/park/1/profile.jpg" alt="Jasper National Parks">
								<!-- Modified from image Labeled for reuse with modification, https://c1.staticflickr.com/7/6018/6194015412_8487a871d4_b.jpg 2017-01-06 -->
								<div class="caption">
							  		<h3>Jasper</h3>
							  		<p class="display-content">Jasper National Park in the Canadian Rockies comprises a vast wilderness area of Alberta province defined by glaciers, lakes and peaks like 11,033-ft.-high Mt. Edith Cavell.</p>
							  		<p>
								  		<a href="#" class="btn btn-primary" role="button">Explore</a>
								  		<a href="#" class="btn btn-default" role="button">Save</a>
									</p>
								</div>
						  	</div>
						</div>
						<div class="col-md-4 col-sm-4 visible-lg visible-md visible-sm">
							<div class="thumbnail">
								<img src="static/img/park/2/profile.jpg" alt="Algonquin National Parks">
								<!-- Modified from image Labeled for reuse with modification, https://c1.staticflickr.com/7/6018/6194015412_8487a871d4_b.jpg 2017-01-06 -->
								<div class="caption">
							  		<h3>Algonquin</h3>
							  		<p class="display-content">Algonquin Provincial Park is a provincial park located between Georgian Bay and the Ottawa River in Central Ontario, Canada.</p>
							  		<p>
								  		<a href="#" class="btn btn-primary" role="button">Explore</a>
								  		<a href="#" class="btn btn-default" role="button">Save</a>
									</p>
								</div>
						  	</div>
						</div>
					</div>
				</section>
				<img id="banner" class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 visible-lg visible-md visible-sm" src="static/img/home/banner.jpg" alt="Marvel Activity" />
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
