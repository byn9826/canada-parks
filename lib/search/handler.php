<?php
#author: Bao
#deal with search

#response when post content
if (isset($_POST['content'])) {
    require_once('../DatabaseAccess.php');
    require_once('default.php');
    $db = DatabaseAccess::getConnection();
    $Search = new Search($db);
    $content = $_POST['content'];
    #get all related park description from park table
    $nameReult = $Search->multiSearch($content, 'park', 'name');
    $descResult = $Search->multiSearch($content, 'park', 'description');
    #total weight 3, name weight 2, desc weight 1
    $parkResult = array_merge($nameReult, $nameReult, $descResult);
    $storyResult = $Search->multiSearch($content, 'footprints', 'user_story');
    echo json_encode([$parkResult, $storyResult]);
}
