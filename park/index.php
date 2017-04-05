<?php

require '../lib/DatabaseAccess.php';
require '../lib/park.php';
require '../lib/ParkRepository.php';

$db = DatabaseAccess::getConnection();
$parkRepository = new ParkRepository($db);
$provinces = $parkRepository->getProvinces();
$id = $_GET['id'];
$park1 = $parkRepository->getPark($id);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include "../templates/meta.php"; ?>
        <meta name="author" content="Navpreet">
        <title>Park Page | Marvel Canada</title>
        <link rel="stylesheet" href="../lib/profile/owl.carousel.min.css">
        <link rel="stylesheet" href="../lib/profile/owl.theme.default.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="../static/css/footprints.css" />
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
        <script src="../lib/profile/owl.carousel.js"></script>
    </head>
    <body>
        <!-- Include Page header -->
        <?php include_once "../templates/header.php"; ?>

        <main id="main" class="container-fluid">
            <!-- Page Content -->
            <div class="row" style="margin-top: 100px">
                <div class="col-md-10 col-md-offset-1">
                    <aside id="sidebar" class="col-md-3">
                        <article id="blog-posts">
                            <h2 class="links">Quick Links</h2>
                            <ul class="l1">
                                <li><a href="#">Weather</a></li>
                                <li><a href="#">Search Nearby parks</a></li>
                                <li><a href="#">Image Gallery</a></li>
                            </ul>
                        </article>
                    </aside>

                    <div class="col-md-9">
                        <h1><?=$park1["name"]?></h1>
                        <img class="img-responsive" id="pic1" alt="Problem Loading Image" src="<?=$park1["banner"]?>">
                        <p> <?=$park1["description"]?> </p>

                        <?php include "imagegallery.php"; ?>

                        <?php include "../templates/attitude.php"; ?>

                        <form action="parks.html" method="post">
                            <h2>Comments</h2>
                            <div>
                                <label for="comments" class="form-label">Comments:</label>
                                <input type="text" id="comments" name="visitor_comments" placeholder="Type your comments here."/>
                            </div>
                            <div>
                                <button type="submit" name="Submit">Post Comment</button>
                            </div>
                        </form>

                        <!-- Allow visitors to load footprints from users for the current park -->
                        <div class="row park-footprints">
                            <div class="park-footprints__container"></div>
                            <div class="park-footprints__load-btn">
                                <button type="button" class="btn btn-primary btn-lg btn-block btn-load-footprints"
                                        title="Click to load footprints members posted about this park"
                                        data-park-id="<?php echo $id; ?>">View Footprints</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Footer -->
            <?php include_once "../templates/footer.php";?>
        </main>

        <!-- JavaScript File -->
        <script type="application/javascript" src="../static/js/parkDescription.js"></script>
    </body>
</html>
