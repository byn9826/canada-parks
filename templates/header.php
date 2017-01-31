<?php
    $team_logo_src = $team_logo_custom? $team_logo_custom: "../static/img/logo.png";
    $team_personal_src = $team_personal_custom? $team_personal_custom: "../static/img/users/profile/0.png";
?>
<div class="row">
    <header id="header" class="col-md-12 col-sm-12 visible-lg visible-md visible-sm">
        <div class="col-md-1 col-md-offset-1 col-sm-1">
            <img alt="Marvel Logo" src="<?php echo $team_logo_src; ?>" />
        </div>
        <h4 class="col-md-3 col-sm-3">Marvel for your next trip</h4>
        <nav class="col-md-5 col-sm-6">
            <a class="col-md-4 col-sm-4">
                <h5>Park List</h5>
            </a>
            <a class="col-md-4 col-sm-4">
                <h5>Park Filter</h5>
            </a>
            <a class="col-md-4 col-sm-4">
                <h5>Park Images</h5>
            </a>
        </nav>
        <div class="col-md-2 col-sm-2">
            <img alt="profile" src="<?php echo $team_personal_src; ?>" />
            <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
        </div>
    </header>
</div>
