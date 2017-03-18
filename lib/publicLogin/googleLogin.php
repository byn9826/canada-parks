<?php
//Paul - Modified from login example by google https://developers.google.com/identity/sign-in/web/backend-auth
if (isset($_POST['id'])) {
    require_once('../../vendor/autoload.php');
    require_once('../DatabaseAccess.php');
    require_once('default.php');
    $client = new Google_Client(['client_id' => '168098850234-7ouvsm9ikqj9g77u623o5754kdp1t62c.apps.googleusercontent.com']);
    $payload = $client->verifyIdToken($_POST['id']);
    if ($payload) {
      $google_id = $payload['sub'];
      //will remove this line later
      $db = DatabaseAccess::getConnection();
      $publicLogin = new PublicLogin($db);
      $result = $publicLogin->googleLogin($google_id);
      //if email verified, account exist
      if ($result && !is_string($result)) {
          if(!isset($_SESSION)){
              session_start();
          }
          $_SESSION['user_name'] = $result->user_name;
          $_SESSION['user_id'] = $result->user_id;
          echo "success";
      }
      //if email not verified
      else if ($result && is_string($result)) {
          echo $result;
      }
      else {
          if(!isset($_SESSION)){
              session_start();
          }
          $_SESSION['google_name'] = $_POST['name'];
          $_SESSION['google_email'] = $_POST['email'];
          $_SESSION['google_id'] = $google_id;
          $_SESSION['google_profile'] = $_POST['profile'];
          echo "create";
      }
    } else {
      echo "failed";
    }
}
