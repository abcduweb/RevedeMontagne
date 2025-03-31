<?php
include(ROOT.'caches/.htcache_userOL');

function delete_online($time){
	global $db;
	$sql = "DELETE FROM enligne WHERE timer <= ".$time."";
	$db->requete($sql);
}

$current_time = time();
$five_minutes_time = $current_time - 5 * 60;
$backup_sql = array();


if(isset($_SESSION['updateOnligne']['last']) AND $_SESSION['updateOnligne']['last'] < $five_minutes_time){
	delete_online($five_minutes_time);
	if(isset($_SESSION['mid']) AND $_SESSION['mid'] != 0)
		$sql = "INSERT INTO enligne (id_m_join, timer, ip, invisible, uniqid) VALUES($_SESSION[mid],'".$current_time."','".get_ip()."',0,'".$_SESSION['updateOnligne']['id']."')";
	else
		$sql = "INSERT INTO enligne (id_m_join, timer, ip, invisible, uniqid) VALUES('0','".$current_time."','".get_ip()."','0','".$_SESSION['updateOnligne']['id']."')";
	$db->requete($sql);
	$backup_sql[] = $sql.'1';
	$nb_user_online = $db->num($db->requete($sql = "SELECT * FROM enligne"));
	write_cache(ROOT.'caches/.htcache_userOL',array('nb_user_online'=>$nb_user_online));
	$_SESSION['updateOnligne']['last'] = $current_time;
}
elseif(!isset($_SESSION['ses_id']) AND !isset($_SESSION['updateOnligne'])){
	$sql = "SELECT * FROM enligne WHERE ip = '".get_ip()."' AND uniqid = ''";
	$db->requete($sql);
	if($db->num() == 0){
		delete_online($five_minutes_time);
		$_SESSION['updateOnligne']['id'] = uniqid(mt_rand(),true);
		$_SESSION['updateOnligne']['last'] = $current_time;
		$sql = "INSERT INTO enligne (id_m_join, timer, ip, invisible, uniqid) VALUES('0','".$_SESSION['updateOnligne']['last']."','".get_ip()."','0','')";
		$db->requete($sql);
		$backup_sql[] = $sql.'2';
		$nb_user_online = $db->num($db->requete($sql = "SELECT * FROM enligne"));
		write_cache(ROOT.'caches/.htcache_userOL',array('nb_user_online'=>$nb_user_online));
		$_SESSION['updateMe'] = $_SESSION['updateOnligne']['last'];
	}
}
elseif(isset($_SESSION['ses_id']) AND !isset($_SESSION['updateOnligne'])){
	$_SESSION['updateOnligne']['id'] = uniqid(mt_rand(),true);
	delete_online($five_minutes_time);
	if(isset($_SESSION['mid']) AND $_SESSION['mid'] != 0)
		$sql = "UPDATE enligne SET timer = '".$current_time."' , uniqid = '".$_SESSION['updateOnligne']['id']."'  WHERE id_m_join = '$_SESSION[mid]'";
	else
		$sql = "INSERT INTO enligne (id_m_join, timer, ip, invisible, uniqid) VALUES($_SESSION[mid],'".$current_time."','".get_ip()."',0,'".$_SESSION['updateOnligne']['id']."')";
	$backup_sql[] = $sql.'3';
	$db->requete($sql);
	$_SESSION['updateOnligne']['last'] = $current_time;
	$nb_user_online = $db->num($db->requete($sql = "SELECT * FROM enligne"));
	write_cache(ROOT.'caches/.htcache_userOL',array('nb_user_online'=>$nb_user_online));
}
else if(!is_cache(ROOT.'caches/.htcache_userOL',300)){
	delete_online($five_minutes_time);
	if(isset($_SESSION['mid']) AND $_SESSION['mid'] != 0){
		$sql = "UPDATE enligne SET id_m_join = '$_SESSION[mid]', timer = '".$current_time."' WHERE uniqid = '".$_SESSION['updateOnligne']['id']."'";
	}
	else{
		if(isset($_SESSION['updateOnligne']['id'])){
			$sql = "UPDATE enligne SET timer = '".$current_time."' WHERE uniqid = '".$_SESSION['updateOnligne']['id']."'";
		}
		else{
			$sql = "SELECT * FROM enligne WHERE ip = '".get_ip()."' AND uniqid = ''";
			$db->requete();
			if($db->num() > 0){
				$sql = "UPDATE enligne SET timer = '".$current_time."' WHERE ip = '".get_ip()."' AND uniqid = ''";
			}
			else
				$sql = "INSERT INTO enligne (id_m_join, timer, ip, invisible, uniqid) VALUES('0','".$current_time."','".get_ip()."','0','')";
		}
	}
	$db->requete($sql);
	$backup_sql[] = $sql.'4';
	$nb_user_online = $db->num($db->requete($sql = "SELECT * FROM enligne"));
	write_cache(ROOT.'caches/.htcache_userOL',array('nb_user_online'=>$nb_user_online));
	$_SESSION['updateOnligne']['last'] = $current_time;
}elseif(isset($_SESSION['updateMe'])){
	$sql = "UPDATE enligne SET uniqid = '".$_SESSION['updateOnligne']['id']."' WHERE ip = '".get_ip()."' AND timer = '$_SESSION[updateMe]'";
	$backup_sql[] = $sql.'5';
	$db->requete($sql);
	unset($_SESSION['updateMe']);
}
if(count($backup_sql) > 0){
	$open = @fopen('caches/.ht_sql_online','a');
	@fwrite($open,'\n'.var_export($backup_sql,TRUE));
	@fclose($open);
}
?>
