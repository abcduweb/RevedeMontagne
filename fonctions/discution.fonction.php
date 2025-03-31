<?php
function get_limite_mp($page)
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
function get_liste_page_mp($page,$nb_page,$id_disc,$titre_url)
{
	$list = get_list_page($page,$nb_page);
	$pages = '';
	foreach($list as $liste)
	{
		if($liste != '...' AND $liste != $page)
			$pages .= "<a href=\"mp-$id_disc-p$liste-$titre_url.html\">&#8201;$liste&#8201;</a> ";
		elseif($liste != '...')
			$pages .= '<span class="current">'.$liste.'</span> ';
		else
			$pages .= '<a href="#">&#8201;...&#8201;</a> ';
	}
	return $pages;
}
?>