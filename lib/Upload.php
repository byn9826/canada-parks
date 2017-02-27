<?php
class Upload {
    
    public function toServer($upload) {
        //var_dump(dirname(getcwd()));
        $target_dir = "/home/ubuntu/workspace/static/upload/";
        $target_file = $target_dir . basename($upload["name"]);
        move_uploaded_file($upload["tmp_name"], $target_file);
        return "/static/upload/" . basename($upload["name"]);
    }
    
}
?>