<?php
/**
 * Ensemble de fonctions servant à parser du texte entré par l'utilisateur 
 * en xHTML. Les données doivent suivre une syntaxe XML. Ce script utilise
 * DOM (PHP 5 est donc nécessaire).
 * Note : le code utilisé actuellement est le zCode, créé et utilisé par 
 * le Site du Zér0 (http://ww.siteduzero.com).
 * 
 * @author vincent1870
 * @needs >PHP5
 * @begin 13/04/2008
 * @last 17/04/2008
*/


// Configuration
error_reporting(E_ALL ^ E_NOTICE); 
define('LOCALE', 'fr');
define('ZCODE_IS_UTF8', false);
include_once(dirname(__FILE__).'/zcode_config_'.LOCALE.'.php');


/**
 * Parse les smilies
 * @param string $data            Les données à parser
 * @return string
 */
function smilies($data){
    global $zcode;
    foreach($zcode['smilies'] as $key=>$value){
        $data = str_replace(' '.$key.' ', ' <img src="'.$zcode['path_smilies'].$value.'" alt="'.htmlspecialchars($key).'" /> ', $data);
    }
    return $data;
}


/**
 * Parse des données (fonction à appeller ; elle se charge d'appeller les autres fonctions nécessaires)
 * @param string $data            Les données à parser
 * @param bool $smilies            Doit-on parser les smilies ?
 * @return string
 */
function zcode($data, $smilies = true){
    global $zcode;
    
    // Initialisation du parsage
    if(ZCODE_IS_UTF8 == false){
       // $data = mb_convert_encoding ($data, 'ISO-8859-1', 'UTF-8');
		$data = mb_convert_encoding($data, 'UTF-8');
    }
    
    // Ajout de la DTD et de l'en-tête XML (à venir)
    $data = '<?xml version="1.0" encoding="utf-8"?>'."\n".'<'.$zcode['bal_root'].'>'.$data.'</'.$zcode['bal_root'].'>';
    $bals = array_merge($zcode['simple'], $zcode['cplx']);
    
    // Remplacement des sections de code en CDATA
    $data = preg_replace('`<code(\stype="(.+)")>(.+)</code>`isU', '<code type="$2"><![CDATA[$3]]></code>', $data);
    
    // Réparation provisoire d'un bug
    $data = str_replace(array(' < ', ' > '), array(' &lt; ', ' &gt; '), $data);
    
    //Remplacement des entités spéciales
    $data = str_replace(array('&'), array('&amp;'), $data);
    
    // Création de l'objet DomDocument
    $dom = new DomDocument();
    if(!$dom->loadXML($data)){
        exit('<strong>parse :</strong> document non valide.<br /><br /><pre>'.htmlspecialchars($data).'</pre>');
    }
    $xml = $dom->getElementsByTagName($zcode['bal_root']);
    $xml = $xml->item(0);
    
    // On lance le parsage
    $xml = parse_childs($xml);
    
    // On parse les smilies si demandé
    if($smilies == true){
        $xml = smilies($xml);
    }
    
    // On applique quelques modifications
    $xml = preg_replace('`<ul>(<br />\s)*<li>`sU', '<ul><li>', $xml);
    $xml = preg_replace('`</li>(<br />\s)*<li>`sU', '</li><li>', $xml);
    $xml = preg_replace('`</li>(<br />\s)*<ul>`sU', '</li><ul>', $xml);
    $xml = preg_replace('`</ul>(<br />\s)*</li>`sU', '</ul></li>', $xml);
    $xml = preg_replace('`</li>(<br />\s)*</ul>`sU', '</li></ul>', $xml);
    
    // On renvoie les données parsées
    if(ZCODE_IS_UTF8 == false){
        $xml = iconv('ISO-8859-1', 'UTF-8', $xml);
    }
    return $xml;
}


/**
 * Parse les balises de code via GeSHi
 * @param string $data            Les données à parser
 * @return string
 */
