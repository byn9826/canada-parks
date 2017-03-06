<?php
//Paul - Modified from login example by google https://developers.google.com/identity/sign-in/web/backend-auth
if (isset($_POST['id'])) {
    require_once('../google-api-php-client/vendor/autoload.php');
    require_once('../DatabaseAccess.php');
    require_once('../publicLogin/default.php');
    $client = new Google_Client(['client_id' => '168098850234-7ouvsm9ikqj9g77u623o5754kdp1t62c.apps.googleusercontent.com']);
    $payload = $client->verifyIdToken($_POST['id']);
    if ($payload) {
      $google_id = $payload['sub'];
      //will remove this line later
      $db = DatabaseAccess::getConnection();
      $publicLogin = new PublicLogin($db);
      $result = $publicLogin->googleLogin($google_id);
      if ($result) {
          if(!isset($_SESSION)){
              session_start();
          }
          $_SESSION['user_name'] = $result->user_name;
          $_SESSION['user_id'] = $result->user_id;
          echo "success";
      } else {
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
