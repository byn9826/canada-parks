<?php
#author：Bao
## define route for different page
$team_route_src = '../';
if(isset($team_route_custom)) {
    $team_route_src = $team_route_custom;
}
##If js submit login form
if(isset($_POST['username'])) {
    require_once($team_route_src . 'lib/DatabaseAccess.php');
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
    <header id="header" class="col-md-12 col-sm-12 visible-lg visible-md visible-sm">
        <div class="col-md-1 col-md-offset-1 col-sm-1">
            <img alt="Marvel Logo" src="<?php echo $team_route_src . 'static/img/logo.png'; ?>" />
        </div>
        <form class="navbar-form navbar-left col-md-5" role="search">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
            </div>
            <span id="header-searchicon" class="glyphicon glyphicon-search"></span>
        </form>
        <ul class="nav navbar-nav col-md-4 navbar-right">
            <li><a href="parks">Parks</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <?php
                        echo isset($_SESSION['user_name'])? $_SESSION['user_name']: 'Sign in';
                    ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <form id="header-login" method="POST" action="">
                        <li>
                            <?php
                                if (isset($_SESSION['user_name'])) {
                                    echo '<h4>Profile</h4>';
                                }
                                else {
                                    echo '<input type="text" class="form-control" id="login-name" name="username" placeholder="Username" >';
                                }
                            ?>
                        </li>
                        <li>
                            <?php
                                if (isset($_SESSION['user_name'])) {
                                    echo '<h4>Wishlist</h4>';
                                }
                                else {
                                    echo '<input type="password" class="form-control" id="login-password" placeholder="Password" >';
                                    echo '<input type="hidden" class="form-control" id="final-password" name="password" >';
                                }
                            ?>
                        </li>
                        <li>
                            <?php
                                if (isset($_SESSION['user_name'])) {
                                    echo '<h4>Setting</h4>';
                                }
                                else {
                                    echo '<h5 id="login-error">';
                                        echo isset($login_error)? $login_error: 'username:admin-pass:12345678';
                                    echo '</h5>';
                                }
                            ?>
                        </li>
                        <li>
                            <?php
                                if (isset($_SESSION['user_name'])) {
                                    echo 'messagebox';
                                }
                                else {
                                    echo '<input type="button" class="btn btn-link" id="login" name="login" value="Submit" />';
                                }
                            ?>
                        </li>
                    </form>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo $team_route_src . 'signup/'; ?>">Sign up</a></li>
                </ul>
            </li>
        </ul>
    </header>
</div>
<script type="text/javascript" src="<?php echo $team_route_src . 'static/js/login/login.js'; ?>"></script>
