<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(isset($_GET['artid']) AND !empty($_GET['artid'])){
	$id_article = intval($_GET['artid']);
	$sql = "SELECT * FROM articles_intro_conclu 
			LEFT JOIN membres ON membres.id_m = articles_intro_conclu.id_membre 
			LEFT JOIN autorisation_globale ON membres.id_group = autorisation_globale.id_group 
			LEFT JOIN enligne ON enligne.id_m_join = articles_intro_conclu.id_membre
			WHERE id_article = '$id_article'";
	$result = $db->requete($sql);
	if($db->num($result) > 0){
		$row = $db->fetch($result);
		if($row['article_status'] == 1){
			$data = get_file(TPL_ROOT.'lecture_topo.tpl');
			$sql = "SELECT * FROM articles T1 LEFT JOIN articles T2 ON (T2.BD = '$row[id_cat]') WHERE T1.BG <= T2.BG AND T1.BD >= T2.BD AND T1.level < T2.level ORDER BY T1.level ASC";
			$result = $db->requete($sql);
			while($niveaux = $db->fetch($result)){
				$final = '<a  href="categories-des-articles-'.$niveaux['BG'].'.html">'.$niveaux['label'].'</a>';
				$data = parse_boucle('NIVEAUX',$data,false,array('adresse'=>'<a href="categories-des-articles-'.$niveaux[0].'.html">'.$niveaux[2].'</a>'));
			}
			$data = parse_boucle('NIVEAUX',$data,TRUE);
			include(INC_ROOT.'header.php');
			$sql = "SELECT * FROM articles_part WHERE id_article_attach = '$id_article' ORDER BY num ASC";
			$result = $db->requete($sql);
			$listing = array();
			while($row2 = $db->fetch($result)){
				$listing[$row2['num']]['texte'] = $row2['texte_part_parse'];
				$listing[$row2['num']]['titre'] = $row2['titre_part'];
				$data = parse_boucle('PARTIE',$data,FALSE,array('titre'=>$row2['titre_part'],'num'=>$row2['num'],'id_article'=>$id_article,'titre_url'=>title2url($row['titre'])));
			}
			$data = parse_boucle('PARTIE',$data,TRUE);
			if(isset($_GET['page']) AND ($_GET['page'] >= 1 AND $_GET['page'] <= $db->num($result)))
				$page = intval($_GET['page']);
			else
				$page = 1;
			if($page == 1){
				if($db->num($result) > 1)
					$data = parse_var($data,array('intro'=>stripslashes($row['intro_parse']).'<hr />','conclu'=>'','next'=>'<a class="button" href="article-'.title2url($row['titre']).'-a'.$id_article.'-p2.html">Suiv >></a>','prev'=>''));
				else
					$data = parse_var($data,array('intro'=>stripslashes($row['intro_parse']).'<hr />','conclu'=>'<hr />'.stripslashes($row['conclu_parse']),'next'=>'','prev'=>''));
			}
			elseif($page == $db->num($result)){
				$prev = $page - 1;
				$data = parse_var($data,array('intro'=>'','conclu'=>'<hr />'.stripslashes($row['conclu_parse']),'prev'=>'<a class="button" href="article-'.title2url($row['titre']).'-a'.$id_article.'-p'.$prev.'.html"><< Pr&eacute;c</a>','next'=>''));
			}
			else{
				$prev = $page - 1;
				$next = $page + 1;
				$data = parse_var($data,array('intro'=>'','conclu'=>'','prev'=>'<a class="button" href="article-'.title2url($row['titre']).'-a'.$id_article.'-p'.$prev.'.html"><< Pr&eacute;c</a>','next'=>'<a class="button" href="article-'.title2url($row['titre']).'-a'.$id_article.'-p'.$next.'.html">Suiv >></a>'));
			}
			if($row['artOfficiel'] == 1){
				$meg = '';
			}else{
				$meg = '';/*'<span class="miseengarde">' .
						'			Vous vous apprêtez à lire un article rédigé par un membre de ce site.
									Nous ne pouvons pas garantir la véracité du contenu.
						</span>';*/
			}
			if($row['avatar'] != '')
				$avatar = '<img src="'.$row['avatar'].'" class="emplacement_avatar" alt="avatar" />';
			else
				$avatar = '';
			if(isset($row['id_m_join']) AND $row['invisible'] == 0)
				$online = 'online';
			else	
				$online = 'offline';
			$data = parse_var($data,array(
				'avatar'=>$avatar,
				'enligne'=>$online,
				'pseudo'=>$row['pseudo'],
				'mid'=>$row['id_m'],
				'date-creation'=>get_date($row['date_article'],$_SESSION['style_date']),
				'MEG'=>$meg,
				'titre_part'=>'<h1>'.$listing[$page]['titre'].'</h1>',
				'texte_part'=>stripslashes($listing[$page]['texte']),
				'design'=>$_SESSION['design'],
				'titre_page'=> $row['titre'].' - '.SITE_TITLE,
				'nb_requetes'=>$db->requetes,
				'titre_article'=>$row['titre'],
				'ROOT'=>ROOT,
				'final'=>$final,
				'url_partage'=>$config['domaine'].$_SERVER['REQUEST_URI']));
		}
		else{
			$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
			$auth = $db->fetch($db->requete($sql));
			if($_SESSION['mid'] == $row['id_membre'] OR $auth['administrateur_article'] == 1){
				$data = get_file(TPL_ROOT.'lecture_topo.tpl');
				$data = parse_boucle('NIVEAUX',$data,TRUE);
				include(INC_ROOT.'header.php');
				$sql = "SELECT * FROM articles_part WHERE id_article_attach = '$id_article' ORDER BY num ASC";
				$result = $db->requete($sql);
				$listing = array();
				while($row2 = $db->fetch($result)){
					$listing[$row2['num']]['titre'] = $row2['titre_part'];
					$listing[$row2['num']]['texte'] = $row2['texte_part_parse'];
					$data = parse_boucle('PARTIE',$data,FALSE,array('titre'=>$row2['titre_part'],'num'=>$row2['num'],'id_article'=>$id_article,'titre_url'=>title2url($row['titre'])));
				}
				$data = parse_boucle('PARTIE',$data,TRUE);
				if(isset($_GET['page']) AND ($_GET['page'] >= 1 AND $_GET['page'] <= $db->num($result)))
					$page = intval($_GET['page']);
				else
					$page = 1;
				if($page == 1){
					if($db->num($result) > 1)
						$data = parse_var($data,array('intro'=>stripslashes($row['intro_parse']).'<hr />','conclu'=>'','next'=>'<a class="button" href="article-'.title2url($row['titre']).'-a'.$id_article.'-p2.html">Suiv >></a>','prev'=>''));
					else
						$data = parse_var($data,array('intro'=>stripslashes($row['intro_parse']).'<hr />','conclu'=>'<hr />'.stripslashes($row['conclu_parse']),'next'=>'','prev'=>''));
				}
				elseif($page == $db->num($result)){
					$prev = $page - 1;
					$data = parse_var($data,array('intro'=>'','conclu'=>stripslashes($row['conclu_parse']),'prev'=>'<a class="button" href="article-'.title2url($row['titre']).'-a'.$id_article.'-p'.$prev.'.html"><< Pr&eacute;c</a>','next'=>''));
				}
				else{
					$prev = $page - 1;
					$next = $page + 1;
					$data = parse_var($data,array('intro'=>'','conclu'=>'','prev'=>'<a class="button" href="article-'.title2url($row['titre']).'-a'.$id_article.'-p'.$prev.'.html"><< Pr&eacute;c</a> ','next'=>'<a class="button" href="article-'.title2url($row['titre']).'-a'.$id_article.'-p'.$next.'.html">Suiv >></a>'));
				}
				if($row['artOfficiel'] == 1){
					$meg = '';
				}else{
					$meg = '<span class="miseengarde">Vous vous apprêtez à lire un article rédigé par un membre de ce site. Nous ne pouvons pas garantir la véracité du contenu.</span>';
				}
				if($row['avatar'] != '')
					$avatar = '<img src="'.$row['avatar'].'" class="emplacement_avatar" alt="avatar" />';
				else
					$avatar = '';
							if(isset($row['id_m_join']) AND $row['invisible'] == 0)
					$online = 'online';
				else	
					$online = 'offline';
				$data = parse_var($data,array(
					'avatar'=>$avatar,
					'enligne'=>$online,
					'pseudo'=>$row['pseudo'],
					'mid'=>$row['id_m'],
					'date-creation'=>get_date($row['date_article'],
					$_SESSION['style_date']),
					'MEG'=>$meg,'titre_part'=>'<h1>'.$listing[$page]['titre'].'</h1>','texte_part'=>stripslashes($listing[$page]['texte']),
					'design'=>$_SESSION['design'],
					'titre_page'=> $row['titre'].' - '.SITE_TITLE,
					'nb_requetes'=>$db->requetes,
					'final'=>'<a href="#">Articles non validés</a>','titre_article'=>$row['titre'],
					'ROOT'=>'',
					'url_partage'=>$config['domaine'].$_SERVER['REQUEST_URI']));
			}
			else{
				$data = display_notice('Vous ne pouvez pas lire cet article.','important','index.html');
			}
		}
	}
	else{
		$data = display_notice('Cet article n\'existe pas','important','index.html');
	}
}
else{
	header("location:index.html");
}
echo $data;
$db->deconnection();
?>
