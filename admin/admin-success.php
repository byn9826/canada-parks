<?php
    if (empty($_SESSION))
    {
    session_start();
    }

?>
<h2>Your action is successful!</h2>
<a class="btn btn-default" href="admin-list.php">Back to the Homepage</a>

<?php
require_once "header.php";
require_once "footer.php";
?>