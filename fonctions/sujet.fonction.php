<?php
function get_limite($page)
{
	$retour = ($page - 1) * $_SESSION['nombre_sujet'];
	return $retour;
}

function get_pagination_topic($nb_reponse,$id_f,$id_t,$titre_url)
{
	$nombre_de_page = ceil( ($nb_reponse + 1) / $_SESSION['nombre_message']);
	$liste = get_list_page('1',$nombre_de_page);
	$pages = '';
	foreach($liste as $page)
	{
		if($page != '...')
			$pages .= "<a href=\"forum-$id_f-$id_t-p$page-$titre_url.html\">&#8201;$page&#8201;</a> ";
		else
			$pages .= '<span class="current">&#8201;'.$page.'&#8201;</span> ';
	}
	return $pages;
}

function get_liste_page_forum($page,$nb_page,$id_f,$titre_url)
{
	$list = get_list_page($page,$nb_page);
	$pages = '';
	foreach($list as $liste)
	{
		if($liste != '...' AND $liste != $page)
			$pages .= "<a href=\"forum-$id_f-p$liste-$titre_url.html\">&#8201;$liste&#8201;</a>";
		else
			$pages .= '<span class="current">&#8201;'.$liste.'&#8201;</span> ';
	}
	return $pages;
}

function get_drapeau($id_m,$last_message_id,$nb_reponse,$post)
{
	if($post == 1)
		$retour = 'post_';
	else
		$retour = '';
	if($id_m > $last_message_id)
	{
		if($nb_reponse > 30)
			$retour .= 'f_hotnew';
		else
			$retour .= 'f_new';
	}
	else
	{
		if($nb_reponse > 30)
			$retour .= 'f_hotnonew';
		else
			$retour .= 'f_nonew';
	}
	return $retour;
}
?>