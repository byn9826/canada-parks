<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            require_once ("../lib/DatabaseAccess.php");
            require_once '../lib/park.php';
            require_once '../lib/ParkRepository.php';

            // TODO: Remove after test
            require_once ("../lib/myLocalhostDB.php");
            $profilePicURL = myLocalhostDB::getProfilePicture(666);

            $parkRepository = new ParkRepository();
            $lstParks = $parkRepository->getParks(null);

            // Test SQL connection
        //            $objConnection = DatabaseAccess::getConnection();
        //            $query = 'SELECT * FROM wishlist';
        //            $statement = $objConnection->prepare($query);
        //            $statement->execute();
        //            $lstWishlist = $statement->fetchAll(PDO::FETCH_ASSOC);
        //            var_dump($lstWishlist);
        //            foreach ($lstWishlist as $row) {
        //                echo $row['wish_id'] . " | " . $row['user_id'] . " | " .
        //                     $row['park_id'] . " | " . date('F d, Y', strtotime($row['added_on'])) . "<br />";
        //            }

			include_once "../templates/meta.php";
		?>
		<meta name="author" content="Irfaan">
		<title>Profile Page | Marvel Canada</title>
        <link rel="stylesheet" type="text/css" href="../static/css/profile.css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container-fluid">
            <!-- Page Header -->
            <?php include_once "../templates/header.php" ?>

            <!-- Page Body -->
            <main class="container-fluid">
                <div class="row">

                    <!-- Left column -->
                    <div class="col-sm-3">
                        <div class="user-details">

                            <!-- Profile Avatar Picture -->
                            <div class="avatar">
                                <a href="settings.php" title="Go to profile settings">
                                    <img id="profile_picture"
                                         data-src="<?php
                                         if(isset($profilePicURL)) {
                                             echo "../static/img/profile/users/" . $profilePicURL;
                                         } else {
                                             echo "../static/img/profile/users/custom/default.png";
                                         }
                                         ?>"
                                         data-holder-rendered="true"
                                         src="<?php
                                         if(isset($profilePicURL)) {
                                             echo "../static/img/profile/users/" . $profilePicURL;
                                         } else {
                                             echo "../static/img/profile/users/custom/default.png";
                                         }
                                         ?>"
                                         alt="User's avatar or profile picture" />
                                </a>
                            </div>

                            <!-- Profile Name -->
                            <h1 class="name">
                                <span><a href="settings.php" title="Change profile settings">Irfaan Auhammad</a></span>
                            </h1>

                            <!-- User Personal Details -->
                            <div class="user-info">
                                <div><span class="glyphicon glyphicon-map-marker"></span>205 Humber College Blvd, Etobicoke</div>
                                <div><span class="glyphicon glyphicon-envelope"></span>irfaan@humber.ca</div>
                                <div><span class="glyphicon glyphicon-time"></span>Joined on Jan 30, 2017</div>
                            </div>

                            <!-- Footprint & Wishlist -->
                            <div class="activities row">
                                <div class="col-xs-6">
                                    <div><span class="activities__footprint">2</span></div>
                                    <div>Footprint</div>
                                </div>
                                <div class="col-xs-6">
                                    <div><span class="activities__wishlist">5</span></div>
                                    <div>Wishlist</div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="col-sm-9">
                        <div class="container__tab-content">

                            <!-- Footprint & Wishlist navigation -->
                            <nav class="activities-nav">
                                <h2 class="hidden">Footprint and Wish list navigation</h2>
                                <ul class="nav nav-pills">
                                    <li class="active"><a data-toggle="tab" href="#footprints"><span class="glyphicon glyphicon-road"></span>Footprint</a></li>
                                    <li><a data-toggle="tab" href="#wishlist"><span class="glyphicon glyphicon-eye-open"></span>Wishlist</a></li>
                                </ul>
                            </nav>

                            <div class="tab-content clearfix">
                                <!-- Tab: Footprints -->
                                <!-- --------------- -->
                                <div id="footprints" class="tab-pane fade in active">
                                    <!-- Share a new footprint -->
                                    <div class="share-footprint container-fluid">
                                        <h2 class="share-footprints__header">Have a new footprint?</h2>
                                        <div class="row">
                                            <div class="col-12 col-xs-2 col-sm-2"><img src="../static/img/users/profile/1.png" /></div>
                                            <div class="col-12 col-xs-7 col-sm-7 share-footprints__text">Tell us where you have been today?</div>
                                            <div class="col-12 col-xs-3 col-sm-3 share-footprint__button">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myNewFootprint"><span>New Post</span></button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Past footprints -->
                                    <div id="1" class="footprint display-group">
                                        <div class="row">
                                            <div class="col col-xs-2 col-sm-2"><img src="../static/img/users/profile/1.png" /></div>
                                            <div class="col col-xs-9 col-sm-9">
                                                <div>
                                                    <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous"></span> <span class="footprint__park">Banff National Park</span> recently.
                                                </div>
                                                <div class="footprint__date">Monday 29th Jan, 2017</div>
                                            </div>
                                        </div>
                                        <p class="footprint__caption">Here will go a short description/comment written by the user when registering a new footprint.</p>
                                        <div class="footprint__gallery">
                                            <img src="../static/img/park/0/profile.jpg" alt="Park picture" />
                                            <img src="../static/img/park/1/profile.jpg" alt="Park picture" />
                                        </div>
                                    </div>

                                    <div id="2" class="footprint display-group">
                                        <div class="row">
                                            <div class="col col-xs-2 col-sm-2"><img src="../static/img/users/profile/1.png" /></div>
                                            <div class="col col-xs-9 col-sm-9">
                                                <div>
                                                    <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous"></span> <span class="footprint__park">Banff National Park</span> recently.
                                                </div>
                                                <div class="footprint__date">Monday 29th Jan, 2017</div>
                                            </div>
                                        </div>
                                        <p class="footprint__caption">Here will go a short description/comment written by the user when registering a new footprint.</p>
                                        <div class="footprint__gallery">
                                            <img src="../static/img/park/0/profile.jpg" alt="Park picture" />
                                            <img src="../static/img/park/1/profile.jpg" alt="Park picture" />
                                        </div>
                                    </div>

                                    <div id="3" class="footprint display-group">
                                        <div class="row">
                                            <div class="col col-xs-2 col-sm-2"><img src="../static/img/users/profile/1.png" /></div>
                                            <div class="col col-xs-9 col-sm-9">
                                                <div>
                                                    <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous"></span> <span class="footprint__park">Banff National Park</span> recently.
                                                </div>
                                                <div class="footprint__date">Monday 29th Jan, 2017</div>
                                            </div>
                                        </div>
                                        <p class="footprint__caption">Here will go a short description/comment written by the user when registering a new footprint.</p>
                                        <div class="footprint__gallery">
                                            <img src="../static/img/park/0/profile.jpg" alt="Park picture" />
                                            <img src="../static/img/park/1/profile.jpg" alt="Park picture" />
                                        </div>
                                    </div>

                                </div>

                                <!-- Tab: Wishlist -->
                                <!-- ------------- -->
                                <div id="wishlist" class="tab-pane fade">

                                    <div id="w1" class="display-group">
                                        <div class="row">
                                            <div class="col col-xs-4 col-sm-4 wishlist-group__thumbnail">
                                                <img src="../static/img/park/0/profile.jpg" alt="Park picture" />
                                            </div>
                                            <div class="col col-xs-8 col-sm-8 wishlist-group__park-details">
                                                <div>
                                                    <a class="wishlist-group__park-link" href="" alt="Link to park profile page">[Nahanni National Park Reserve of Canada]</a>
                                                </div>
                                                <div class="wishlist-group__more-details">[Fort Smith, Unorganized, NT X0E, Canada]</div>
                                                <div class="wishlist-group__more-details">[Northwest Territories]</div>
                                            </div>
                                        </div>
                                        <div class="row wishlist-group__footer">
                                            <div class="col col-xs-12 col-sm-12">
                                                <span class="wishlist-group__more-details">Added on [Feb 11, 2017]</span>
                                                &nbsp;|&nbsp;
                                                <span><a href="" alt="Link to remove park from wishlist">Remove</a></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="w2" class="display-group">
                                        <div class="row">
                                            <div class="col col-xs-4 col-sm-4 wishlist-group__thumbnail">
                                                <img src="../static/img/park/0/profile.jpg" alt="Park picture" />
                                            </div>
                                            <div class="col col-xs-8 col-sm-8 wishlist-group__park-details">
                                                <div>
                                                    <a class="wishlist-group__park-link" href="" alt="Link to park profile page">[Prince Edward Island National Park]</a>
                                                </div>
                                                <div class="wishlist-group__more-details">[North Rustico, PE C0A, Canada]</div>
                                                <div class="wishlist-group__more-details">[Prince Edward Island]</div>
                                            </div>
                                        </div>
                                        <div class="row wishlist-group__footer">
                                            <div class="col col-xs-12 col-sm-12">
                                                <span class="wishlist-group__more-details">Added on [Jan 29, 2017]</span>
                                                &nbsp;|&nbsp;
                                                <span><a href="" alt="Link to remove park from wishlist">Remove</a></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>  <!-- end of right column div -->

                </div>
            </main>

            <!-- Modal Window -->
            <!-- ------------ -->
            <div class="modal fade bs-example-modal-lg" id="myNewFootprint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h3 class="modal-title" id="myModalLabel">Share a New Footprint Event</h3>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 new-footprint-header">
                                    <div class="new-footprint__icon"><span class="glyphicon glyphicon-leaf"></span></div>
                                    <div class="new-footprint__text">Has been on a new adventure</div>
                                    <div class="new-footprint__today">Today</div>
                                </div>
                            </div>
                            <div class="row new-footprint-data">
                                <form name="" action="" method="post" enctype="multipart/form-data">
                                    <!-- TODO: Form to add a new footprint -->
                                    <div class="col-md-6 new-footprint-form">
                                            <div class="form-group row">
                                                <label for="slctPark" class="col-sm-5 col-form-label">Park visited</label>
                                                <div class="col-sm-7">
                                                    <select id="slctPark" name="parkVisited" class="form-control">
                                                        <?php foreach ($lstParks as $parkDetails) {
                                                            echo "<option value=\"{$parkDetails['id']}\">{$parkDetails['name']}</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputDateVisit" class="col-sm-5 col-form-label">Date visited</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="inputDateVisit" placeholder="Date visited park" />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputStory" class="col-sm-5 col-form-label">Story</label>
                                                <div class="col-sm-7">
                                                    <textarea class="form-control" id="inputStory" row="4" placeholder="Optional"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="isPublic" class="col-sm-5 col-form-label">Share post as public?</label>
                                                <div class="col-sm-7">
                                                    <input class="form-check-input" type="checkbox" id="isPublic" value="Y">
                                                    <label for="isPublic">Yes</label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-md-6 new-footprint-images">
                                        <label for="yourImages">Upload your pictures</label>
                                        <input type="file" id="yourImages" name="files[]" multiple="multiple" accept="image/*" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Share</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Footer -->
            <?php include_once "../templates/footer.php" ?>
        </div>
        <script type="text/javascript" src="../static/js/profile.js"></script>
    </body>
</html>
