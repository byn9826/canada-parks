<?php
    #author：Baozier
    $team_route_src = "../";
    if(isset($team_route_custom)) {
        $team_route_src = $team_route_custom;
    }
 ?>
<div id="userComment"></div>
<script type="text/javascript" src="<?php echo $team_route_src . "static/react/comment.bundle.js"; ?>"></script>
