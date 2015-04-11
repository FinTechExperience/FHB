<?php
session_start();
// added in v4.0.0
require_once 'autoload.php';
require_once 'dbconfig.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

$hash =  rand(1000,9999);

// init app with app id and secret
FacebookSession::setDefaultApplication( '341311466063931','50b25d09ed5241a5dd20530bdbae1156' );
// login helper with redirect_uri
    $helper = new FacebookRedirectLoginHelper('http://local.host.com/FHB/fbconfig.php' );
try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
      checkuser($fbid,$fbfullname,$femail,$hash);

    /* ---- header location after session ----*/
  header("Location: index.php");
} else {
  $loginUrl = $helper->getLoginUrl();
 header("Location: ".$loginUrl);
}


function checkuser($fuid,$ffname,$femail,$h){
      $check = mysqli_query($link,"select * from users where FBID='$fuid'");
    if (empty($check)) { // if new user . Insert a new record
  $query = "INSERT INTO users (FBID,Nombre,Correo,clavecel) VALUES ('$fuid','$ffname','$femail','$h')";
  mysqli_query($link,$query);
  } else {   // If Returned user . update the user record
  $query = "UPDATE users SET Nombre='$ffname', Correo='$femail' where FBID='$fuid'";
  mysqli_query($link, $query);
  }

}



?>
