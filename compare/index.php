<?php
//Author: Sam
require '../lib/IPLocation.php';
require '../lib/DatabaseAccess.php';
require '../lib/park.php';
require '../lib/ParkRepository.php';

$db = DatabaseAccess::getConnection();
$p = new Park();
$parkRepository = new ParkRepository($db);
$provinces = $parkRepository->getProvinces();
$parkId1 = $_GET['park1'];
$parkId2 = $_GET['park2'];
$park1 = $parkRepository->getPark($parkId1);
$park2 = $parkRepository->getPark($parkId2);
$parks = array($park1, $park2);
$currentLocation = IPLocation::getLocation();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			$team_cssglobal_custom = "/static/css/globe.css";
			$team_icon_custom = "/static/img/logo.png";
			$team_bootstrap_custom = "/static/vendor/bootstrap/css/bootstrap.min.css";
			$team_bootjs_custom= "/static/vendor/bootstrap/js/bootstrap.min.js";
			$team_jquery_custom = "/static/vendor/jquery-3.1.1.min.js";
			include "../templates/meta.php";
		?>
		<meta name="author" content="Sam">
        <title>Park List</title>
        <link rel="stylesheet" href="../static/css/parks.css">
    </head>
    <body>
        <div class="container-fluid">
            <?php
				$team_logo_custom = "/static/img/logo.png";
				$team_personal_custom = "/static/img/users/profile/0.png";
				include "../templates/header.php";
			?>
			<main id="main" class="container">
                <h1 class="text-center">Compare Parks</h1>
                <?php include '../templates/parkSearchForm.php';?>
                <div id="park-compare">
                    <div class="active" id="map">
                        <?php include '../templates/parkMap.php' ?>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 text-center compare-parks-div">
                            <h2 class="name"><a href="/park?id=<?=$park1["id"]?>"><?=$park1['name']?></a></h2>
                            <figure>
                                <img class="img-responsive" src="<?=$park1["banner"]?>" alt="<?=$park1["name"]?>" />
                            </figure>
                        </div>
                        <div class="col-xs-6 text-center compare-parks-div">
                            <h2 class="name"><a href="/park?id=<?=$park2["id"]?>"><?=$park2['name']?></a></h2>
                            <figure>
                                <img class="img-responsive" src="<?=$park2["banner"]?>" alt="<?=$park2["name"]?>" />
                            </figure>
                        </div>
                    </div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Address</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <?=$park1["address"]?>
                                </div>
                                <div class="col-xs-6">
                                    <?=$park2["address"]?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Rating by Users</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <?=$park1["rating"]?>
                                </div>
                                <div class="col-xs-6">
                                    <?=$park2["rating"]?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Footprints by Users</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <h3 class="col-xs-12"></h3>
                                <div class="col-xs-6">
                                    <?=$park1["footprints"]?>
                                </div>
                                <div class="col-xs-6">
                                    <?=$park2["footprints"]?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title">Website</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <a href="<?=$park1["website"]?>" class="btn btn-success" target="_blank">Go to website</a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="<?=$park2["website"]?>" class="btn btn-success" target="_blank">Go to website</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
			<?php
				include "../templates/footer.php";
			?>
        </div>

		<script type="text/javascript">
		    var parks = <?=json_encode($parks)?>;
		    var currentLocation = <?=json_encode($currentLocation)?>
		</script>

        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1aO6SHBdMTgsBbV_sn5WI8WVGl4DCu-k&libraries=places"></script>
        <script type="text/javascript" src="../static/js/map.js"></script>
        <script type="text/javascript" src="../static/js/compare.js"></script>
    </body>
</html>
