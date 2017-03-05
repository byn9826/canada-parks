<?php
#author：Bao
##use session
if(!isset($_SESSION)){
    session_start();
}
## define route for different pages
$team_route_src = '../';
if(isset($team_route_custom)) {
    $team_route_src = $team_route_custom;
}
##Get header navi info
require_once($team_route_src . 'lib/DatabaseAccess.php');
require_once($team_route_src . 'lib/globe/globe.php');
$db = DatabaseAccess::getConnection();
$globe = new Globe($db);
$header_navi = $globe->getHeader();
##If user login passed js validation submit login form
if(isset($_POST['username'])) {
    require_once($team_route_src . 'lib/publicLogin/default.php');
    require_once($team_route_src . 'lib/validation/fanta_valid.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    //secure input
    $username = Fanta_Valid::sanitizeUserInput($username);
    $password = Fanta_Valid::sanitizeUserInput($password);
    //double check input
    if (Fanta_Valid::isNullOrEmpty($username) || Fanta_Valid::isNullOrEmpty($username) || !Fanta_Valid::isBelowMaxLength($username, 10) || !count($password) === 32) {
        $login_error = 'Please enable javaScript';
    } else {
        //get php secure password
        $password = sha1($password);
        //check users password in db
        $db = DatabaseAccess::getConnection();
        $publicLogin = new PublicLogin($db);
        $login_result = $publicLogin->checkLogin($username, $password);
        if (!$login_result) {
            $login_error = 'Wrong name or password';
        } else {
            $_SESSION['user_name'] = $login_result->user_name;
            $_SESSION['user_id'] = $login_result->user_id;
        }
    }
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
        <form class="navbar-form navbar-left col-md-5 col-sm-4 visible-lg visible-md visible-sm" role="search">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
            </div>
            <span id="header-searchicon" class="glyphicon glyphicon-search"></span>
        </form>
        <ul id="header-links" class="nav navbar-nav col-md-5 col-sm-6 navbar-right visible-lg visible-md visible-sm">
            <?php
                foreach ($header_navi as $nav) {
                    echo '<li><a>' . $nav['link'] . '</a></li>';
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
