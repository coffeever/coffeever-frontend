<?php
defined('INDEX') or die();
global $actionResult;
?>
<?php
 
// init configuration
$clientID = '624088672172-ns3a9g1v2lbnevkpco0ha9v1jcnr7rre.apps.googleusercontent.com';
$clientSecret = 'usJu7NY1M5pIThzVU1g-0Cef';
$redirectUri = 'https://coffeever.herokuapp.com/giris-yap';
    
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
 
// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  /*
  $userObj = [
    "google_id"=> $google_account_info->id,
    "name"=> $google_account_info->name,
    "mail"=> $google_account_info->email,
  ];
  */

  $userObj = [
    "google_id"=> "123",
    "name"=> "Deneme",
    "mail"=> "Deneme mail",
  ];

  $result = makeRequest("login", $userObj, 'POST');
  $_SESSION['isLoggedIn'] = true;
  $_SESSION['subscriberObj'] = $result;
  // now you can use this profile info to create account in your website and make user logged in.
} else {
  echo "<a href='".$client->createAuthUrl()."'>Google Login</a>";
}
?>
