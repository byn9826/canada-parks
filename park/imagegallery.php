<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Image Gallery</title>
    <style type="text/css">
        *{margin:0;padding:0;}
        body
        {
            background:#fff;
        }
        .temporary img
        {
            width:auto;
            box-shadow:0px 0px 20px #cecece;
            -moz-transform: scale(0.7);
            -moz-transition-duration: 0.6s;
            -webkit-transition-duration: 0.6s;
            -webkit-transform: scale(0.7);

            -ms-transform: scale(0.7);
            -ms-transition-duration: 0.6s;
        }
        .temporary img:hover
        {
            box-shadow: 20px 20px 20px #dcdcdc;
            -moz-transform: scale(0.8);
            -moz-transition-duration: 0.6s;
            -webkit-transition-duration: 0.6s;
            -webkit-transform: scale(0.8);

            -ms-transform: scale(0.8);
            -ms-transition-duration: 0.6s;

        }
        #header
        {
            width:100%;
            height:50px;
            background:white;
            font-family:sans-serif;
            text-align:center;
            font-size:15px;
            color: #081f44;

        }
        #body
        {
            margin:0 auto;
            text-align:center;
        }
    </style>
</head>
<body>


<div id="body">
    <?php
    $folder_path = '../static/img/park/'; //image's folder path
    $galleries = $parkRepository->getParkGallery($id);
    foreach ($galleries as $gallery) {
    ?>
    <a><img src="<?php echo $folder_path . $gallery["src"]; ?>"  height="250" /></a>
    <?php } ?>
</div>
</body>
</html>