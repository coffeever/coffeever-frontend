<?php
defined('INDEX') or die();

// init configuration
$clientID = '624088672172-ns3a9g1v2lbnevkpco0ha9v1jcnr7rre.apps.googleusercontent.com';
$clientSecret = 'usJu7NY1M5pIThzVU1g-0Cef';
$redirectUri = 'https://coffeever.herokuapp.com/';
    
// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
 
// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  unsetAuthParams();
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token['access_token']);
  
  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  $google_account_info = $google_oauth->userinfo->get();

  $userObj = [
    "google_id"=> ((float)$google_account_info->id),
    "name"=>  $google_account_info->name,
    "mail"=> $google_account_info->email,
  ];
  debugPrint(($userObj));
  $result = makeRequest("login", $userObj, 'POST');
  debugPrint(($result));


  $_SESSION['isLoggedIn'] = true;
  $_SESSION['subscriberObj'] = $result;

  // now you can use this profile info to create account in your website and make user logged in.
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Coffeever</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes" rel="stylesheet">

    <link rel="stylesheet" href="/templates/coffeever/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="/templates/coffeever/css/animate.css">
    
    <link rel="stylesheet" href="/templates/coffeever/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/templates/coffeever/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/templates/coffeever/css/magnific-popup.css">

    <link rel="stylesheet" href="/templates/coffeever/css/aos.css">

    <link rel="stylesheet" href="/templates/coffeever/css/ionicons.min.css">

    <link rel="stylesheet" href="/templates/coffeever/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/templates/coffeever/css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="/templates/coffeever/css/flaticon.css">
    <link rel="stylesheet" href="/templates/coffeever/css/icomoon.css">
    <link rel="stylesheet" href="/templates/coffeever/css/style.css">
    <link rel="stylesheet" href="/templates/coffeever/css/circle.css">
    <link rel="icon" href="/templates/coffeever/images/icons/favicon.png" sizes="32x32">
  </head>
  <body>
  	<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="/">Coffee<small>Fever</small></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item <?php echo (getConfigParam('page') == "home" ? "active" : "")?>"><a href="/" class="nav-link">Home</a></li>
	          <li class="nav-item <?php echo (getConfigParam('page') == "search" ? "active" : "")?>"><a href="/search" class="nav-link">Search</a></li>
	          <li class="nav-item <?php echo (getConfigParam('page') == "coffees" ? "active" : "")?>"><a href="/coffees" class="nav-link">Coffees</a></li>
	          <li class="nav-item <?php echo (getConfigParam('page') == "our-team" ? "active" : "")?>"><a href="/our-team" class="nav-link">Our Team</a></li>
            <li class="nav-item <?php echo (getConfigParam('page') == "contact" ? "active" : "")?>"><a href="/contact" class="nav-link">Contact Us</a></li>
            <?php if(isLoggedIn()): ?>
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:22px;"><span class="icon icon-user"></span></a>
              <div class="dropdown-menu" aria-labelledby="dropdown04">
                <a class="dropdown-item" href="/favourites">Favourites</a>
                <a class="dropdown-item" href="/recommendations">Recommendations</a>
                <a class="dropdown-item" href="/logout">Logout</a>
              </div>
            </li>
            <?php else: ?>
              <li class="nav-item"><a href="<?php echo $client->createAuthUrl() ?>" class="nav-link">Login</a></li>
            <?php endif; ?>
	        </ul>
	      </div>
		  </div>
	  </nav>