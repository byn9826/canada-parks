<?php
require_once ('../lib/myLocalhostDB.php');

$post = isset($_POST) ? $_POST: array();
switch($post['action']) {
    case 'save' :
        saveProfilePicTmp();
        break;
    default:
        changeProfilePic();
        break;
}

/* Function to change profile picture */
function changeProfilePic() {
    $post = isset($_POST) ? $_POST : array();
    $max_width = "500";
    $userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
    $path = '../static/img/profile/users';
    $valid_formats = array("jpg", "png", "gif", "bmp","jpeg", "JPG", "PNG", "GIF", "BMP", "JPEG");
    $name = $_FILES['profile-pic']['name'];
    $size = $_FILES['profile-pic']['size'];
    if(strlen($name)) {
        list($txt, $ext) = explode(".", $name);
        if(in_array($ext,$valid_formats)) {
            if($size<(2048*2048)) {
                $actual_image_name = 'avatar' .'_'.$userId .'.'.$ext;
                $filePath = $path .'/'.$actual_image_name;
                $tmp = $_FILES['profile-pic']['tmp_name'];
                if(move_uploaded_file($tmp, $filePath)) {
                    $width = getWidth($filePath);
                    $height = getHeight($filePath);
                    //Scale the image if it is greater than the width set above
                    if ($width > $max_width){
                        $scale = $max_width/$width;
                        $uploaded = resizeImage($filePath,$width,$height,$scale);
                    } else {
                        $scale = 1;
                        $uploaded = resizeImage($filePath,$width,$height,$scale);
                    }
//                    $res = saveProfilePic(array(
//                        'userId' => isset($userId) ? intval($userId) : 0,
//                        'avatar' => isset($actual_image_name) ? $actual_image_name : '',
//                    ));
                    echo "<img id='photo' file-name='".$actual_image_name."' class='' src='".$filePath.'?'.time()."' class='preview'/>";
                }
                else
                    echo "failed";
            }
            else
                echo "Image file size max 1 MB";
        }
        else
            echo "Invalid file format..";
    }
    else
        echo "Please select image..!";
    exit;
}
/* Function to handle save profile pic */
function saveProfilePic($options){
    $objConnection = myLocalhostDB::getConnection();
    $query = 'INSERT INTO dinosaurs (name, color) VALUES(:userId, :url) WHERE NOT EXISTS(SELECT 1 FROM dinosaurs WHERE name = :userId)';
    $statement = $objConnection->prepare($query);
    $statement->bindValue(':userId', $options['userId']);
    $statement->bindValue(':url', $options['avatar']);
    $statement->execute();
}

/* Function to update image */
function saveProfilePicTmp() {
    $post = isset($_POST) ? $_POST: array();
    $userId = isset($post['id']) ? intval($post['id']) : 0;
    $path ='\\images\tmp';
    $t_width = 300; // Maximum thumbnail width
    $t_height = 300;    // Maximum thumbnail height
    if(isset($_POST['t']) and $_POST['t'] == "ajax") {
        extract($_POST);
        $imagePath = '../static/img/profile/users/'.$_POST['image_name'];
        $ratio = ($t_width/$w1);
        $nw = ceil($w1 * $ratio);
        $nh = ceil($h1 * $ratio);
        $nimg = imagecreatetruecolor($nw,$nh);
        $im_src = imagecreatefromjpeg($imagePath);
        imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);
        imagejpeg($nimg,$imagePath,90);
        $res = saveProfilePic(array(
            'userId' => isset($userId) ? intval($userId) : 0,
            'avatar' => isset($actual_image_name) ? $actual_image_name : '',
        ));
    }
    echo $imagePath.'?'.time();;
    exit(0);
}
/* Function  to resize image */
function resizeImage($image,$width,$height,$scale) {
    $newImageWidth = ceil($width * $scale);
    $newImageHeight = ceil($height * $scale);
    $newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
    $source = imagecreatefromjpeg($image);
    imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
    imagejpeg($newImage,$image,90);
    chmod($image, 0777);
    return $image;
}
/*  Function to get image height. */
function getHeight($image) {
    $sizes = getimagesize($image);
    $height = $sizes[1];
    return $height;
}
/* Function to get image width */
function getWidth($image) {
    $sizes = getimagesize($image);
    $width = $sizes[0];
    return $width;
}
