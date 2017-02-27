<ul class="dropdown-menu">
    <form id="header-login" method="POST" action="">
        <li>
            <input type="text" class="form-control" id="login-name" name="username" placeholder="Username" >
        </li>
        <li>
            <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" >
        </li>
        <li>
            <h5 id="login-error">
                <?php echo isset($login_error)? $login_error: 'username:admin-pass:12345678'; ?>
            </h5>
        </li>
        <li>
            <input type="button" class="btn btn-link" id="login" name="login" value="Submit" />
        </li>
    </form>
    <li role="separator" class="divider"></li>
    <li><a href="<?php echo $team_route_src . 'signup/'; ?>">Sign up</a></li>
</ul>
