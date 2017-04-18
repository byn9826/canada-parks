<?php
/**
 * Created by PhpStorm.
 * User: M. Irfaan Auhammad
 * Date: 07-Apr-17
 * Time: 5:16 PM
 */

    // GET User Id and Footprint Id
    if(isset($_GET['uid'])) {
        $sUserId = $_GET['uid'];
    }

    if(isset($_GET['fid'])) {
        $iFootprintId = $_GET['fid'];
    }

    // Return Error 400 in case query string parameters missing
    if(!isset($_GET['uid']) || !isset($_GET['fid'])) {
        echo '<h1>400 - Bad Request</h1>';
        echo 'Your browser sent a request that this server could not understand';
        die(400);
    }

    // -- Include required libraries
    require_once '../lib/DatabaseAccess.php';
    require_once '../lib/profile/UserDetails.php';
    require_once '../lib/profile/Footprints.php';


    // -- Create a database connection
    // -- ----------------------------
    $objConnection = DatabaseAccess::getConnection();


    // -- Create an instance of user details for current user
    // -- ---------------------------------------------------
    $objUserDetails = new UserDetails($objConnection, $sUserId);
    $objFootprints = new Footprints($objConnection, $sUserId);
    $iUserDetailsRead = $objUserDetails->Read();
    if($iUserDetailsRead == 0) {
        echo '<h1>404 - Page Not Found</h1>';
        echo 'Requested Page Cannot Be Found!';
        die(404);
    }


    // -- Select footprint requested
    // -- --------------------------
    $lstFootprints = $objFootprints->GetFootprintsDetails($iFootprintId);
    if(count($lstFootprints) < 1) {
        echo '<h1>404 - Page Not Found</h1>';
        echo 'Requested Page Cannot Be Found!';
        die(404);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once "../templates/meta.php";
    ?>
    <meta name="author" content="Irfaan">
    <title>Footprint | Marvel Canada</title>
    <link rel="stylesheet" href="../lib/profile/owl.carousel.min.css">
    <link rel="stylesheet" href="../lib/profile/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="../static/css/profile.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../static/css/footprints.css" />
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="../lib/profile/owl.carousel.js"></script>
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
                </div>
            </div>

            <!-- Right column -->
            <div class="col-sm-9">
                <h2 class="text-center">Marvel Canada Footprint</h2>
                <div class="container__tab-content">
                    <div id="footprints">
                        <?php
                            echo Footprints::ConstructFootprintItems($lstFootprints, false, false);
                        ?>
                    </div>
                </div>
            </div>  <!-- end of right column div -->

        </div>
    </main>

    <!-- Page Footer -->
    <?php include_once "../templates/footer.php" ?>
</div>
<script>

    $(document).ready(function() {

        // -- Initialise the Carousel for images
        function pInitialiseCarousel() {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                margin: 5,
                nav: true,
                // loop: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    420: {
                        items: 2
                    },
                    700: {
                        items: 3
                    }
                }
            })
        }

        pInitialiseCarousel();

    });

</script>
</body>
</html>
