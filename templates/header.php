<?php
    #author：Baozier
    $team_route_src = "../";
    if(isset($team_route_custom)) {
        $team_route_src = $team_route_custom;
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
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li><a href="#">Link</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hi, Paul<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>
            </li>
        </ul>
    </header>
</div>
