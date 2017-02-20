<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$team_route_custom = "./";
			include "templates/meta.php";
		?>
		<meta name="author" content="Baozier">
		<title>Marvel Canada</title>
        <link href="static/css/home.css" rel="stylesheet" type="text/css">
	</head>
	<body>
        <div class="container-fluid">
			<?php
				include "templates/header.php";
			?>
            <main id="main" class="row">
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
					<div class="col-md-12 col-sm-12 col-xs-12" style="height:300px">
						<!--will import from compare page -->
						<h5 class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
							<b>Test mysql connection:</b> <br />
							<?php
							/*
								require_once('./lib/ini.php');
								require_once('./lib/test.php');
								$db = Connect::dbConnect();
								$myTest = new Test($db);
								$contents = $myTest->listComment();
								echo "<select>";
							        foreach ($contents as $c) {
							            echo "<option>" . $c["comment_content"] . "</option>";
							        }
							    echo "</select>";

								if(isset($_GET['id'])) {
									$comment = $myTest->getComment($_GET['id']);
									echo "<h3>" . $comment->comment_content . "</h3>";
								}
								/*
								try {
										var_dump($dino);
										echo "<h2>Dino Detail</h2>";
									}
									if(isset($_POST['add'])) {
										$content = $_POST['content'];
										$id = $_POST['id'];

										$query3 = "INSERT INTO del
													(comment_id, comment_content)
													VALUES (:id, :content)";
										$pdostmt3 = $db->prepare($query3);
										$pdostmt3->bindValue(':id', $id, PDO::PARAM_INT);
										$pdostmt3->bindValue(':content', $content, PDO::PARAM_STR);
										$row = $pdostmt3->execute();
										echo "Add " . $row;
									}
								*/
							?>
						</h5>
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
		<script type="text/javascript" src="static/js/home.js"></script>
	</body>
</html>
