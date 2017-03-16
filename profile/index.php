<?php
    session_start();
    // -- If user not signed in, redirect to sign-in page
    // -- -----------------------------------------------
    if (!isset($_SESSION['user_id']))
    {
        header("location: ../signup/index.php");
    }
    require_once '../lib/DatabaseAccess.php';
    require_once '../lib/validation/fanta_valid.php';
    require_once '../lib/profile/UserAccount.php';
    require_once '../lib/profile/UserDetails.php';
    require_once '../lib/profile/Wishlist.php';
    require_once '../lib/profile/manageFootprints.php';
    require_once '../lib/ParkRepository.php';


    // Check whether the wishlist tab needs to display by default
    if(isset($_GET['wishlist'])) {
        $tabWishlists = true;
    }
    $footprintStatus = "";
    if(isset($_GET['fp'])) {
        $footprintStatus = $_GET['fp'];
    }


    // -- Create a database connection
    // -- ----------------------------
    $objConnection = DatabaseAccess::getConnection();


    // -- Create an instance of user details & user account for current user
    // -- ------------------------------------------------------------------
    $objUserAccount = new UserAccount($objConnection, $_SESSION['user_id']);
    $objUserDetails = new UserDetails($objConnection, $_SESSION['user_id']);
    $objWishlist = new Wishlist($objConnection, $_SESSION['user_id']);
    $iUserDetailsRead = $objUserDetails->Read();
    if($iUserDetailsRead == 0) {
        die("Unable to read user details at the moment.");
    }
    // Find number of items in user's wishlist
    $lstParksInWishlist = $objWishlist->GetWishParkDetails();
    $iNbWishlistItems = count($lstParksInWishlist);
    $lblWishlist = ($iNbWishlistItems > 1) ? 'Wishlist items' : 'Wishlist item';
    // Get list of parks for footprint
    $parkSelected = "";

    // -- Default tab to open
    if(!isset($tabWishlists)) {
        $tabFootprints = true;
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
			include_once "../templates/meta.php";
		?>
		<meta name="author" content="Irfaan">
		<title>Profile | Marvel Canada</title>
        <link rel="stylesheet" type="text/css" href="../static/css/profile.css" />
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
        <script type="text/javascript">
            var footprintStatus = "<?php echo $footprintStatus ?>";
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <!-- Page Header -->
            <?php include_once "../templates/header.php" ?>

            <!-- Page Body -->
            <main class="container-fluid">
                <div class="row col-md-10 col-md-offset-1">

                    <!-- Left column -->
                    <div class="col-sm-3 user-sidebar">
                        <div class="user-details">
                            <!-- Profile Avatar Picture -->
                            <div class="avatar">
                                <a href="settings.php" title="Go to profile settings">
                                    <img id="profile_picture"
                                         data-src="<?php echo $objUserDetails->getProfilePictureURL(); ?>"
                                         data-holder-rendered="true"
                                         src="<?php echo $objUserDetails->getProfilePictureURL(); ?>"
                                         alt="User's avatar or profile picture" />
                                </a>
                            </div>

                            <!-- Profile Name -->
                            <h1 class="name">
                                <span>
                                    <a href="settings.php" title="Change profile settings">
                                        <?php
                                        echo ($objUserDetails->getFullName() != "")?
                                            $objUserDetails->getFullName() :
                                            ucwords($_SESSION['user_name']);
                                        ?>
                                    </a>
                                </span>
                            </h1>

                            <!-- User Personal Details -->
                            <div class="user-info">
                                <div><span class="glyphicon glyphicon-map-marker ai-glyphicon"></span><?php echo $objUserDetails->getAddress(); ?></div>
                                <div><span class="glyphicon glyphicon-envelope ai-glyphicon"></span><?php echo $objUserAccount->getEmail(); ?></div>
                                <div><span class="glyphicon glyphicon-time ai-glyphicon"></span><?php echo $objUserDetails->getJoinedOn(); ?></div>
                            </div>

                            <!-- Footprint & Wishlist -->
                            <div class="activities row">
                                <div class="col-xs-6">
                                    <a href="." title="View my footprints">
                                        <div><span class="activities__footprint">2</span></div>
                                        <div>Footprint items</div>
                                    </a>
                                </div>
                                <div class="col-xs-6">
                                    <a href="?wishlist=true" title="View parks in wish list">
                                        <div><span class="activities__wishlist"><?php echo $iNbWishlistItems ?></span></div>
                                        <div><?php echo $lblWishlist ?></div>
                                    </a>
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
                                    <li <?php if(isset($tabFootprints)) { echo 'class="active"'; } ?> >
                                        <a data-toggle="tab" href="#footprints">
                                            <span class="glyphicon glyphicon-road ai-glyphicon"></span>Footprint
                                        </a>
                                    </li>
                                    <li <?php if(isset($tabWishlists)) { echo 'class="active"'; } ?> >
                                        <a data-toggle="tab" href="#wishlist">
                                            <span class="glyphicon glyphicon-eye-open ai-glyphicon"></span>Wishlist
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                            <div class="tab-content clearfix">
                                <!-- Tab: Footprints -->
                                <!-- --------------- -->
                                <div id="footprints" class="tab-pane fade <?php if(isset($tabFootprints)) { echo 'in active'; } ?> ">
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
                                                    <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous ai-glyphicon"></span> <span class="footprint__park">Banff National Park</span> recently.
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
                                                    <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous ai-glyphicon"></span> <span class="footprint__park">Banff National Park</span> recently.
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
                                                    <span class="footprint__user">Irfaan Auhammad</span> has been to <span class="glyphicon glyphicon-tree-deciduous ai-glyphicon"></span> <span class="footprint__park">Banff National Park</span> recently.
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
                                <div id="wishlist" class="tab-pane fade <?php if(isset($tabWishlists)) { echo 'in active'; } ?> ">

                                    <?php
                                        echo Wishlist::ConstructWishlistItems($lstParksInWishlist);
                                    ?>

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
                        <form name="frmAddFootprint" id="frmAddFootprint" action="../lib/profile/manageFootprints.php" method="post" enctype="multipart/form-data">
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
                                <!-- TODO: Form to add a new footprint -->
                                <div class="col-md-6 new-footprint-form">
                                        <!-- Park Referenced in Footprint -->
                                        <div class="form-group row">
                                            <label for="slctPark" class="col-sm-5 col-form-label">Park visited</label>
                                            <div class="col-sm-7">
                                                <select id="slctPark" name="parkVisited" class="form-control">
                                                    <?php
                                                        echo ParkRepository::getParksForDropDown($objConnection, $parkSelected);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Date Visited Park -->
                                        <div class="form-group row">
                                            <label for="inputDateVisit" class="col-sm-5 col-form-label">Date visited</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="inputDateVisit" name="dateVisited" placeholder="Date visited park" />
                                            </div>
                                            <div id="errFootprintDate" class="col-sm-5 col-sm-offset-5 text-danger"></div>
                                        </div>
                                        <!-- User Story about Footprint -->
                                        <div class="form-group row">
                                            <label for="inputStory" class="col-sm-5 col-form-label">Story</label>
                                            <div class="col-sm-7">
                                                <textarea class="form-control" id="inputStory" name="userStory" row="5" placeholder="Optional"></textarea>
                                            </div>
                                        </div>
                                        <!-- Indicate if footprint shared as public -->
                                        <div class="form-group row">
                                            <label for="isPublic" class="col-sm-5 col-form-label">Share post as public?</label>
                                            <div class="col-sm-7">
                                                <input class="form-check-input" type="checkbox" id="isPublic" name="isPublic" value="Y">
                                                <label for="isPublic">Yes</label>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-6 new-footprint-images">
                                    <label for="yourImages">Upload your pictures</label>
                                    <input type="file" id="yourImages" name="files[]" multiple="multiple" accept="image/*" />
                                </div>
                            </div>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" id="btnShareFootprint" name="btnShareFootprint" class="btn btn-primary">Share Footprint</button>
                            <button type="button" id="btnCancelFootprint" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Footer -->
            <?php include_once "../templates/footer.php" ?>
        </div>
        <script type="text/javascript" src="../static/js/profile.js"></script>
        <script type="text/javascript" src="../static/js/alert.js"></script>
    </body>
</html>
