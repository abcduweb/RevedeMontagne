<?php
function auto_log()
{
	global $db;
	if(!isset($_SESSION['ses_id']) AND isset($_COOKIE['ses_id']))
	{
		if(!preg_match('`index.php`',$_SERVER['REQUEST_URI'])){
			$_SESSION['auto_log_request_page'] = $_SERVER['REQUEST_URI'];
			header('location:index.php');
		}
		$sql = "SELECT pseudo,id_m,id_group,design,ordre,ses_id,ses_key,nb_sujet_afficher,nombre_message_afficher,nb_news_page,redirection,style_date,uniqid FROM membres LEFT JOIN enligne ON enligne.id_m_join = membres.id_m WHERE ses_id = '".$db->escape($_COOKIE['ses_id'])."'";
		$result = $db->requete($sql);
		$num = $db->num($result);
		$vsess = $db->fetch_assoc($result);
		$key = md5($vsess['pseudo'].$vsess['id_m'].$vsess['ses_key']);
		if($num > 0 AND $key == $_COOKIE['ses_id'])
		{
			if($vsess['id_group'] != '7'){
				$_SESSION['membre'] = $vsess['pseudo'];
				$_SESSION['mid'] = $vsess['id_m'];
				$_SESSION['group'] = $vsess['id_group'];
				$_SESSION['design'] = $vsess['design'];
				$_SESSION['order'] = $vsess['ordre'];
				$_SESSION['ses_id'] = $vsess['ses_id'];
				$_SESSION['nombre_sujet'] = $vsess['nb_sujet_afficher'];
				$_SESSION['nombre_message'] = $vsess['nombre_message_afficher'];
				$_SESSION['nombre_news'] = $vsess['nb_news_page'];
				$_SESSION['redirection'] = $vsess['redirection'];
				$_SESSION['style_date'] = $vsess['style_date'];
				if($vsess['uniqid'] != '')$db->requete("DELETE FROM enligne WHERE id_m_join = '".$vsess['id_m']."'");
				$db->requete('UPDATE membres SET last_log= UNIX_TIMESTAMP(),ip = \''.get_ip().'\' WHERE id_m = "'.$_SESSION['mid'].'"');
			}
			purge(ROOT.'caches/','.htcache_mpm_*');
		}
		else
		{
			$_SESSION['mid'] = 0;
			$_SESSION['group'] = 6;
			$_SESSION['design'] = '1';
			$_SESSION['order'] = 'ASC';
			$_SESSION['nombre_sujet'] = 50;
			$_SESSION['nombre_message'] = 50;
			$_SESSION['nombre_news'] = 30;
			$_SESSION['redirection'] = 5;
			$_SESSION['style_date'] = 'd-m-Y H:i:s';
			setcookie('ses_id',1,time()-3600,'/');
		}
		if(isset($_SESSION['auto_log_request_page'])) header("location:".$_SESSION['auto_log_request_page']);
	}
	else if(!isset($_SESSION['ses_id']))
	{
		$_SESSION['mid'] = 0;
		$_SESSION['group'] = 6;
		$_SESSION['design'] = '1';
		$_SESSION['order'] = 'ASC';
		$_SESSION['nombre_sujet'] = 50;
		$_SESSION['nombre_message'] = 50;
		$_SESSION['nombre_news'] = 30;
		$_SESSION['style_date'] = 'd-m-Y H:i:s';
	}
}

function log_out()
{
	session_unset();
	session_destroy();
	setcookie('ses_id',1,time()-3600,'/');
}
?>