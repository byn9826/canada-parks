<?php

//if user click login by google
if (isset($_POST['id']) && isset($_POST['profile']) && isset($_POST['name'])) {
    require_once('../../vendor/autoload.php');
    require_once('../DatabaseAccess.php');
    require_once('default.php');
    //from google user token get google id
    $client = new Google_Client(['client_id' => '168098850234-7ouvsm9ikqj9g77u623o5754kdp1t62c.apps.googleusercontent.com']);
    $payload = $client->verifyIdToken($_POST['id']);
    //if google token verified
    if ($payload) {
        $google_id = $payload['sub'];
        $db = DatabaseAccess::getConnection();
        $account = new Account($db);
        //search all records related to this gmail account
        $account_result = $account->searchEmails($_POST['email']);
        if (count($account_result) === 0 || count($account_result) > 1) {
            //email address not verified, require signup again
            if(!isset($_SESSION)){session_start();}
            $_SESSION['google_name'] = $_POST['name'];
            $_SESSION['google_email'] = $_POST['email'];
            $_SESSION['google_id'] = $google_id;
            $_SESSION['google_profile'] = $_POST['profile'];
            echo "create";
        } else if (count($account_result) == 1) {
            if ($account_result[0]['google_id'] == $google_id) {
                //if account already linked to google id, login success
                if(!isset($_SESSION)){session_start();}
                $_SESSION['user_name'] = $account_result[0]['user_name'];
                $_SESSION['user_id'] = $account_result[0]['user_id'];
                echo "success";
            } else if ($account_result[0]['google_id'] == NULL && $account_result[0]['email_valid'] != '1') {
                //account exist but email not verified, require sign up again
                if(!isset($_SESSION)) {session_start();}
                $_SESSION['google_name'] = $_POST['name'];
                $_SESSION['google_email'] = $_POST['email'];
                $_SESSION['google_id'] = $google_id;
                $_SESSION['google_profile'] = $_POST['profile'];
                echo "create";
            } else if ($account_result[0]['google_id'] == NULL && $account_result[0]['email_valid'] == '1') {
                //account exist, email verified, not link to google id yet. link it,login success
                $account->linkGoogle($google_id, $_POST['email']);
                if(!isset($_SESSION)) {session_start();}
                $_SESSION['user_name'] = $account_result[0]['user_name'];
                $_SESSION['user_id'] = $account_result[0]['user_id'];
                echo "success";
            }
        }
    }
}
