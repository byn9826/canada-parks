<?php
    #author：Baozier
    ## define route for different page
    $team_route_src = "../";
    if(isset($team_route_custom)) {
        $team_route_src = $team_route_custom;
    }
    ## If user click login
    if(isset($_POST['login'])) {
        require_once('./lib/DatabaseAccess.php');
        require_once('./lib/publicLogin/default.php');
        $db = DatabaseAccess::getConnection();
        $publicLogin = new PublicLogin($db);
        $success = $publicLogin->checkLogin($_POST['username'], $_POST['password']);
        echo $success;
    }
?>
<div class="row">
    <header id="header" class="col-md-12 col-sm-12 visible-lg visible-md visible-sm">
        <div class="col-md-1 col-md-offset-1 col-sm-1">
            <img alt="Marvel Logo" src="<?php echo $team_route_src . "static/img/logo.png"; ?>" />
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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <form id="header-login" method="POST" action="">
                        <li>
                            <input type="text" class="form-control" name="username" placeholder="Username">
                        </li>
                        <li>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </li>
                        <li>
                            <input type="submit" class="btn btn-link" name="login" value="Submit" />
                        </li>
                    </form>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo $team_route_src . "signup/"; ?>">Sign up</a></li>
                </ul>
            </li>
        </ul>
    </header>
</div>
