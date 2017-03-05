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
      echo $_POST['name'] . " - " . $google_id . " - " . $_POST['email'];
      $db = DatabaseAccess::getConnection();
      $publicLogin = new PublicLogin($db);
      $result = $publicLogin->googleLogin($google_id);
      if ($result) {
          if(!isset($_SESSION)){
              session_start();
          }
          $_SESSION['user_name'] = $result->user_name;
          $_SESSION['user_id'] = $result->user_id;
      }
    } else {
      echo "failed";
    }
}
