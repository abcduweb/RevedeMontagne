<?php 
include(INC_ROOT.'admin_rights.php');

$config['site_title'] = "Rêve de Montagne";
$config['lang'] = 'fr';
$config['domaine'] = 'http://www.revedemontagne.com/';
$config['disconnect'] = false;
$config['local'] = false;

if($config['local'] == true)
{
	$sql_serveur = 'localhost';
	$sql_login = 'root';
	$sql_pass = '';
	$sql_bdd = 'revedemontagne2';
	$config['domaine'] = 'http://127.0.0.1/revedemontagne2/';
	if($config['disconnect'] == true)
		{
		$pub1 = 'pub 0';
		$pub2 = 'pub 1';
		$pub3 = 'pub 2';
		}
	else
		{
		$pub1 = '<script type="text/javascript">
				var acpublicite_client = "672558261318355919";
				var acpublicite_type = "2";
				var acpublicite_taille = "468x60";
				var acpublicite_titre = "1B9ED7";
				var acpublicite_texte = "333333";
				var acpublicite_url = "888888";
				var acpublicite_bordure = "54A9F1";
				var acpublicite_background = "FFFFFF";
			</script>
			<script type="text/javascript" src="https://acpublicite.fr/ads.js"></script>';
		$pub2 = '<script type="text/javascript">
				var acpublicite_client = "672558261318355919";
				var acpublicite_type = "2";
				var acpublicite_taille = "160x600";
				var acpublicite_titre = "1B9ED7";
				var acpublicite_texte = "333333";
				var acpublicite_url = "888888";
				var acpublicite_bordure = "54A9F1";
				var acpublicite_background = "FFFFFF";
				</script>
				<script type="text/javascript" src="https://acpublicite.fr/ads.js"></script>';
		$pub3 = '<script type="text/javascript">
				var acpublicite_client = "672558261318355919";
				var acpublicite_type = "0";
				var acpublicite_taille = "250x250";
				var acpublicite_titre = "1B9ED7";
				var acpublicite_texte = "333333";
				var acpublicite_url = "888888";
				var acpublicite_bordure = "54A9F1";
				var acpublicite_background = "FFFFFF";
				</script>
				<script type="text/javascript" src="https://acpublicite.fr/ads.js"></script>';
		}
}
else
{
	$sql_serveur = 'db2333.1and1.fr';
	$sql_login = 'dbo318112651';
	$sql_pass = '19870017';
	$sql_bdd = 'db318112651';
	$config['domaine'] = 'http://dev.revedemontagne.com/';
	$pub1 = '<script type="text/javascript">
				var acpublicite_client = "672558261318355919";
				var acpublicite_type = "2";
				var acpublicite_taille = "468x60";
				var acpublicite_titre = "1B9ED7";
				var acpublicite_texte = "333333";
				var acpublicite_url = "888888";
				var acpublicite_bordure = "54A9F1";
				var acpublicite_background = "FFFFFF";
			</script>
			<script type="text/javascript" src="https://acpublicite.fr/ads.js"></script>';
	$pub2 = '<script type="text/javascript">
				var acpublicite_client = "672558261318355919";
				var acpublicite_type = "2";
				var acpublicite_taille = "160x600";
				var acpublicite_titre = "1B9ED7";
				var acpublicite_texte = "333333";
				var acpublicite_url = "888888";
				var acpublicite_bordure = "54A9F1";
				var acpublicite_background = "FFFFFF";
				</script>
				<script type="text/javascript" src="https://acpublicite.fr/ads.js"></script>';
	$pub3 = '<script type="text/javascript">
			var acpublicite_client = "672558261318355919";
			var acpublicite_type = "0";
			var acpublicite_taille = "250x250";
			var acpublicite_titre = "1B9ED7";
			var acpublicite_texte = "333333";
			var acpublicite_url = "888888";
			var acpublicite_bordure = "54A9F1";
			var acpublicite_background = "FFFFFF";
			</script>
			<script type="text/javascript" src="https://acpublicite.fr/ads.js"></script>';
}
$orient_topo = array('','N','NE','E','SE','S','SW','W','NW','Toutes');
$diff_topo_monte = array('','R', 'F', 'PD-', 'PD', 'PD+', 'AD-', 'AD', 'AD+', 'D-', 'D', 'D+', 'TD-', 'TD', 'TD+');
$diff_topo_ski = array('','1.1', '1.2', '1.3', '2.1', '2.2', '2.3', '3.1', '3.2', '3.3', '4.1', '4.2', '4.3', '5.1', '5.2', '5.3', '5.4', '5.5', '5.6');
$expo = array('', '1', '2', '3', '4');
$nb_jours = array('', '0,5', '1', '2', '3', '4', '5', '6', '+6');
$js = array('','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$ms = array('','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Décembre');
$ae = array('','2012','2013');
?>
