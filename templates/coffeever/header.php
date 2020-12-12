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
  $email =  $google_account_info->email;
  $name =  $google_account_info->name;

  $userObj = [
    "google_id"=> intval(json_encode($body)),
    "name"=> $google_account_info->name,
    "mail"=> $google_account_info->email,
  ];

  $result = makeRequest("login", $userObj, 'POST');
  debugPrint($result);

  $_SESSION['isLoggedIn'] = true;
  $_SESSION['subscriberObj'] = $userObj;

  // now you can use this profile info to create account in your website and make user logged in.
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="webthemez">
<title>Coffeever Homepage</title>

<!-- Bootstrap core CSS -->
<link href="templates/coffeever/assets/css/bootstrap.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="templates/coffeever/assets/css/styles.css" rel="stylesheet">
<link href="templates/coffeever/assets/css/font-awesome.min.css" rel="stylesheet">
<link href="templates/coffeever/assets/css/animate-custom.css" rel="stylesheet"> 
<script src="templates/coffeever/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/coffeever/assets/js/modernizr.custom.js"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --> 
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body data-target="#navbar-main">
<div id="navbar-main"> 
  <!-- Fixed navbar -->
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
	 
      <div class="navbar-header">
	   <div class="pull-left logo">
        <a class="smoothScroll" data-id="#home-section" href="#"><img src="templates/coffeever/assets/img/coffeever-logo.png" /></a>
       </div>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
        </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav pull-right">
          <li class='nav-item'><a data-id="#home-section" href='#' class="smoothScroll">Welcome</a></li>
          <li class='nav-item'> <a data-id="#services" href='#' class="smoothScroll">We Offer</a></li>		  
          <li class='nav-item'> <a data-id="#about" href='#' class="smoothScroll"> Coffeever</a></li>
          <li class='nav-item'> <a data-id="#portfolio" href='#' class="smoothScroll"> We Recommend</a></li>
          <li class='nav-item'> <a data-id="#team" href='#' class="smoothScroll"> Our Team</a></li>
          <li class='nav-item'> <a data-id="#contact" href='#' class="smoothScroll"> Get In Touch</a></li>
        </ul>
      </div>
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>