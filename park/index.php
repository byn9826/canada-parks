<?php

require '../lib/DatabaseAccess.php';
require '../lib/park.php';
require '../lib/ParkRepository.php';

$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);
$provinces = $parkRepository->getProvinces();
$id = $_GET['id'];
$park1 = $parkRepository->getPark($id);
// var_dump($park1);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "../templates/meta.php";
    ?>
    <meta name="author" content="Navpreet">
  <title>Parks</title>
</head>


<body>


  <main id="main" class="container-fluid">
      <?php
        include "../templates/header.php";
      ?>
      <div class="row" style="margin-top: 100px">
          <div class="col-md-10 col-md-offset-1">
            <aside id="sidebar" class="col-md-4">
                  <article id="blog-posts">
                      <h2 class="links">Quick Links</h2>
                      <ul class="l1">
                          <li><a href="#">Weather</a></li>
                          <li><a href="#">Search Nearby parks</a></li>
                          <li><a href="#">Image Gallery</a></li>
                      </ul>

                  </article>
                <div class="panel panel-default">
                    <div class="panel-body">
                        Weather
                    </div>
                    <div class="panel-footer">
                <?php
                $postalCode = $park1["postal_code"];
                $postalCode = str_replace(' ', '', $postalCode);
                $url = "http://apidev.accuweather.com/locations/v1/search?q=" . $postalCode . "&apikey=hoArfRosT1215";
                //$url = "http://apidev.accuweather.com/locations/v1/search?q=P0E 1E0&apikey=hoArfRosT1215";
                $display = json_decode(file_get_contents($url), true);
                    $key = $display[0]["Key"];

                $url = "http://apidev.accuweather.com/currentconditions/v1/" . $key .".json?language=en&apikey=hoArfRosT1215";
                //$url = "http://apidev.accuweather.com/locations/v1/search?q=P0E 1E0&apikey=hoArfRosT1215";
                $display = json_decode(file_get_contents($url), true);
                    $key = $display[0]["Temperature"];
                    var_dump($key);

                $display = json_decode(file_get_contents($url), true);
                $key = $display[0]["Temperature"];
                var_dump($key);

                ?>
                    </div>
                </div>
<!--                <a href="https://www.accuweather.com/en/us/toronto-on/10007/current-weather/349727" class="aw-widget-legal">-->
<!--                </a><div id="awtd1491400412000" class="aw-widget-36hour"  data-locationkey=""-->
<!--                         data-unit="f" data-language="en-us" data-useip="true" data-uid="awtd1491400412000"-->
<!--                         -editlocation="true"></div><script type="text/javascript" src="https://oap.accuweather.com/launch.js"></script>-->
            </aside>
	    <div class="col-md-8">

	  <h1><?=$park1["name"]?></h1>
	  
	  By:Navpreet<br>

	  <img class="img-responsive" id="pic1" alt="Problem Loading Image" src="<?=$park1["banner"]?>">
	  <p> <?=$park1["description"]?>
	  </p>


            <?php
            include "imagegallery.php";
            ?>
            <?php
            include "../templates/attitude.php";
            ?>


	</div>
      </div>
      <?php include "../templates/footer.php";?>
  </main>

</body>
</html>
