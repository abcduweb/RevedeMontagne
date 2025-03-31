<?php

/* on inclut le fichier du SDK */
require_once('facebook.php');
 
/* l'id et la clé secrète de votre application sont disponibles sur la page de configuration de celle-ci */
$app_config = array(
'appId' => '455284614585162',
'secret' => '796948e679092f0ae496a03cff409e98',
'cookie' => true
);
/* Pour connaitre l'id de votre page, allez sur celle-ci et regardez son URL : https://www.facebook.com/pages/<;Titre de votre page>/<ID de votre page>  */
$page_config = array(
'page_id' => '557105691031615'
);

$facebook = new Facebook($app_config);
/* on récupère les informations de l'utilisateur connecté à Facebook */
$user = $facebook->getUser();
 
/* si connecté */
if($user){
try{
$accounts = $facebook->api('/me/accounts');
echo '<pre>';
print_r($accounts); /* on affiche les informations retournées */
}
catch (FacebookApiException $e){
error_log($e);
$user = null;
}
}
 
if($user){
$logoutUrl = $facebook->getLogoutUrl();
echo '<a href="'.$logoutUrl.'">Log Out</a>';
}
else{
$login_params = array(
'scope' => 'manage_pages,publish_stream,offline_access' /* paramètres permettant de récupérer le token, offline_access permet d'utiliser le token même si vous n'êtes pas connecté directement (ex. : avec un cron) */
);
$loginUrl = $facebook->getLoginUrl($login_params);
echo '<a href="'.$loginUrl.'">Login</a>';
}
?>