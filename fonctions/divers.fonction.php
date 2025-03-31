<?php
function upload($index,$destination,$name,$maxsize=FALSE,$max_width=FALSE,$max_height=FALSE)
{
	$valide_mime = array('image/png','image/jpeg','image/jpg','image/gif','image/JPG','image/JPEG');
	$extention = array('image/png'=>".png",'image/jpeg'=>".jpeg","image/jpg"=>".jpg",'image/gif'=>'.gif','image/JPG'=>'jpg','image/JPEG'=>'.jpeg');
	$dim = getimagesize($_FILES[$index]['tmp_name']);
    if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0)
		$retour = array('message'=>'Erreur pendant l\'upload','type'=>'important');
	elseif(!is_dir($destination))
		$retour = array('message'=>'Le r&eacute;pertoire de destionation n\'existe pas'.$destination,'type'=>'important');
    elseif ($maxsize !== FALSE AND filesize($_FILES[$index]['tmp_name']) > $maxsize)
		$retour = array('message'=>'Le fichier d&eacute;passe la taille autoris&eacute;e ('.$maxsize.'Octets)','type'=>'important');
    elseif (!in_array($dim['mime'],$valide_mime)) 
		$retour = array('message'=>'Ce type de fichier n\'est pas autoris&eacute;','type'=>'important');
	elseif(($max_width !== FALSE AND $max_height !== FALSE) AND ($max_width < $dim[0] AND $max_height = $dim[1]))
		$retour = array('message'=>'L\'image est trop grande ('.$max_width.' par '.$max_height.'px max)','type'=>'important');
	if(file_exists($destination.$name) and !isset($retour)) unlink($destination.$name);
    if(move_uploaded_file($_FILES[$index]['tmp_name'],$destination.$name) and !isset($retour))$retour = array('message'=>'Votre '.$index.' a bien &eacute;t&eacute; upload&eacute;','type'=>'ok');
	return $retour;
}
function uploadgpx($index,$destination,$name,$maxsize=FALSE,$max_width=FALSE,$max_height=FALSE)
{
	$valide_mime = array('text/xml','text/xml');
	$extention = array('GPXapplication/octet-stream', 'gpxapplication/octet-stream');
	$ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
			 
	$dim = getimagesize($_FILES[$index]['tmp_name']);
    if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0)
		$retour = array('message'=>'Erreur pendant l\'upload','type'=>'important');
	elseif(!is_dir($destination))
		$retour = array('message'=>'Le r&eacute;pertoire de destionation n\'existe pas','type'=>'important');
    elseif ($maxsize !== FALSE AND filesize($_FILES[$index]['tmp_name']) > $maxsize)
		$retour = array('message'=>'Le fichier d&eacute;passe la taille autoris&eacute;e ('.$maxsize.'Octets)','type'=>'important');

    elseif ($extensions !== FALSE AND !in_array($ext,$extensions));	
		$retour = array('message'=>'Ce type de fichier n\'est pas autoris&eacute;'.$ext,'type'=>'important');
   /* elseif (!in_array($dim['mime'],$valide_mime)) 
		$retour = array('message'=>'Ce type de fichier n\'est pas autoris&eacute;'.$dim['mime'].'eee','type'=>'important');*/
	/*elseif(($max_width !== FALSE AND $max_height !== FALSE) AND ($max_width < $dim[0] AND $max_height = $dim[1]))
		$retour = array('message'=>'L\'image est trop grande ('.$max_width.' par '.$max_height.'px max)','type'=>'important');*/
	if(file_exists($destination.$name) and !isset($retour)) unlink($destination.$name);
    if(move_uploaded_file($_FILES[$index]['tmp_name'],$destination.$name) and !isset($retour))$retour = array('message'=>'Votre '.$index.' a bien &eacute;t&eacute; upload&eacute;','type'=>'ok');
	return $retour;
}

function password($long=8)
{
        $passe = '';
        shuffle($tab=array_merge(range('a','z'), range('A','Z'), range('0','9')));
        $tab_passe=array_rand($tab,$long);
        foreach($tab_passe as $val){
            $passe.=$tab[$val];
        }
        echo $passe;
}

function develop($input_array,$start,$index){
	$out = '<option value="'.$start['BD'].'|'.$start['level'].'">|-';
	for($i=0;$i<$index;$i++) $out .= "--";
	$out .= '&gt;'.$start['label'].'</option>';
	if(isset($start['s_cat'])){
		foreach($start['s_cat'] as $key => $vars){
			if(isset($input_array[$vars['BD']])){
				$next = $index + 1;
				$out .= develop($input_array,$input_array[$vars['BD']],$next);
			}
			else{
				$out .= '<option value='.$vars['BD'].'|'.$vars['level'].'">|-';
				for($i=0;$i<$index + 1;$i++) $out .= "--";
				$out .= '&gt;'.$vars['label'].'</option>';
			}
		}
	}
	return $out;
}

function develop_back($input_array,$start,$limite){
	$out = $start['label'].' &gt; ';
	if(isset($start['s_cat'])){
		foreach($start['s_cat'] as $key => $vars){
			if($limite['BD'] <= $vars['BD'] AND $limite['BG'] >= $vars['BG']){
				if(isset($input_array[$vars['BD']])){
					$out .= develop_back($input_array,$input_array[$vars['BD']],$limite);
				}
				else{
					$out .= $vars['label'].' &gt; ';
				}
			}
		}
	}
	return $out;
}
   
function readFeedDom ( $url, $objets ) {

    $dom = new DOMDocument();

       if ( @!$dom -> load ( $url ) ) {
          return false;
       }
                           
       // root node product
       $itemList = $dom->getElementsByTagName('trk');

       foreach ( $itemList as $item ) {
                               
          foreach ( $objets as $objet ) { //-- On boucle pour automatiser les r&eacute;cup&eacute;ration des balises en fonction du tableau

             $resultat[$objet] = $item -> getElementsByTagName ( $objet );

             if ( $resultat[$objet] -> length > 0 ) {}
                else {
                   return false;
                   break;
                }

          }

          return true;

       }

    }

function enlevecode ($origine)
{
	/*$texte_a_garder = preg_replace("/<a href(.*?)<\/a>/si", "", $origine);
	$texte_a_garder = preg_replace("/<img src=\"(.*?)\" alt=\"(.*?)\"\/><\/img>/si", "", $origine);*/
	$texte_a_garder = preg_replace("#<[^>]*>#", "", $origine); 
	return $texte_a_garder;
}	
	
	
	
function recupererDebutTexte ($origine, $titre, $id_news, $longueurAGarder)
{
    if (strlen ($origine) <= $longueurAGarder)
		return $origine;
        
		$debut = substr ($origine, 0, $longueurAGarder);
        $debut = substr ($debut, 0, strrpos ($debut, ' ')) . '<br /><a href="commentaires-de-'.$titre.'-n'.$id_news.'.html#commentaires">Lire la suite...</a>';
	
        return $debut;
}
?>