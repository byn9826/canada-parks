<ul class="dropdown-menu">
    <form id="header-login" method="POST" action="">
        <li>
            <input type="email" class="form-control" id="login-email" name="email" placeholder="Email" >
        </li>
        <li>
            <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" >
        </li>
        <li>
            <h5 id="login-error">
                <?php echo isset($login_error)? $login_error: 'Error message here'; ?>
            </h5>
        </li>
        <li>
            <input type="button" class="btn btn-link" id="login" name="login" value="Login" />
        </li>
    </form>
    <li role="separator" class="divider"></li>
    <li><div id="header-google" class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div></li>
    <li role="separator" class="divider"></li>
    <li><a href="<?php echo $team_route_src . 'signup/'; ?>">Sign up</a></li>
    <li><a href="<?php echo $team_route_src . 'forget/' ; ?>">Forget?</a></li>
</ul>
