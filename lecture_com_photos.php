<?php
if(!isset($load_tpl)){
	$load_tpl = true;
	########### A METTRE SUR CHAQUE PAGE ############
	session_start();							  # 
	define('ROOT', './');                         #
	define('INC_ROOT', ROOT . 'includes/'); 	  #
	include (INC_ROOT . 'commun.php'); 			  #
	define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
	##########################################
}
if(!empty($_GET['pid'])){
	if($load_tpl){
		$pid = intval($_GET['pid']);
		$sql = "SELECT pm_photos.id_album, pm_photos.titre, pm_photos.id_categorie, pm_album_photos.nom_categorie, 
		autorisation_globale.ajouter_com, pm_photos.fichier FROM pm_photos LEFT JOIN pm_album_photos ON pm_album_photos.id_categorie = pm_photos.id_categorie
		LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]' WHERE id_album = '$pid'";
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
			$num = $db->row($db->requete("SELECT COUNT(*) FROM pm_comphotos WHERE id_photo = '$pid' AND id_com <= $page_com"));
			$page = ceil($num[0] / $_SESSION['nombre_message']);
		}
		
		$nb_par_page = $_SESSION['nombre_message'];
		$limite = ($page - 1) * $nb_par_page;
		
		if(!$load_tpl)
			$msg_order = 'DESC';
		else{
			$msg_order = $_SESSION['order'];
			$sql = "SELECT COUNT(*) FROM pm_comphotos WHERE id_photo = '$pid'";
			$db->requete($sql);
			$nb_enregistrement = $db->row();
			$nombre_de_page = ceil($nb_enregistrement[0] / $nb_par_page);
			if ($nombre_de_page < $page)$page = $nombre_de_page;
			$liste_page = get_list_page($page, $nombre_de_page);
			
			$data = get_file(TPL_ROOT.'lecture_com_photo.tpl');
			if ($page > 1) {
				$nb_message_page++;
				$limite--;
			}
		}
		$sql = "SELECT pm_comphotos.id_com,pm_comphotos.mid AS id_posteur,pm_comphotos.com_date,
		pm_comphotos.com_parser AS texte, pm_comphotos.date_edit, pm_comphotos.attachSign, membres.pseudo,
		membres.signature_parser AS signature, membres.avatar, enligne.id_m_join AS online,
		enligne.invisible, autorisation_globale.img_group, autorisation_globale.nom_group, autorisation_globale.modifier_com, autorisation_globale.supprimer_com
		FROM pm_comphotos LEFT JOIN membres ON membres.id_m = pm_comphotos.mid	LEFT JOIN enligne ON enligne.id_m_join = pm_comphotos.mid 
		LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE id_photo = '$pid' ORDER BY pm_comphotos.com_date $msg_order LIMIT $limite,$nb_par_page";
		$db->requete($sql);
		if($db->num() > 0){
			$ligne = 1;
			while($row = $db->fetch_assoc()){
				if($row['modifier_com'] == 1 OR $_SESSION['mid'] == $row['id_posteur']){
					$editer = '<a href="editer-commentaire-photo-'.$row['id_com'].'.html"><img src="{DOMAINE}/templates/images/{design}/form/edit.png" alt="editer" /></a>';
				}else{
					$editer = '';
				}
				if($row['supprimer_com'] == 1){
					$supprimer = '<a href="actions/supprimer_com_photo.php?m='.$row['id_com'].'"><img src="{DOMAINE}/templates/images/{design}/form/supprimer.png" alt="supprimer" /></a>';
				}else{
					$supprimer = '';
				}
				if($row['online'] != null AND $row['invisible'] == 0){
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
					
				$text = stripslashes($row['texte']);
				if($row['attachSign'] == 1)
					$signature = '<div class="signature_message">'.stripslashes($row['signature']).'</div>';
				else
					$signature = '';
				
				if($row['date_edit'] != null)
					$text = parse_var($text,array('date_edit'=>get_date($row['date_edit'],$_SESSION['style_date'])));
				
				if($page > 1 and !isset($reprise) AND $load_tpl){
					$text = '<div id="reprise">Reprise du message précèdent :</div>'.$text;
					$reprise = true;
				}
				
				$data = parse_boucle('COMM',$data,false,array('ligne'=>$ligne, 'id_com'=>$row['id_com'],'img_rang'=>$img_group,'avatar'=>$avatar,'pseudo'=>'<a href="membres-'.$row['id_posteur'].'-fiche.html">'.$row['pseudo'].'</a>','status'=>$status,'date_com'=>get_date($row['com_date'],$_SESSION['style_date']),'editer'=>$editer,'supprimer'=>$supprimer,'commentaire'=>$text,'signature'=>$signature));
				if($ligne == 1)
					$ligne = 2;
				else
					$ligne = 1;
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
			$size = getimagesize(ROOT.'images/album/'.ceil($info['id_album']/1000).'/'.$info['fichier']);
			if($size[0] > 450 OR $size[1] > 300){
				if($size[0] > $size[1]){
					$x = 450;
					$y = 300;
				}
				elseif($size[0] < $size[1]){
					$x = 200;
					$y = 300;
				}
				else{
					$x = 300;
					$y = 300;
				}
				$facteurx = $x / $size[0];
				$facteury = $y / $size[1];
				if($facteurx <= $facteury)
					$facteury = $facteurx;
				else
					$facteurx = $facteury;
				$size[0] = ceil($size[0] * $facteurx);
				$size[1] = ceil($size[1] * $facteury);
			}
			$data = parse_var($data,array('width'=>$size[0],'height'=>$size[1],'repondre'=>$reponse,'dir'=>ceil($info['id_album']/1000),'photo'=>$info['fichier'],'design'=>$_SESSION['design'], 'titre_page'=> 'Commentaires photo - '.$info['titre'].' - '.SITE_TITLE,'titre_photo'=>$info['titre'],
			'titre_album'=>$info['nom_categorie'],'titre_album_url'=>title2url($info['nom_categorie']),'id_album'=>$info['id_categorie'],'id_photo'=>$info['id_album'],
			'nb_requetes'=>$db->nb_requetes(),'ROOT'=>''));
		}
	}
}else{
	$message = 'Aucune photo de sélectionner.';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
if($load_tpl){
	echo $data;
	$db->deconnection();
}
?>