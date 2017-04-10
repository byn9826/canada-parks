<?php
//author：Bao

//Inital session if not exist
if(!isset($_SESSION)){
    session_start();
}


//define route for different pages
$team_route_src = '../';
if(isset($team_route_custom)) {
    $team_route_src = $team_route_custom;
}

//get db connection
require_once($team_route_src . 'lib/DatabaseAccess.php');
$db = DatabaseAccess::getConnection();


//if user login store in cookie
if(isset($_COOKIE['token'])){
    require_once($team_route_src . 'lib/publicLogin/default.php');
    $checkLogin = new PublicLogin($db);
    $token = $_COOKIE['token'];
    $check_result = $checkLogin->useCookieLogin($token);
    if ($check_result != NULL) {
        $_SESSION['user_name'] = $check_result['user_name'];
        $_SESSION['user_id'] = $check_result['user_id'];
    }

}



//Get header navigation names and links
require_once($team_route_src . 'lib/globe/globe.php');
$globe = new Globe($db);
$header_navi = $globe->getHeader();

//If user login passed js validation and click login
if(isset($_POST['email']) && isset($_POST['password'])) {
    require_once($team_route_src . 'lib/publicLogin/default.php');
    require_once($team_route_src . 'lib/validation/fanta_valid.php');
    //Get input
    $email = $_POST['email'];
    $password = $_POST['password'];
    //secure input
    $email = Fanta_Valid::sanitizeUserInput($email);
    $password = Fanta_Valid::sanitizeUserInput($password);
    //double check input
    if (Fanta_Valid::isNullOrEmpty($email) || Fanta_Valid::isNullOrEmpty($password) || !Fanta_Valid::isEmailValid($email) || !count($password) === 32) {
        $login_error = 'Please enable javaScript';
    } else {
        //get php secure password
        $password = sha1($password);
        //check users account in db
        $publicLogin = new PublicLogin($db);
        $login_result = $publicLogin->checkLogin($email, $password);
        //If account not exist, error message
        if (!$login_result) {
            $login_error = 'Wrong email or password';
        }
        //If account exist, email not verified
        else if (is_string($login_result)) {
            header('Location: ' . $team_route_src . 'signup/confirm.php?' . $login_result);
        }
        //If account exist, email verified, write into session
        else {
            //if user want to remember that login statues in cookie
            if (isset($_POST['remember']) && $_POST['remember'] == 'true') {
                $date = new DateTime();
                $random = $date->getTimestamp();
                $combine = $email . md5('asd32^3@ma') . sha1($random);
                $publicLogin->activeCookieLogin($email, $combine);
            }
            $_SESSION['user_name'] = $login_result['user_name'];
            $_SESSION['user_id'] = $login_result['user_id'];
        }
    }
}
//logout
if (isset($_POST['logout'])) {
    setcookie("token", "" , time()- 3600, "/", "localhost", false, true);
    $_SESSION = array();
    session_destroy();
}
?>
<div class="row">
    <header id="header" class="col-md-12 col-sm-12 col-xs-12">
        <button id="header-hamburger" type="button" class="navbar-toggle co-xs-4 visible-xs">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <div class="col-md-1 col-md-offset-1 col-sm-1 col-sm-offset-0 col-xs-2 col-xs-offset-4">
            <a href="<?php echo $team_route_src; ?>">
                <img alt="Marvel Logo" src="<?php echo $team_route_src . 'static/img/logo.png'; ?>" />
            </a>
        </div>
        <?php include "search.php"; ?>
        <ul id="header-links" class="nav navbar-nav col-md-5 col-sm-6 navbar-right visible-lg visible-md visible-sm">
            <?php
                foreach ($header_navi as $nav) {
                    echo '<li><a href="' . $team_route_src . $nav['path'] . '">' . $nav['link'] . '</a></li>';

                }
            ?>
            <li class="dropdown">
                <a id="login-dropdowm" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php
                        echo isset($_SESSION['user_name'])? $_SESSION['user_name']: 'Sign in';
                    ?>
                    <span class="caret"></span>
                </a>
                <?php
                    if (isset($_SESSION['user_name'])) {
                        include_once($team_route_src . 'lib/publicLogin/LoginHeader.php');
                    } else {
                        include_once($team_route_src . 'lib/publicLogin/noLoginHeader.php');
                    }
                ?>
            </li>
        </ul>
    </header>
</div>
<script type="text/javascript" src="<?php echo $team_route_src . 'static/js/login/login.js'; ?>"></script>
