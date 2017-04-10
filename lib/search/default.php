<?php
#author: BAO
#Class used for search
class Search{

    #Init class with db string
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    #search all related result from park description
    public function multiSearch($content, $table, $column) {
        #build like string for whole words
        $likeContent = '%' . $content . '%';
        $likeQuery = 'SELECT * FROM ' . $table. ' WHERE ' . $column . ' LIKE :likeContent';
        $likeStmt = $this->db->prepare($likeQuery);
        $likeStmt->bindValue(':likeContent', $likeContent, PDO::PARAM_STR);
        $likeStmt->execute();
        #get result for the whole word
        $likeResult = $likeStmt->fetchAll(PDO::FETCH_ASSOC);
        #return string to array
        $contentArray = str_split($content);
        #turn search content into odd and even
        $oddString = '';
        $evenString = '';
        foreach($contentArray as $k=>$v) {
            if ($k % 2 == 0) {
                $oddString .= $v;
                $evenString .= '_';
            } else {
                $oddString .= '_';
                $evenString .= $v;
            }
        }
        #build like string for odd characters
        $oddContent = '%' . $oddString . '%';
        $oddQuery = 'SELECT * FROM ' . $table. ' WHERE ' . $column . ' LIKE :oddContent';
        $oddStmt = $this->db->prepare($oddQuery);
        $oddStmt->bindValue(':oddContent', $oddContent, PDO::PARAM_STR);
        $oddStmt->execute();
        #get result for odd characters of the words
        $oddResult = $oddStmt->fetchAll(PDO::FETCH_ASSOC);
        #build like string for even characters
        $evenContent = '%' . $evenString . '%';
        $evenQuery = 'SELECT * FROM ' . $table. ' WHERE ' . $column . ' LIKE :evenContent';
        $evenStmt = $this->db->prepare($evenQuery);
        $evenStmt->bindValue(':evenContent', $evenContent, PDO::PARAM_STR);
        $evenStmt->execute();
        #get result for even characters of the words
        $evenResult = $evenStmt->fetchAll(PDO::FETCH_ASSOC);
        #build like string for empty space
        $emptyString = str_replace(' ', '%', $content);
        #build like string for replace empty space string
        $emptyContent = '%' . $emptyString . '%';
        $emptyQuery = 'SELECT * FROM ' . $table. ' WHERE ' . $column . ' LIKE :emptyContent';
        $emptyStmt = $this->db->prepare($emptyQuery);
        $emptyStmt->bindValue(':emptyContent', $emptyContent, PDO::PARAM_STR);
        $emptyStmt->execute();
        #get result for repace empty characters of the words
        $emptyResult = $emptyStmt->fetchAll(PDO::FETCH_ASSOC);
        #merge all the result
        $allResult = array_merge($likeResult, $oddResult, $evenResult, $emptyResult);
        return $allResult;
    }

}
