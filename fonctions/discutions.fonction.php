<?php
function get_list_page_d($lien,$page, $nb_page, $nb = 3)
{
	$list = get_list_page($page,$nb_page);
	$pages = '';
	for ($i=1;$i <= $nb_page;$i++)
	{
		if($page != '...' AND $page != $i)
			$pages .= "<a href=\"liste-mp-p$i.html\">&#8201;$i&#8201;</a> ";
		elseif($page != '...')
			$pages .= '<span class="current">&#8201;'.$i.'&#8201;</span> ';
		else
			$pages .= '<a href="#">&#8201;...&#8201;</a> ';
	}
		return $pages;
	/*
	$list_page = '';
	for ($i=1;$i <= $nb_page;$i++)
	{
		if (($i < $nb) OR ($i > $nb_page - $nb) OR (($i < $page + $nb) AND ($i > $page -$nb)))
		$list_page .= '<a href="'.$lien.$i.'.html">'.$i.'</a> ';
		else
		{
			if ($i >= $nb AND $i <= $page - $nb)
			$i = $page - $nb;
			elseif ($i >= $page + $nb AND $i <= $nb_page - $nb)
			$i = $nb_page - $nb;
		$list_page .= '...';
		}
	}
	return $list_page;*/
}

function get_liste_page_mp($nb_reponse,$id_d,$titre_url)
{
	$nombre_de_page = ceil( ($nb_reponse + 1) / $_SESSION['nombre_message']);
	$liste = get_list_page('1',$nombre_de_page);
	$pages = '';
	foreach($liste as $page)
	{
		if($page != '...')
			$pages .= "<a href=\"mp-$id_d-p$page-$titre_url.html\">$page</a> ";
		else
			$pages .= $page;
	}
	return $pages;
}
?>