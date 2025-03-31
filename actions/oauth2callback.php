<?php
require_once ('https://revedemontagne.fr/includes/api/google/Verify.php'); 	
	
$client = new Google_Client(['386872365092-f4j2dvlc021319meg4u6nrtc4shtbg7p.apps.googleusercontent.com' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);
if ($payload) {
  $userid = $payload['sub'];
  //echo $userid.'aa';
  
  
  // If the request specified a Google Workspace domain
  //$domain = $payload['hd'];
} else {
	//echo 'ça ne fonctionne pas';
  // Invalid ID token
}

//https://www.tutos.eu/3654
//https://console.cloud.google.com/apis/

?>