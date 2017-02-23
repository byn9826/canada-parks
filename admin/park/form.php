<?php

include "../../lib/ParkRepository.php";

$parkRepository = new ParkRepository();

if (isset($_POST["submit"])) {
    if ($_GET["action"] == "add") {
        $parkRepository->addPark($_POST, $_FILES["upload"]);
    } else {
        $parkRepository->updatePark($_POST, $_FILES["upload"]);
    }
    //header("location: /admin/park");
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
		<title>Edit Park</title>
    </head>
    <body>
        <div class="container">
            <a class="btn btn-default" href="/admin/park" role="button">Back to Park List</a>
            <h1 class="text-center"><?=$_GET["action"]?> Park</h1>
            <form method="POST" action="<?=$action?>" enctype="multipart/form-data">
                <?php if (isset($id)) {?>
                <input type="hidden" value="<?=$id?>" name="id" />
                <?php } ?>
                <div class="form-group">
                    <label for="name">Park Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?=isset($park["name"]) ? $park["name"] : "" ?>">
                </div>
                
                <div class="form-group">
                    <label for="banner">Park Banner</label>
                    <input type="file" class="form-control" id="upload" name="upload" />
                    <input type="hidden" class="form-control" id="banner" name="banner" value="<?=isset($park["banner"]) ? $park["banner"] : "" ?>">
                    <?php if(isset($park["banner"])) { ?>
                    <img src="<?=$park["banner"]?>" class="img-responsive" />
                    <?php } ?>
                </div>
                
                <div class="form-group">
                    <label for="address">Park address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?=isset($park["address"]) ? $park["address"] : "" ?>">
                </div>
                
                <div class="form-group">
                    <label for="province">Park province</label>
                    <input type="text" class="form-control" id="province" name="province" value="<?=isset($park["province"]) ? $park["province"] : "" ?>">
                </div>
                
                <div class="row">
                    <div class="form-group col-xs-6">
                        <label for="latitude">Park latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" value="<?=isset($park["latitude"]) ? $park["latitude"] : "" ?>">
                    </div>
                    
                    <div class="form-group col-xs-6">
                        <label for="longitude">Park longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" value="<?=isset($park["longitude"]) ? $park["longitude"] : "" ?>">
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label for="phone_number">Park phone_number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?=isset($park["phone_number"]) ? $park["phone_number"] : "" ?>">
                </div>
                
                <button type="submit" name="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </body>
</html>