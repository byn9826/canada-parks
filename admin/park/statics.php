<?php

include "../../lib/DatabaseAccess.php";
include "../../lib/ParkRepository.php";
$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);
$parks = $parkRepository->getNumParksWithProvince();

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
			$team_route_custom = "../../";
			include "../../templates/meta.php";
		?>
		<title>Park List Admin</title>
    </head>
    <body>
        <div class="container">
            <h1 class="text-center">Park Admin Page</h1>
            <div class="row">
                <?php include "sidebar.php" ?>
                <div class="col-md-10">
                    <div id="container" style="height: 400px;"></div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var parks = <?=json_encode($parks)?>;
        </script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script type="text/javascript" src="/static/js/admin/park-statics.js"></script>
    </body>
</html>