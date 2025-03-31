<?php
/*################################################################################################################################
Réalisation SAS ABCduWeb
Date de création : 04/04/2024
Date de mise à jour : 03/07/2024
Contact : contact@abcduweb.fr
################################################################################################################################*/

if(!defined('SITE_TITLE'))define('SITE_TITLE',$siteTitle);
$adsense = '';
$popup='';
$popup_script ='';

if (!isset($_SESSION['ses_id'])){
	$connexion = '<li class="menu"><a href="{ROOT}connexion.html">Connexion</a></li>';
	$inscription = '<li  class="menu"><a href="{ROOT}inscription.html">Inscription</a></li>';
	$moncompte = '';
	$admin = '';
	$lien_ajouter_photo = '';
	$popup='';
}
else
{
	$_SESSION['timeout'] = time();
	$lien_ajouter_photo = '<li><a href="{ROOT}ajouter-une-photo.html">Ajouter une photo</a></li>';
	if(!is_cache(ROOT.'caches/.htcache_mpm_'.$_SESSION['mid'],60)){
		$connexion = '';
		$inscription = '';
		$popup = '';
		$popup_script = '';

		$sql = 'SELECT * FROM `messages_discution` LEFT JOIN discutions_lues ON (discutions_lues.id_membre = '.$_SESSION['mid'].' AND discutions_lues. id_discution_l = messages_discution.id_disc AND discutions_lues.`in` = 1) WHERE messages_discution.id_m_disc > discutions_lues.id_dernier_mp_l';
		$result = $db->requete($sql);
		$nb_mp = $db->num($result);
		if($nb_mp > 0)
		{
			if($nb_mp > 1)
				$msg = ' nouveaux messages';
			else
				$msg = ' nouveau message';
			$img_mp = 'messages';
			$popup='<div class="popbox">
					  <div class="dimmer"></div>

					  <div class="modal">
						<div class="outgap">

						  <div class="workarea">
							<div class="close_button">&times;</div>
							<div style="text-align: center;"><a href="'.$config['domaine'].'liste-mp.html"><img src="'.$config['domaine'].'/templates/images/1/MP/popup.png" style="width: 400px; height: 250px;" /></a></div>

							<form>
							  <input type="submit" style="position: absolute; left: -9999px" />

								<h1 style="text-align: center;">'.$nb_mp.$msg.'</h1>
								Pour les consulter rendez-vous dans <a href="'.$config['domaine'].'liste-mp.html">votre boite &agrave; MP</a>

							</form>
							<div style="text-align: center;"><a role="button" href="#" onClick="PopBox.hide(); return false;">Fermer la boite de dialogue</a></div>

							<div class="close_msg" style="text-align: center;">la fenêtre disparaitra dans <b class="close_countdown"></b> seconds.</div>

						  </div>
						</div>
					  </div>
					</div>';
					$popup_script = '
					<script>
					// <![CDATA[
					doInit(function() {
					  if (typeof $=="undefined") return 1;

					  PopBox.init({
						auto_show: 10,         // in milliseconds. 15000 milliseconds = 15 seconds. 0 = disabled.
						auto_close: 60000,        // in milliseconds. 60000 = 60 seconds. 0 = disabled.
						show_on_scroll_start: 48, // starting scroll position in percents, between 0% and 100%. Both 0 = disabled.
						show_on_scroll_end: 52,   // ending scroll position. Eg 40..60 means that popbox will appear when any part of page between 40% and 60% is appeared in the viewport.
						closeable_on_dimmer: true,
						auto_start_disabled: false,
					  });
					}, 1);
					// ]]>
					</script>';
		}
		else
		{
			$img_mp = 'no_message';
			$popup = '';
			$popup_script = '';
		}
		$moncompte='<li>
						<a href="{ROOT}liste-mp.html"><img src="{ROOT}templates/images/'.$_SESSION['design'].'/{img_nb_mp}.gif" alt="{img_nb_mp}"/> {nb_mp} message</a>
					</li>
					<li>
						<a href="{ROOT}deconnexion-'.$_SESSION['mid'].'.html"><img src="'.DOMAINE.'templates/images/1/quitter.png" alt="Quitter" />'.$_SESSION['membre'].'</a>
						<ul>
							<li><a href="{ROOT}contributions.html">Mes contributions</a></li>
							<li><a href="{ROOT}mes_options.html">Mes options</a></li>
							<li><a href="{ROOT}photos.html" onclick="window.open(\'{ROOT}photos.html\',\'\',\'scrollbars=yes,width=500,height=350\');return false">Mes photos</a></li>';
							if(in_array($_SESSION['group'],$team_group_id))
								$admin = $moncompte . '<li><a href="{ROOT}admin.html">Administration</a></li>';
							else
								$admin = $moncompte;
		$moncompte = $moncompte.'
							<li><a href="{ROOT}deconnexion-'.$_SESSION['mid'].'.html">Quitter</a></li>
						</ul>
						
					</li>';


		write_cache(ROOT.'caches/.htcache_mpm_'.$_SESSION['mid'],array('popup_script'=>$popup_script, 'popup'=>$popup, 'connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>ROOT,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
	}
	else{
		include(ROOT.'caches/.htcache_mpm_'.$_SESSION['mid']);
	}
}
if(isset($_SESSION['tmpImg'])){
  $sql = "DELETE FROM images WHERE dir = '".$_SESSION['tmpImg']['dir'][0]."' AND s_dir = '".$_SESSION['tmpImg']['subDir'][0]."' AND tmp = '1' AND id_owner = '$_SESSION[mid]'";
  $db->requete($sql);
  if(isset($_SESSION['SsubDir']['tmp'])){
	foreach($_SESSION['tmpImg']['id'] as $imgId){
		unlink(ROOT.'images/autres/'.ceil($imgId/1000).'/'.$_SESSION['tmpImg']['img'][$imgId]);
		unlink(ROOT.'images/autres/'.ceil($imgId/1000).'/mini/'.$_SESSION['tmpImg']['img'][$imgId]);
	}
	$key = array_keys($_SESSION['SsubDir']['tmp']);
	unset($_SESSION['dir'.$key[0]]);
	unset($_SESSION['SsubDir']);
  }
  unset($_SESSION['tmpImg']);
}
$data = parse_var($data,array('popup_script'=>$popup_script,'popup'=>$popup, 'ajouter_photo'=>$lien_ajouter_photo,'inscription'=>$inscription,'connexion'=>$connexion,'compte'=>$moncompte,'nb_visiteurs'=>$nb_user_online,'DOMAINE'=>DOMAINE));
if(isset($_SESSION['ses_id']))$data = parse_var($data,array('img_nb_mp'=>$img_mp,'nb_mp'=>$nb_mp));

//gestion des stats topos	
$sql = "SELECT
		(SELECT COUNT(*) FROM point_gps LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point WHERE id_type = 9) as nb_sommet,
		(SELECT COUNT(*) FROM point_gps LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point WHERE id_type = 10) as nb_col,
		(SELECT COUNT(*) FROM point_gps LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point WHERE id_type = 14) as nb_lac,
		(SELECT COUNT(*) FROM point_gps LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point WHERE id_type < 9) as nb_abris,
		(SELECT COUNT(*) FROM topos WHERE id_activite = 1) as nb_skis_randos,
		(SELECT COUNT(*) FROM topos WHERE id_activite = 2) as nb_randos
	  ";
$db->requete($sql);


if(!is_cache(ROOT.'caches/.htcache_stats_topo',60))
{
	while($row = $db->fetch())
	{
	$nb_sommet = $row['nb_sommet']; 
	$nb_col = $row['nb_col']; 
	$nb_lac = $row['nb_lac'];
	$nb_abris = $row['nb_abris'];
	$nb_topo_skis_rando = $row['nb_skis_randos'];
	$nb_topo_rando = $row['nb_randos'];
	write_cache(ROOT.'caches/.htcache_stats_topo',array('nb_sommet'=>$row['nb_sommet'], 'nb_col'=>$row['nb_col'], 'nb_lac'=>$row['nb_lac'], 'nb_abris'=>$nb_abris, 'nb_topo_rando'=>$row['nb_randos'], 'nb_topo_skis_rando'=>$row['nb_skis_randos'] ));
	}
	
	
}
else
{
		include(ROOT.'caches/.htcache_stats_topo');
}

$data = parse_var($data,array('nb_sommet'=>$nb_sommet, 'nb_col'=>$nb_col, 'nb_lac'=>$nb_lac, 'nb_abris'=>$nb_abris, 'nb_topo_skis_rando'=>$nb_topo_skis_rando, 'nb_topo_rando'=>$nb_topo_rando));
	


?>