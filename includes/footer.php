<?php
/*
###################################################################################################################
Fichier footer du site internet permettant de regrouper les variables communes à déclencher en bas de chaques pages
Développement réalisé par l'agence ABCduWeb pour le compte du site internet RêvedeMontagne
Mise à jour : 21/09/2023
###################################################################################################################
*/

$data = parse_var($data,array(
	'og_facebook_image' => $config['og_facebook_image'],  
	'og_facebook_image_alt' => $config['og_facebook_image_alt'],
	'og_facebook_width' =>$config['og_facebook_width'],
	'og_facebook_height' => $config['og_facebook_height'],
	'og_facebook_description' => $config['og_facebook_description'],
	'og_facebook_url' => $config['og_facebook_url'],
	'og_facebook_title' => $config['og_facebook_title']
	));
