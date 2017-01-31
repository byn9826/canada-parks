<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Footprints of the parks you explored already across Canada">
        <meta name="keywords" content="Canada, National-Parks, Banff, Travel, Tourism">
        <meta name="robots" content="all">
        <meta name="author" content="Irfaan">
        <title>Profile Page | Marvel Canada</title>
        <link rel="shortcut icon" href="../static/img/logo.png" type="image/x-icon" />
        <!-- Modified from image Labeled for reuse with modification, https://c2.staticflickr.com/4/3327/3573458354_72c230294f_b.jpg 2017-01-06 -->
        <link href="../static/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="../static/css/globe.css" rel="stylesheet" type="text/css"/>
        <link href="../static/css/profile.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container-fluid">
            <!-- Page Header -->
            <?php include "../templates/header.php" ?>

            <main class="container-fluid">
                <div class="row">
                    <!-- Left column -->
                    <div class="user-details col col-md-3">
                        <!-- Profile Avatar Picture -->
                        <div class="avatar">
                            <a href="#" title="Change your avatar">
                                <img src="../static/img/users/profile/1.png" alt="User's avatar picture" />
                            </a>
                        </div>

                        <!-- Profile Name -->
                        <h1 class="name"><span>Your Name</span></h1>

                        <!-- User Personal Details -->
                        <div class="user-info">
                            <div><span class="glyphicon glyphicon-map-marker"></span>Location</div>
                            <div><span class="glyphicon glyphicon-envelope"></span>test@dummymail.com</div>
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
                    <div class="col col-md-9">
                        <!-- Footprint & Wishlist navigation -->
                        <nav class="activities-nav">
                            <h2 class="hidden">Footprint and Wishlist navigation</h2>
                            <ul>
                                <li><a href="#">Footprint</a></li>
                                <li><A href="#">Wishlist</A></li>
                            </ul>
                        </nav>

                        <!-- Past Activities -->
                        <h2>Past Activities</h2>

                        <div class="footprint">
                            <div>'Your Name' has been to 'Park Name' recently.</div>
                            <div>Monday 29th Jan, 2017</div>
                            <p>Here will go a short description/comment written by the user when registering a new footprint.</p>
                            <div>
                                <img src="../static/img/park/0/0.jpg" alt="Park picture" width="200" height="175" />
                                <img src="../static/img/park/0/profile.jpg" alt="Park picture" width="200" height="175" />
                            </div>
                        </div>

                        <div class="footprint">
                            <div>'Your Name' has been to 'Park Name' recently.</div>
                            <div>Monday 29th Jan, 2017</div>
                            <p>Here will go a short description/comment written by the user when registering a new footprint.</p>
                            <div>
                                <img src="../static/img/park/1/0.jpg" alt="Park picture" width="200" height="175" />
                                <img src="../static/img/park/1/profile.jpg" alt="Park picture" width="200" height="175" />
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Page Footer -->
            <?php include "../templates/footer.php" ?>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!--        <script type="text/javascript" src="compare.js"></script>-->
    </body>
</html>
