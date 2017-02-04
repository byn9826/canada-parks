<?php
//Author: Sam
$provinces = array(
    'Alberta' => 'AB',
    'British Columbia' => 'BC',
    'Manitoba' => 'MB',
    'New Brunswick' => 'NB',
    'Newfoundland and Labrador' => 'NL',
    'Northwest Territories' => 'NT',
    'Nova Scotia' => 'NS',
    'Nunavut' => 'NU',
    'Ontario' => 'ON',
    'Prince Edward Island' => 'PE',
    'Quebec' => 'QC',
    'Saskatchewan' => 'SK',
    'Yukon' => 'YT'
);

$parks = array();
$apiKey = 'AIzaSyD1aO6SHBdMTgsBbV_sn5WI8WVGl4DCu-k';
$searchAPi = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query=canada+national+park&key=' . $apiKey;
$detailAPI = 'https://maps.googleapis.com/maps/api/place/details/json';
$result = json_decode(file_get_contents($searchAPi), true);
foreach ($result['results'] as $park) {
    $place_id = $park['place_id'];
    $park = json_decode(file_get_contents($detailAPI . '?placeid=' . $place_id . '&key=' . $apiKey), true);
    $parks[] = $park['result'];
}

// while (!empty($result['next_page_token'])) {
//     var_dump($result['next_page_token']);
//     $result = json_decode((file_get_contents($searchAPi . '&pagetoken=' . $result['next_page_token'] )), true);
//     foreach ($result['results'] as $park) {
//         $parks[] = $park;
//     }
// }
// die;
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
        <link rel="stylesheet" href="/static/css/parks.css">
    </head>
    <body>
        <div class="container-fluid">
            <?php
				$team_logo_custom = "/static/img/logo.png";
				$team_personal_custom = "/static/img/users/profile/0.png";
				include "../templates/header.php";
			?>
			<main id="main">
                <h1 class="text-center">Park List</h1>
                <form id="search" class="form-inline">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Park Name">
                    </div>
                    <div class="form-group">
                        <label for="province">Province</label>
                        <select class="form-control" id="province" name="province">
                            <option value="">Select a Province</option>
                            <?php foreach($provinces as $name => $value) {?>
                            <option value="<?=$value?>"><?=$name?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Search"/>
                    </div>
                </form>
                <div id="compare-wrapper" class="container">
                    <button type="button" disabled="disabled" id="compare" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Compare</button>
                </div>
                <div id="map"></div>
                <div class="row">
                    <?php foreach($parks as $park) {?>
                    <div class="col-xs-6 col-sm-4 col-md-3 park" id="park-<?=$park['id']?>">
                        <div class="caption">
                            <h4 class="name"><?=$park['name']?></h4>
                            <p><?=$park['formatted_address']?></p>
                            <p><a href="#" class="btn btn-primary" role="button">Detail</a> <a  data-id="<?=$park['id']?>" href="#" class="btn btn-default select" role="button">Compare</a></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </main>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2">
                                <h2>Name</h2>
                            </div>
                            <div class="col-md-5" id="compare-1">
                                <h2 class="name">Auyuittuq</h2>
                            </div>
                            <div class="col-md-5" id="compare-2">
                                <h2 class="name">Banff</h2>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
			include "../templates/footer.php";
		?>
		<script type="text/javascript">
		    var parks = <?=json_encode($parks)?>;
		</script>
        <!--<script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>-->
        <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1aO6SHBdMTgsBbV_sn5WI8WVGl4DCu-k&libraries=places"></script>
        <script src="compare.js"></script>
    </body>
</html>