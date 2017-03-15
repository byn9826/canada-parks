<?php
    include "../templates/meta.php";
    session_start();
    //is_null($currentUser) || !isset($currentUser) || $currentUser == false
?>

<link href="../static/css/admin.css" type="text/css" rel="stylesheet"/>

<?php if(isset($_SESSION["admin_fullname"]) || $_SESSION["admin_fullname"] != null) { //var_dump($_SESSION["admin_fullname"])?>
<div class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome back <?php echo $_SESSION["admin_fullname"]; ?><span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a href="#">Edit profile</a></li>
        <li><a href="#">Change password</a></li>
        <li role="separator" class="divider"></li>
<!--        <li class="dropdown-header">Nav header</li>-->
        <li><a href="#" onclick="loadXMLDoc()">Sign out</a></li>
    </ul>
</div>
<?php } ?>

<script type="text/javascript">
    function loadXMLDoc()
    {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp = new XMLHttpRequest();
        }
        else
        {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                // do something if the page loaded successfully
            }
        }
        xmlhttp.open("GET","ajax_file.php",true);
        xmlhttp.send();
    }
</script>
