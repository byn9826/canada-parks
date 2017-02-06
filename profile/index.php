<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
			include_once "../templates/meta.php";
		?>
		<meta name="author" content="Irfaan">
		<title>Profile Page | Marvel Canada</title>
        <link rel="stylesheet" type="text/css" href="../static/css/profile.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <!-- Page Header -->
            <?php include_once "../templates/header.php" ?>

            <!-- Page Body -->
            <main class="container-fluid">
                <div class="row">

                    <!-- Left column -->
                    <div class="user-details col col-md-3">
                        <!-- Profile Avatar Picture -->
                        <div class="avatar">
                            <a href="#" title="Change your avatar">
                                <img src="../static/img/users/profile/1.png" alt="User's avatar picture" />
                                <!-- Confirm with team about circle image? -->
                            </a>
                        </div>

                        <!-- Profile Name -->
                        <h1 class="name"><span>Irfaan Auhammad</span></h1>

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

                    <!-- Right column -->
                    <div class="container__activities col col-md-9">
                        <!-- Footprint & Wishlist navigation -->
                        <nav class="activities-nav">
                            <h2 class="hidden">Footprint and Wish list navigation</h2>
                            <ul class="nav nav-pills">
                                <li class="active"><a data-toggle="pill" href="#footprints"><span class="glyphicon glyphicon-road"></span>Footprint</a></li>
                                <li><a data-toggle="pill" href="#wishlist"><span class="glyphicon glyphicon-eye-open"></span>Wishlist</a></li>
                            </ul>
                        </nav>

                        <div class="tab-content">
                            <!-- Tab: Footprints -->
                            <div id="footprints" class="tab-pane fade in active">
                                <!-- Past Footprints -->
                                <div class="share-footprint container-fluid">
                                    <h2 class="share-footprints__header">Have a new footprint?</h2>
                                    <div class="row">
                                        <div class="col col-xs-1 col-lg-1"><img src="../static/img/users/profile/1.png" /></div>
                                        <div class="col col-xs-9 col-lg-9 share-footprints__text">Tell us where you have been today?</div>
                                        <div class="col col-xs-2 col-lg-2 share-footprint__button">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myNewFootprint">New Post</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="footprint">
                                    <div class="row">
                                        <div class="col col-xs-1 col-lg-1"><img src="../static/img/users/profile/1.png" /></div>
                                        <div class="col col-xs-1 col-lg-11">
                                            <div>
                                                <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous"></span> <span class="footprint__park">Banff National Park</span> recently.
                                            </div>
                                            <div class="footprint__date">Monday 29th Jan, 2017</div>
                                        </div>
                                    </div>
                                    <p class="footprint__caption">Here will go a short description/comment written by the user when registering a new footprint.</p>
                                    <div class="footprint__gallery">
                                        <img src="../static/img/park/0/0.jpg" alt="Park picture" width="200" height="175" />
                                        <img src="../static/img/park/0/profile.jpg" alt="Park picture" width="200" height="175" />
                                    </div>
                                </div>

                                <div class="footprint">
                                    <div class="row">
                                        <div class="col col-xs-1 col-lg-1"><img src="../static/img/users/profile/1.png" /></div>
                                        <div class="col col-xs-1 col-lg-11">
                                            <div>
                                                <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous"></span> <span class="footprint__park">Banff National Park</span> recently.
                                            </div>
                                            <div class="footprint__date">Monday 29th Jan, 2017</div>
                                        </div>
                                    </div>
                                    <p class="footprint__caption">Here will go a short description/comment written by the user when registering a new footprint.</p>
                                    <div class="footprint__gallery">
                                        <img src="../static/img/park/0/0.jpg" alt="Park picture" width="200" height="175" />
                                        <img src="../static/img/park/0/profile.jpg" alt="Park picture" width="200" height="175" />
                                    </div>
                                </div>

                                <div class="footprint">
                                    <div class="row">
                                        <div class="col col-xs-1 col-lg-1"><img src="../static/img/users/profile/1.png" /></div>
                                        <div class="col col-xs-1 col-lg-11">
                                            <div>
                                                <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous"></span> <span class="footprint__park">Banff National Park</span> recently.
                                            </div>
                                            <div class="footprint__date">Monday 29th Jan, 2017</div>
                                        </div>
                                    </div>
                                    <p class="footprint__caption">Here will go a short description/comment written by the user when registering a new footprint.</p>
                                    <div class="footprint__gallery">
                                        <img src="../static/img/park/0/0.jpg" alt="Park picture" width="200" height="175" />
                                        <img src="../static/img/park/0/profile.jpg" alt="Park picture" width="200" height="175" />
                                    </div>
                                </div>

                            </div>

                            <!-- Tab: Wishlist -->
                            <div id="wishlist" class="tab=pane fade">
                                <h2>Your Wish list</h2>
                                <div>Your wish list will appear here ...</div>
                            </div>
                        </div>
                    </div>  <!-- end of right column div -->

                </div>
            </main>

            <!-- Modal Window -->
            <div class="modal fade bs-example-modal-lg" id="myNewFootprint" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel">Share a New Footprint Event</h3>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    Travelled Today
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Form collecting data about new footprint ...
                                </div>
                                <div class="col-md-6">
                                    Section to allow for images upload ...
                                </div>
                            </div>
                        </div>
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
            <!-- <script type="text/javascript" src="compare.js"></script>-->
    </body>
</html>
