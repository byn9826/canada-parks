<?php
//author：Bao

//Inital session if not exist
if(!isset($_SESSION)){
    session_start();
}

//define route for difference between index and other pages
$team_route_src = '../';
if(isset($team_route_custom)) {
    $team_route_src = $team_route_custom;
}

//get db connection
require_once($team_route_src . 'lib/DatabaseAccess.php');
$db = DatabaseAccess::getConnection();

//Get header navigation names and links
require_once($team_route_src . 'lib/globe/default.php');
$globe = new Globe($db);
$header_navi = $globe->getHeader();

//if user remember login stored in cookie
if(isset($_COOKIE['token'])){
    require_once($team_route_src . 'lib/account/default.php');
    $account = new Account($db);
    $token = $_COOKIE['token'];
    $cookie_result = $account->checkCookie($token);
    if ($cookie_result != NULL) {
        $_SESSION['user_name'] = $cookie_result['user_name'];
        $_SESSION['user_id'] = $cookie_result['user_id'];
    }

}

//If user click login with email and password
if(isset($_POST['email']) && isset($_POST['password'])) {
    require_once($team_route_src . 'lib/account/default.php');
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
        $account = new Account($db);
        //search all records related to this email address
        $login_result = $account->searchEmails($email);
        if (count($login_result) == 0) {
            //if no result found
            $login_error = 'Wrong email address';
        } else if (count($login_result) > 1) {
            //if more than one record found redirect to email verify page
            foreach ($login_result as $r) {
                if ($r['user_password'] == $password) {
                    $username = $r['user_name'];
                }
            }
            header('Location: ' . $team_route_src . 'signup/confirm.php?' . 'email=' . $email . '&name=' . $username);
        } else if (count($login_result) == 1) {
            if ($login_result[0]['email_valid'] != 1) {
                //if one record found, but email not valid, redirect to email verify page
                header('Location: ' . $team_route_src . 'signup/confirm.php?' . 'email=' . $email . '&name=' . $result[0]['user_name']);
            } else if ($login_result[0]['user_password'] != $password) {
                //if one record found, email valid but password wrong
                $login_error = 'Password is wrong';
            } else {
                //login success, user choose remember cookie
                if (isset($_POST['remember']) && $_POST['remember'] == 'true') {
                    $date = new DateTime();
                    $random = $date->getTimestamp();
                    $combine = $email . md5('asd32^3@ma') . sha1($random);
                    $account->activeCookie($email, $combine);
                }
                //login success, write name, id into session
                $_SESSION['user_name'] = $login_result[0]['user_name'];
                $_SESSION['user_id'] = $login_result[0]['user_id'];
            }
        }
    }
}

//logout, clear cookie session
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
        <div class="col-md-1 col-md-offset-1 col-sm-1 col-sm-offset-0 col-xs-2 col-xs-offset-2">
            <a href="<?php echo $team_route_src; ?>">
                <img alt="Marvel Logo" src="<?php echo $team_route_src . 'static/img/logo.png'; ?>" />
            </a>
        </div>
        <?php include "search.php"; ?>
        <ul id="header-links" class="nav navbar-nav col-md-4 col-sm-6 navbar-right col-xs-6">
            <?php
                foreach ($header_navi as $nav) {
                    echo '<li class="visible-lg visible-md visible-sm"><a href="' . $team_route_src . $nav['path'] . '">' . $nav['link'] . '</a></li>';
                }
            ?>
            <li id="login-area" class="dropdown">
                <a id="login-dropdowm" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php
                        //show user name or "sign in" based on user login or not
                        echo isset($_SESSION['user_name'])? $_SESSION['user_name']: 'Sign in';
                    ?>
                    <span class="caret"></span>
                </a>
                <?php
                    //show different dropdown list based on user login or not
                    if (isset($_SESSION['user_name'])) {
                        include_once('LoginHeader.php');
                    } else {
                        include_once('noLoginHeader.php');
                    }
                ?>
            </li>
        </ul>
    </header>
    <section id="mobile">
        <?php
            foreach ($header_navi as $nav) {
                echo '<div><a href="' . $team_route_src . $nav['path'] . '"><h4>' . $nav['link'] . '</h4></a></div>';
            }
        ?>
    </section>
</div>
<script type="text/javascript" src="<?php echo $team_route_src . 'static/js/login/login.js'; ?>"></script>
<script id="js-team-route" type="application/json">
    <?php echo $team_route_src; ?>
</script>
