<?php

include "../../lib/DatabaseAccess.php";
include "../../lib/ParkRepository.php";

$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);

if (isset($_POST["submit"])) {
    if ($_GET["action"] == "add") {
        $result = $parkRepository->addPark($_POST, $_FILES["upload"]);
    } else {
        $result = $parkRepository->updatePark($_POST, $_FILES["upload"]);
    }
    
    if ($result["code"] != 200) {
        $error = $result["msg"];
    } else {
        header("location: /admin/park");
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $action = "/admin/park/form.php?action=edit&id=" . $id;
    $park = $parkRepository->getPark($id);
} else {
    $action = "/admin/park/form.php?action=add";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php
			$team_route_custom = "../../";
			include "../../templates/meta.php";
		?>
		<link rel="stylesheet" href="/static/css/admin.css" type="text/css" />
		<title>Edit Park</title>
    </head>
    <body>
        <div class="container">
            <a class="btn btn-default" href="index.php" role="button">Back to Park List</a>
            <h1 class="text-center"><?=$_GET["action"]?> Park</h1>
            <p class="bg-danger"><?=isset($error) ? $error : ""?></p>
            <div class="row">
                <div class="col-sm-4">
                    <?php if ($_GET["action"] == "add") {?>
                    <label for="">Search the park you want to add, then click the marker to populate data</label>
                    <input class="form-control" type="text" id="place" placeholder="Search park name" /> <button class="btn btn-default" id="search">Search</button>
                    <?php  } ?>
                    <div class="col-xs-12" id="map"></div>
                </div>
                <form id="form" class="col-sm-4" method="POST" action="<?=$action?>" enctype="multipart/form-data">
                    <?php if (isset($id)) {?>
                    <button class="btn btn-success" id="pull">Pull Data From Google Place</button>
                    <input type="hidden" value="<?=$id?>" name="id" />
                    <?php } ?>
                    
                    <div class="form-group">
                        <label for="google_place_id">Google Place ID</label>
                        <input type="text" class="form-control" id="google_place_id" name="google_place_id" value="<?=isset($park["google_place_id"]) ? $park["google_place_id"] : "" ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?=isset($park["name"]) ? $park["name"] : "" ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="upload">Upload banner</label>
                        <input type="file" class="form-control" id="upload" name="upload" />
                        <label for="banner">Use url banner</label>
                        <input type="text" class="form-control" id="banner" name="banner" value="<?=isset($park["banner"]) ? $park["banner"] : "" ?>">
                        <?php if(isset($park["banner"])) { ?>
                        <img src="<?=$park["banner"]?>" id="banner-display" class="img-responsive" />
                        <?php } ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?=isset($park["address"]) ? $park["address"] : "" ?>">
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province" value="<?=isset($park["province"]) ? $park["province"] : "" ?>">
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="province_code">Province code</label>
                            <input type="text" class="form-control" id="province_code" name="province_code" value="<?=isset($park["province_code"]) ? $park["province_code"] : "" ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="<?=isset($park["country"]) ? $park["country"] : "" ?>">
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="country_code">Country code</label>
                            <input type="text" class="form-control" id="country_code" name="country_code" value="<?=isset($park["country_code"]) ? $park["country_code"] : "" ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-4">
                            <label for="postal_code">Postal code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?=isset($park["postal_code"]) ? $park["postal_code"] : "" ?>">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" value="<?=isset($park["latitude"]) ? $park["latitude"] : "" ?>">
                        </div>
                        
                        <div class="form-group col-xs-6">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" value="<?=isset($park["longitude"]) ? $park["longitude"] : "" ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone_number">Phone number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?=isset($park["phone_number"]) ? $park["phone_number"] : "" ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="text" class="form-control" id="website" name="website" value="<?=isset($park["website"]) ? $park["website"] : "" ?>">
                    </div>
                    
                    <button type="submit" name="submit" class="btn btn-default">Submit</button>
                </form>
                <div id="photos" class="col-sm-4"></div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyIDeakYLU04AwAxmUS44hHYQzgJPu6FQ&libraries=places"></script>
    <script type="text/javascript" src="../../static/js/admin/park.js"></script>
</html>