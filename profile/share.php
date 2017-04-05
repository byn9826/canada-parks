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
$objFootprints = new Footprints($objConnection, $_SESSION['user_id']);
$objWishlist = new Wishlist($objConnection, $_SESSION['user_id']);
$iUserDetailsRead = $objUserDetails->Read();
if($iUserDetailsRead == 0) {
    die("Unable to read user details at the moment.");
}

// -- Find number of items in user's footprint
$lstFootprints = $objFootprints->GetFootprintsDetails();
$iNbFootprints = count($lstFootprints);
$lblFootprints = ($iNbFootprints > 1) ? 'Footprint items' : 'Footprint item';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once "../templates/meta.php";
    ?>
    <meta name="author" content="Irfaan">
    <title>Profile | Marvel Canada</title>
    <link rel="stylesheet" href="../lib/profile/owl.carousel.min.css">
    <link rel="stylesheet" href="../lib/profile/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="../static/css/profile.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../static/css/footprints.css" />
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    <script src="../lib/profile/owl.carousel.js"></script>
    <script type="text/javascript">
        var footprintStatus = "<?php echo $footprintStatus ?>";
        var currentUserId = "<?php echo $_SESSION['user_id'] ?>";
    </script>
</head>
<body>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '270453156734455',
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $(document).on('click','#shareBtn',function(){
        FB.ui({
            display: 'popup',
            method: 'share',
            href: 'http://micslayout.azurewebsites.net/',
//            href: 'http://localhost:8080/http5202/group_project/canada-parks/profile/share.php',
        }, function(response){});
    });

</script>
<div class="container-fluid">
    <!-- Page Header -->
    <?php include_once "../templates/header.php" ?>

    <!-- Page Body -->
    <main class="container-fluid">
        <div class="row col-md-10 col-md-offset-1">

            <!-- Left column -->
            <div class="col-sm-3 user-sidebar"></div>

            <!-- Right column -->
            <div class="col-sm-9">
                <div class="container__tab-content">
                    <div id="footprints">
                        <!-- Past footprints -->
                        <?php
                            $obj = $lstFootprints[3];
                            $newLst[] = $obj;
                            echo Footprints::ConstructFootprintItems($newLst, true);
                        ?>
                    </div>
                </div>
            </div>  <!-- end of right column div -->

        </div>
    </main>

    <!-- Page Footer -->
    <?php include_once "../templates/footer.php" ?>
</div>
<script type="text/javascript" src="../static/js/profile.js"></script>
</body>
</html>
