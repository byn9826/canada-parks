<?php

include "../../lib/DatabaseAccess.php";
include "../../lib/ParkRepository.php";
$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);
$parks = $parkRepository->getNumParksWithProvince();
$footprints = $parkRepository->getFootprintStatic();

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
			$team_route_custom = "../../";
			include "../../templates/meta.php";
		?>
		<link rel="stylesheet" href="../../static/css/admin.css" type="text/css" />
		<title>Park List Admin</title>
    </head>
    <body>
        <?php
        include "../navigation.php";
        ?>
        <div class="container">
            <h1 class="text-center">Park Admin Page</h1>
            <div class="row">
                <?php include "sidebar.php" ?>
                <div class="col-md-10">
                    <div id="container" style="height: 400px;"></div>
                    <div id="footprints" style="height: 400px"></div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var parks = <?=json_encode($parks)?>;
            var footprints = <?=json_encode($footprints)?>;
        </script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script type="text/javascript" src="../../static/js/admin/park-statics.js"></script>
    </body>
</html>