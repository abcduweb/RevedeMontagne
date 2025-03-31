<?php
function get_limite($page)
{
	global $config;
	if($page == 1)
	{
		$retour = ($page - 1) * $_SESSION['nombre_message'];
	}
	else
	{
		$retour = ($page - 1) * $_SESSION['nombre_message'];
		$retour = $retour - 1;
	}
	return $retour;
}
function get_liste_page_message($page,$nb_page,$id_f,$id_t,$titre_url)
{
	$list = get_list_page($page,$nb_page);
	$pages = '';
	foreach($list as $liste)
	{
		if($liste != '...' AND $liste != $page)
			$pages .= "<a href=\"forum-$id_f-$id_t-p$liste-$titre_url.html\">&#8201;$liste&#8201;</a> ";
		else
			$pages .= '<span class="current">&#8201;'.$liste.'&#8201;</span> ';
	}
	return $pages;
}
?>