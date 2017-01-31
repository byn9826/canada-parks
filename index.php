<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="The best place for you to explore Canada Parks">
		<meta name="keywords" content="Canada, National-Parks, Banff, Travel, Tourism">
		<meta name="robots" content="all">
		<meta name="author" content="Baozier">
		<title>Marvel Canada</title>
		<link rel="shortcut icon" href="static/img/logo.png" type="image/x-icon" />
		<!-- Modified from image Labeled for reuse with modification, https://c2.staticflickr.com/4/3327/3573458354_72c230294f_b.jpg 2017-01-06 -->
        <link href="static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="static/css/globe.css" rel="stylesheet" type="text/css">
        <link href="static/css/home.css" rel="stylesheet" type="text/css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
	</head>
	<body>
        <div class="container-fluid">
            <?php
				$team_logo_custom = "./static/img/logo.png";
				$team_personal_custom = "./static/img/users/profile/0.png";
                include "templates/header.php"
            ?>
            <main class="row">
                <img id="banner-img" alt="go to parks on map page" src="static/img/home/marvel.jpg" />
				<!--Granted copyright by Paul-->
				<h3 id="banner-list">
					Explore Marvel <br />
					for your next trip
				</h3>
				<section class="section col-md-12 col-sm-12 col-xs-12">
					<h3 class="col-md-12 col-sm-12 col-xs-12">
						Make the best decision
						<span class="section-icon glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
					</h3>
					<div style="height:300px">
						<!--will import from compare page -->
					</div>
				</section>
				<section class="section col-md-12 col-sm-12 col-xs-12">
					<h3 class="col-md-12 col-sm-12 col-xs-12">
						Parks You might like
						<span class="section-icon glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
					</h3>
					<div id="display" class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
						<div class="col-md-4 col-sm-4 col-xs-6">
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
						<div class="col-md-4 col-sm-4 col-xs-6">
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
						<div class="col-md-4 col-sm-4 col-xs-6">
							<div class="thumbnail">
								<img src="static/img/park/2/profile.jpg" alt="Algonquin National Parks">
								<!-- Modified from image Labeled for reuse with modification, https://c1.staticflickr.com/7/6018/6194015412_8487a871d4_b.jpg 2017-01-06 -->
								<div class="caption">
							  		<h3>Algonquin</h3>
							  		<p class="display-content">Algonquin Provincial Park is a provincial park located between Georgian Bay and the Ottawa River in Central Ontario, Canada, mostly within the Unorganized South Part of Nipissing District.</p>
							  		<p>
								  		<a href="#" class="btn btn-primary" role="button">Explore</a>
								  		<a href="#" class="btn btn-default" role="button">Save</a>
									</p>
								</div>
						  	</div>
						</div>
					</div>
				</section>
				<img id="banner" class="col-md-10 col-md-offset-1 col-sm-10 col-xs-10" src="static/img/home/banner.jpg" alt="Marvel Activity" />
				<!-- Modified from image Labeled for reuse with modification, https://upload.wikimedia.org/wikipedia/commons/e/e1/Georgian_Bay,_Ontario,_Canada.jpg 2017-01-06 -->
				<section class="section col-md-12 col-sm-12 col-xs-12">
					<h3 class="col-md-12 col-sm-12 col-xs-12">
						Marvels around Canada
						<span class="section-icon glyphicon glyphicon-triangle-right" aria-hidden="true"></span>
					</h3>
					<?php
						include "templates/userComment.php"
					?>
				</section>
            </main>
			<?php
				include "templates/footer.php"
			?>
        </div>
        <script type="text/javascript" src="static/vendor/jquery-3.1.1.min.js"></script>
		<script type="text/javascript" src="static/js/home.js"></script>
	</body>
</html>
