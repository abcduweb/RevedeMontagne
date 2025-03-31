<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
	$redirection = 'connexion.html';
	$data = display_notice($message,'important',$redirection);
}
else
{
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'"));
	$data = get_file(TPL_ROOT.'admin/liste_photos.tpl');
	if($auth['ajouter_album'] == 1){
		if(isset($_GET['page']))
			$page = intval($_GET['page']);
		else
			$page = 1;
		########################################Calcul des pages#################################
		$nb_message_page = 30;																	 #
		$retour = $db->requete('SELECT id_album FROM pm_photos');						         #
		$nb_enregistrement = $db->num($retour);													 #
		$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);							 #
		if($nombre_de_page < $page)	$page = $nombre_de_page;									 #
		$limite = ($page - 1) * $nb_message_page;												 #
		$liste_page = get_list_page($page,$nombre_de_page);			         #
		$pages = '';
			foreach($liste_page as $page_n){
				if($page_n == $page)
					$pages .= $page_n.' ';
				else
					$pages .= '<a href="liste-photos-p'.$page_n.'.html">'.$page_n.'</a> ';
			}
			$liste_page = $pages;
		##################################################################################
		$sql = "SELECT pm_photos.fichier, pm_photos.titre,
		pm_photos.id_album,pm_album_photos.regroupement,pm_album_photos.nom_categorie
		FROM pm_photos LEFT JOIN pm_album_photos ON pm_album_photos.id_categorie = pm_photos.id_categorie ORDER BY regroupement DESC LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		while($row = $db->fetch($result)){
			$dir = ceil($row['id_album']/1000);
			$data = parse_boucle("IMAGES",$data,false,array("images"=>'./images/album/'.$dir.'/mini/'.$row['fichier'],'regroupement'=>$row['regroupement'],"categorie" => $row['nom_categorie'],'titre_photo'=>$row['titre'],"id"=>$row['id_album']));
		}
		$data = parse_boucle("IMAGES",$data,TRUE);
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Administrations des photos - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
		$redirection = 'index.html';
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>