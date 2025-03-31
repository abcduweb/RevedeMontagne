<?php
if(!isset($load_tpl)){
	$load_tpl = true;
	########### A METTRE SUR CHAQUE PAGE ############
	session_start();							  # 
	define('ROOT', '../');                         #
	define('INC_ROOT', ROOT . 'includes/'); 	  #
	include (INC_ROOT . 'commun.php'); 			  #
	define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
	##########################################
}
if(!empty($_GET['pid'])){
	if($load_tpl){
		$pid = intval($_GET['pid']);
		$sql = "SELECT * FROM c_refuge 
								LEFT JOIN c_type_refuge ON c_type_refuge.id_type = c_refuge.type_refuge
								LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
								WHERE id_album = '$pid'";
		$db->requete($sql);
		$num = $db->num();
		$info = $db->fetch_assoc();
		
	}else{
		$num = 1;
	}
	
	if($num > 0){
		if(isset($_GET['page']))
			$page = intval($_GET['page']);
		else
			$page = 1;
			
		if(isset($_GET['id_msg']) and !empty($_GET['id_msg'])){
			$page_com = intval($_GET['id_msg']);
			$num = $db->row($db->requete("SELECT COUNT(*) FROM com_point WHERE id_point = '$pid' AND id_com <= $page_com"));
			$page = ceil($num[0] / $_SESSION['nombre_message']);
		}
		
		$nb_par_page = $_SESSION['nombre_message'];
		$limite = ($page - 1) * $nb_par_page;
		
		if(!$load_tpl)
			$msg_order = 'DESC';
		else{
			$msg_order = $_SESSION['order'];
			$sql = "SELECT COUNT(*) FROM com_point WHERE id_point = '$pid'";
			$db->requete($sql);
			$nb_enregistrement = $db->row();
			$nombre_de_page = ceil($nb_enregistrement[0] / $nb_par_page);
			if ($nombre_de_page < $page)$page = $nombre_de_page;
			$liste_page = get_list_page($page, $nombre_de_page);
			
			$data = get_file(TPL_ROOT.'refuge/lecture_com_refuge.tpl');
			if ($page > 1) {
				$nb_message_page++;
				$limite--;
			}
		}
		$sql = "SELECT * FROM com_point 
					LEFT JOIN membres ON membres.id_m = com_point.id_m
					LEFT JOIN enligne ON enligne.id_m_join = com_point.id_m
					LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group
					WHERE id_point = '".$pid."' ORDER BY date_ajout $msg_order LIMIT $limite,$nb_par_page";
		$db->requete($sql);
		if($db->num() > 0){
			while($row = $db->fetch_assoc()){
				if($row['modifier_com'] == 1 OR $_SESSION['mid'] == $row['id_m']){
					$editer = '<a href="editer-commentaire-photo-'.$row['id_com'].'.html"><img src="'.DOMAINE.'/templates/images/{design}/form/edit.png" alt="editer" /></a>';
				}else{
					$editer = '';
				}
				if($row['supprimer_com'] == 1){
					$supprimer = '<a href="actions/supprimer_com_photo.php?m='.$row['id_com'].'"><img src="'.DOMAINE.'/templates/images/{design}/form/supprimer.png" alt="supprimer" /></a>';
				}else{
					$supprimer = '';
				}
				if($row['id_m_join'] != null AND $row['invisible'] == 0){
					$status = 'online';
				}else{
					$status = 'offline';
				}
				if($row['avatar'] != "")
					$avatar= '<img src="'.$row['avatar'].'" alt="avatar de '.$row['pseudo'].'" />';
				else
					$avatar = '';
				if($row['img_group'] != '')
					$img_group = '<img src="{DOMAINE}/templates/images/{design}/grade/'.$row['img_group'].'" alt="'.$row['nom_group'].'" />';
				else
					$img_group = $row['nom_group'];
					
				$text = stripslashes($row['commentaire_parser']);
				if($row['attachSign'] == 1)
					$signature = '<div class="signature_message">'.stripslashes($row['signature']).'</div>';
				else
					$signature = '';
				
				if($row['date_edit'] != null)
					$text = parse_var($text,array('date_edit'=>$row['date_edit']));
				
				if($page > 1 and !isset($reprise) AND $load_tpl){
					$text = '<div id="reprise">Reprise du message précèdent :</div>'.$text;
					$reprise = true;
				}
				
				$data = parse_boucle('COMM',$data,false,array('id_com'=>$row['id_com'],'img_rang'=>$img_group,'avatar'=>$avatar,'pseudo'=>'<a href="membres-'.$row['id_m'].'-fiche.html">'.$row['pseudo'].'</a>','status'=>$status,'date_com'=>$row['date_ajout'],'editer'=>$editer,'supprimer'=>$supprimer,'commentaire'=>$text,'signature'=>$signature));
			}
			$data = parse_boucle('COMM',$data,true);
			if(isset($info) AND $info['ajouter_com'] == 1)
				$reponse = '<a href="ajouter-commentaire-{id_photo}-photo.html">Ajouter commentaire</a>';
			else
				$reponse = '';
			if($load_tpl){
				foreach($liste_page as $page_n){
					if($page_n == $page)
						$page_s = $page.' ';
					else
						$page_s = '<a href="commentaires-de-' . title2url($news['titre']) . '-n' . $id_news . '-p'.$page_n.'.html">'.$page_n.'</a> ';
					$data = parse_boucle('PAGES',$data,FALSE,array('page'=>$page_s));
				}
				$data = parse_boucle('PAGES',$data,TRUE);
			}
		}else{
			$data = get_file(TPL_ROOT.'lecture_com_photo_empty.tpl');
			if($info['ajouter_com'] == 1)
				$reponse = '<a href="ajouter-commentaire-{id_photo}-photo.html">Soyez le premier à rédiger un commentaire</a>';
			else
				$reponse = 'Pour ajouter un commentaire vous devez être enregistrer.<br />
				<a href="connexion.html">Connexion</a> <a href="inscription.html">Inscription</a>';
		}
		if($load_tpl){
			include(INC_ROOT.'header.php');

			$data = parse_var($data,array('design'=>$_SESSION['design'], 'repondre'=>$reponse, 'design'=>$_SESSION['design'], 'titre_page'=> 'Commentaires photo - '.$info['titre'].' - '.SITE_TITLE,'titre_photo'=>$info['titre'],
			'titre_album'=>$info['nom_categorie'],'titre_album_url'=>title2url($info['nom_categorie']),'id_album'=>$info['id_categorie'],
			'nb_requetes'=>$db->nb_requetes(),'ROOT'=>''));
		}
	}
}else{
	$message = 'Aucun refuge de sélectionner.';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
if($load_tpl){
	echo $data;
	$db->deconnection();
}
?>