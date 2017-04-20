<?php 
    #author Bao
?>
<ul class="dropdown-menu">
    <li><a href="<?php echo $team_route_src . 'profile/'; ?>">
        Profile
    </a></li>
    <li><a href="<?php echo $team_route_src . 'profile/settings.php'; ?>">
        Setting
    </a></li>
    <li role="separator" class="divider"></li>
    <li>
        <form id="logout" method="POST" action="<?php echo $team_route_src; ?>" >
            <input id="header-logout" name="logout" type="submit" value="Log out" />
        </form>
    </li>
</ul>