function parse_code($data, &$lang, $begin, $highlight){
    global $zcode;
    
    // Transformation des données
    $data = trim($data);
    
    // Gestion des noms de code
    if(!array_key_exists($lang, $zcode['codes'])){
        $code = $zcode['codes'][count($zcode['codes']) -1];
    }
    if(array_key_exists($lang, $zcode['alias'])){
        $lang = $zcode['alias'][$lang];
    }
    
    // Création de l'ojet fshl
    include_once(dirname(__FILE__).'/'.$zcode['path_fshl']);
    $parser = new fshlParser('HTML');
    
    // Parsage
    $data = '<pre class="normal">'.$parser->highlightString($lang, $data).'</pre>';
    
    // Modification du langage
    $lang = $zcode['codes'][$lang];
    
    // On renvoie les données
    return $data;
}


/**
 * Parse un noeud
 * @param node $node            Le noeud à parser
 * @param string $insert        Données à insérer
 * @return string
 */
function parse_node($node, $insert = ''){
    global $zcode;
    $name = $node->nodeName;
    
    // si on veut insérer du contenu
    if(!empty($insert)){
        $data = $insert;
    }
    else{
        if($name == $zcode['cplx'][6]){
            $data = $node->data;
        }
        else{
            $data = $node->nodeValue;
        }
    }

    // on parse en fonction de la balise
    if($name == $zcode['simple'][0] && $node->hasAttributes() == false){
        $data = '<strong>'.$data.'</strong>';
    }
    elseif($name == $zcode['simple'][1] && $node->hasAttributes() == false){
        $data = '<span class="italique">'.$data.'</span>';
    }
    elseif($name == $zcode['simple'][2] && $node->hasAttributes() == false){
        $data = '<span class="souligne">'.$data.'</span>';
    }
    elseif($name == $zcode['simple'][3] && $node->hasAttributes() == false){
        $data = '<span class="barre">'.$data.'</span>';
    }
    elseif($name == $zcode['simple'][4] && $node->hasAttributes() == false){
        $data = '<a href="'.$data.'">'.$data.'</a>';
    }
    elseif($name == $zcode['simple'][5] && $node->hasAttributes() == false){
        $data = '<span class="spoiler">'.$zcode['txt_spoiler'].'</span><div class="spoiler2" onclick="switch_spoiler(this); return false;"><div class="spoiler3">'.$data.'</div></div></span>';
    }
    elseif($name == $zcode['simple'][6] && $node->hasAttributes() == false){
        $data = '<a href="mailto:'.$data.'">'.$data.'</a>';
    }
    elseif($name == $zcode['simple'][7] && $node->hasAttributes() == false){
        $data = '<td>'.$data.'</td>';
    }
    elseif($name == $zcode['simple'][8] && $node->hasAttributes() == false){
        $data = '<div class="rmq information">'.$data.'</div>';
    }
    elseif($name == $zcode['simple'][9] && $node->hasAttributes() == false){
        $data = '<div class="rmq attention">'.$data.'</div>';
    }
    elseif($name == $zcode['simple'][10] && $node->hasAttributes() == false){
        $data = '<div class="rmq erreur">'.$data.'</div>';
    }
    elseif($name == $zcode['simple'][11] && $node->hasAttributes() == false){
        $data = '<div class="rmq question">'.$data.'</div>';
    }
    elseif($name == $zcode['simple'][12] && $node->hasAttributes() == false){
        $data = '<span class="code">'.$zcode['txt_code'].'</span><div class="code2">'.$data.'</div>';
    }
    elseif($name == $zcode['simple'][13] && $node->hasAttributes() == false){
        $data = '<sup>'.$data.'</sup>';
    }
    elseif($name == $zcode['simple'][14] && $node->hasAttributes() == false){
        $data = '<sub>'.$data.'</sub>';
    }
    elseif($name == $zcode['simple'][15] && $node->hasAttributes() == false){
        $data = '<img src="'.$zcode['path_mimetex'].'?'.$data.'" alt="'.$data.'" />';
    }
    elseif($name == $zcode['simple'][16] && $node->hasAttributes() == false){
        $data = '<h3 class="titre1">'.$data.'</h3>';
    }
    elseif($name == $zcode['simple'][17] && $node->hasAttributes() == false){
        $data = '<h4 class="titre2">'.$data.'</h4>';
    }
    elseif($name == $zcode['simple'][18] && $node->hasAttributes() == false){
        $data = '<ul>'.$data.'</ul>';
    }
    elseif($name == $zcode['simple'][19] && $node->hasAttributes() == false){
        $data = '<li>'.$data.'</li>';
    }
    elseif($name == $zcode['simple'][20] && $node->hasAttributes() == false){
        $data = '<span class="citation">'.$zcode['txt_citation'].'</span><div class="citation2">'.$data.'</div>';
    }
    elseif($name == $zcode['simple'][21] && $node->hasAttributes() == false){
        $data = '<img src="'.$data.'" alt="'.$zcode['alt_img'].'" />';
    }
    elseif($name == $zcode['simple'][22] && $node->hasAttributes() == false){
        $data = '<table class="tab_user">'.$data.'</table>';
    }
    elseif($name == $zcode['simple'][23] && $node->hasAttributes() == false){
        $data = '<tr>'.$data.'</tr>';
    }
    elseif($name == $zcode['simple'][24] && $node->hasAttributes() == false){
        $data = '<th>'.$data.'</th>';
    }
	elseif($name == $zcode['simple'][25] && $node->hasAttributes() == false){
		$url = parse_url($data);
		if($url['host'] == "youtube.com" OR $url['host'] == "www.youtube.com" OR $url['host'] == 'fr.youtube.com')
		{
			$video = trim($data,"https://www.youtube.com/watch?v=");
			$data = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			//$data = '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$video.'" frameborder="0" allowfullscreen></iframe>';
			/*$data = '<object type="application/x-shockwave-flash" data="'.$data.'" width="425" height="350">
					<param name="movie" value="'.$data.'" />
					<param name="wmode" value="transparent" />
					</object>';*/
		}
		elseif($url['host'] == "dailymotion.com" OR $url['host'] == "www.dailymotion.com" OR $url['host'] == 'fr.dailymotion.com')
		{
			$video = trim($data,"http://www.dailymotion.com/video/");
			$video = substr($video, 0, 7);
			//$data = $video.'bb';
			$data = '<iframe frameborder="0" width="480" height="270" src="http://www.dailymotion.com/embed/video/'.$video.'"></iframe>';
		}
		elseif($url['host'] == "vimeo.com" OR $url['host'] == "www.vimeo.com" OR $url['host'] == 'http://vimeo.com')
		{
			$data = '<object type="application/x-shockwave-flash" width="400" height="225" data="http://vimeo.com/moogaloop.swf?clip_id='.trim($data,"https://vimeo.com/").'&amp;server=vimeo.com&amp;amp;show_title=1&amp;amp;show_byline=1&amp;amp;show_portrait=0&amp;amp;color=00adef&amp;amp;fullscreen=1"><param name="allowscriptaccess" value="always"><param name="allowfullscreen" value="true"></object>';
			//$data = '<object type="application/x-shockwave-flash" data="'.$data.'" width="'.$data.'" height="'.$data.'"><param name="movie" value="'.$data.'" /><param name="allowfullscreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="wmode" value="transparent" /></object>';
		}
	}
	elseif($name == $zcode['simple'][26] && $node->hasAttributes() == false){
		$data = '<iframe width="600" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"  src="'.$data.'" allowfullscreen></iframe>';
    }
	elseif($name == $zcode['simple'][27] && $node->hasAttributes() == false){
        $data = '<a href="http://track.effiliation.com/servlet/effi.redir?id_compteur=13446614&url='.$data.'">'.$data.'</a>';
    }
    elseif($name == $zcode['simple'][28] && $node->hasAttributes() == false){
        $data = '<td>'.$data.'</td>';
    }
	elseif($name == $zcode['simple'][29] && $node->hasAttributes() == false){
		$data = '<script type="text/javascript" src="http://www.openrunner.com/orservice/inorser-script.php?key=mykey&amp;ser=S09&amp;id='.$data.'&amp;w=350&amp;h=350&amp;hp=128&amp;k=5&amp;m=0&amp;pa=0&amp;c=0&amp;ts=1485457360"></script>';
    }
	elseif($name == $zcode['simple'][30] && $node->hasAttributes() == false){
		$data = '<iframe sandbox="'.$data.'"></iframe>';
    }
    
    
    elseif($name == $zcode['cplx'][0] && $node->hasAttributes() == true){
         if(in_array($node->attributes->getNamedItem($zcode['cplx_attrs'][0][0])->nodeValue, $zcode['attrs_val'][0][0])){
             $data = '<ul class="liste_'.$node->attributes->getNamedItem($zcode['cplx_attrs'][0][0])->nodeValue.'">'.$data.'</ul>';
         }
    }
    elseif($name == $zcode['cplx'][1] && $node->hasAttributes() == true){
        if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][1][0])->nodeValue)){
            $url = true;
        }
        else{
            $url = false;
        }
        if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][1][1])->nodeValue)){
            $name= ' - '.$node->attributes->getNamedItem($zcode['cplx_attrs'][1][1])->nodeValue;
        }
        else{
            $name = '';
        }
        if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][1][2])->nodeValue)){
            $rid = '';
        }
        else{
            $rid = '';
        }
        
        if(!$url){
            $data = '<span class="citation">'.$zcode['txt_citation'].$name.'</span><div class="citation2">'.$data.'</div>';
        }
        else{
            $data = '<span class="citation"><a href="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][1][2])->nodeValue.'">'.$zcode['txt_citation'].$nom.'</a></span><div class="citation2">'.$data.'</div>';
        }
    }
    elseif($name == $zcode['cplx'][2] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][2][0])->nodeValue)){
             $data = '<img src="'.$data.'" alt="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][2][0])->nodeValue.'" />';
         }
    }
    elseif($name == $zcode['cplx'][3] && $node->hasAttributes() == true){
         if(in_array($node->attributes->getNamedItem($zcode['cplx_attrs'][3][0])->nodeValue, $zcode['attrs_val'][3][0]) && !empty($node->attributes->getNamedItem($zcode['cplx_attrs'][3][1])->nodeValue)){
             $data = '<a href="'.$zcode['type_lien_url'][$node->attributes->getNamedItem($zcode['cplx_attrs'][3][0])->nodeValue].$node->attributes->getNamedItem($zcode['cplx_attrs'][3][1])->nodeValue.'">'.$data.'</a>';
         }
         elseif(!$node->attributes->getNamedItem($zcode['cplx_attrs'][3][0])->nodeValue && !empty($node->attributes->getNamedItem($zcode['cplx_attrs'][3][1])->nodeValue)){
             $data = '<a href="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][3][1])->nodeValue.'" '.$zcode['class_lien_url'][$node->attributes->getNamedItem($zcode['cplx_attrs'][1][3])->nodeValue].'>'.$data.'</a>';
         }
    }
    elseif($name == $zcode['cplx'][4] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][4][0])->nodeValue)){
             $data = '<a href="mailto:'.$node->attributes->getNamedItem($zcode['cplx_attrs'][4][0])->nodeValue.'">'.$data.'</a>';
         }
    }
    elseif($name == $zcode['cplx'][5] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][5][0])->nodeValue)){
             if($node->attributes->getNamedItem($zcode['cplx_attrs'][5][0])->nodeValue == 1){
                 $a = '<a href="#" onclick="switch_spoiler_hidden(this); return false;">';
                 $a2 = '</a>';
                 $switch2 = '';
                 $spoiler2 = 'spoiler2_hidden';
                 $spoiler3 = 'spoiler3_hidden';
             }
             else{
                 $a = '';
                 $a2 = '';
                 $switch2 = ' onclick = "switch_spoiler(this); return false;"';
                 $spoiler2 = 'spoiler2';
                 $spoiler3 = 'spoiler3';
             }
             $data = '<span class="spoiler">'.$a.$zcode['txt_spoiler'].$a2.'</span><div class="'.$spoiler2.'"'.$switch2.'><div class="'.$spoiler3.'">'.$data.'</div></div></span>';
         }
    }
    elseif($name == $zcode['cplx'][6] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][6][0])->nodeValue)){
             if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][6][1])->nodeValue))
             {
                 $title = ' - '.$node->attributes->getNamedItem($zcode['cplx_attrs'][6][1])->nodeValue;
             }
             else{
                 $title = '';
             }
             if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][6][2])->nodeValue)){
                 $begin = $node->attributes->getNamedItem($zcode['cplx_attrs'][6][2])->nodeValue;
             }
             else{
                 $begin = 1;
             }
             if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][6][3])->nodeValue)){
                 $url1 = '<a href="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][6][3])->nodeValue.'">';
                 $url2 = '</a>';
             }
             else{
                 $url1 = '';
                 $url2 = '';
             }
             if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][6][4])->nodeValue)){
                 $highlight = $node->attributes->getNamedItem($zcode['cplx_attrs'][6][4])->nodeValue;
             }
             else{
                 $highlight = '';
             }
             $lang = $node->attributes->getNamedItem($zcode['cplx_attrs'][6][0])->nodeValue;
             $code = parse_code($data, $lang, $begin, $highlight);
             $data = '<span class="code">'.$url1.$zcode['txt_code'].$lang.$title.$url2.'</span><div class="code2">'.$code.'</div>';
         }
    }
    elseif($name == $zcode['cplx'][7] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][7][0])->nodeValue)){
             $data = '<div class="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][7][0])->nodeValue.'">'.$data.'</div>';
         }
    }
    elseif($name == $zcode['cplx'][8] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][8][0])->nodeValue)){
             $data = '<div class="flot_'.$node->attributes->getNamedItem($zcode['cplx_attrs'][8][0])->nodeValue.'">'.$data.'</div>';
         }
    }
    elseif($name == $zcode['cplx'][9] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][9][0])->nodeValue)){
             if(is_numeric($node->attributes->getNamedItem($zcode['cplx_attrs'][9][0])->nodeValue)){
                 $data = '<span style="font-size: '.$node->attributes->getNamedItem($zcode['cplx_attrs'][9][0])->nodeValue.'px;">'.$data.'</span>';
             }
             else{
                 $data = '<span class="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][9][0])->nodeValue.'">'.$data.'</span>';
             }
         }
    }
    elseif($name == $zcode['cplx'][10] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][10][0])->nodeValue)){         
             $data = '<span class="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][10][0])->nodeValue.'">'.$data.'</span>';
         }
    }
    elseif($name == $zcode['cplx'][11] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][11][0])->nodeValue)){
             $data = '<span class="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][11][0])->nodeValue.'">'.$data.'</span>';
         }
    }
    elseif($name == $zcode['cplx'][12] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][12][0])->nodeValue)){
             $data = '<acronym title="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][12][0])->nodeValue.'">'.$data.'</acronym>';
         }
    }
    elseif($name == $zcode['cplx'][13] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][13][0])->nodeValue)){
             $rowspan = ' rowspan="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][13][0])->nodeValue.'"';
         }
         else{
             $rowspan = '';
         }
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][13][1])->nodeValue)){
             $colspan = ' colspan="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][13][1])->nodeValue.'"';
         }
         else{
             $colspan = '';
         }
         $data = '<td'.$rowspan.$colspan.'>'.$data.'</td>';
    }
    elseif($name == $zcode['cplx'][14] && $node->hasAttributes() == true){
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][14][0])->nodeValue)){
             $rowspan = ' rowspan="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][14][0])->nodeValue.'"';
         }
         else{
             $rowspan = '';
         }
         if(!empty($node->attributes->getNamedItem($zcode['cplx_attrs'][14][1])->nodeValue)){
             $colspan = ' colspan="'.$node->attributes->getNamedItem($zcode['cplx_attrs'][14][1])->nodeValue.'"';
         }
         else{
             $colspan = '';
         }
         $data = '<th'.$rowspan.$colspan.'>'.$data.'</th>';
    }
    elseif($name == $zcode['bal_root']){
        $data = preg_replace('`(\r*\n)`', '<br />', $data);
    }
    else{
        $data = $data;
    }

    // On retourne les données
    return $data;

}


/**
 * Fonction de parsage récursive
 * @param node $node            Le noeud à parser
 * @return string
 */
function parse_childs($node){
    if(!isset($data)){
        $data = '';
    }
    $childs = $node->childNodes;
    foreach($childs as $child){
        if($child->hasChildNodes() == true){
            $data .= parse_childs($child);
        }
        else{
            $data .= parse_node($child);
        }
    }
    return parse_node($node, $data);
}


/**
 * Raccourcit des URL.
 * @param array $match            Le tableau contenant l'URL en index 1.
 * @return string
 */
function shorten_urls($match){
    $url = $match[1];
    
    if( strlen($match[1]) > URLS_MAX ){
        $url = substr($match[1], 0, URLS_NB_FIX) . '[...]' . substr($match[1], URLS_NB_FIX * (-1));
    }
    
    return '<a href="' . $match[1] . '">' . $url . '</a>';
}

?>