<?php
/**
 * Fichier de configuration du zCode. Vous pouvez éditer ce fichier sans
 * risque, pour modifier le nom d'une balise par exemple.
 * Note : le code utilisé actuellement est le zCode, créé et utilisé par 
 * le Site du Zér0 (http://ww.siteduzero.com).
 * 
 * @author vincent1870
 * @begin 13/04/2008
 * @last 17/04/2008
*/

$zcode = array();

// Chemins vers des éléments complémentaires
$zcode['path_geshi'] = 'geshi.php';
$zcode['path_mimetex'] = '';
$zcode['path_smilies'] = 'images/smilies/';
$zcode['path_smilies'] = 'images/smilies/';
$zcode['path_fshl'] = 'fshl/fshl.php';


// Balises simples sans attributs
$zcode['simple'] = array(
    0 => 'gras',
    1 => 'italique',
    2 => 'souligne',
    3 => 'barre',
    4 => 'lien',
    5 => 'secret',
    6 => 'email',
    7 => 'cellule',
    8 => 'information',
    9 => 'attention',
    10 => 'erreur',
    11 => 'question',
    12 => 'code',
    13 => 'exposant',
    14 => 'indice',
    15 => 'math',
    16 => 'titre1',
    17 => 'titre2',
    18 => 'liste',
    19 => 'puce',
    20 => 'citation',
    21 => 'image',
    22 => 'tableau',
    23 => 'ligne',
    24 => 'entete',
	25 => 'video',
	26 => 'IGN',
	27 => 'effiliation',
	28 => 'colonne',
	29 => 'openrunner',
	30 => 'amazon'
);


// Balises complexes avec attribut(s)
$zcode['cplx'] = array(
    0 => 'liste',
    1 => 'citation',
    2 => 'image',
    3 => 'lien',
    4 => 'email',
    5 => 'secret',
    6 => 'code',
    7 => 'position',
    8 => 'flottant',
    9 => 'taille',
    10 => 'couleur',
    11 => 'police',
    12 => 'acronyme',
    13 => 'cellule',
    14 => 'entete',
	15 => 'imglien'
);


// Attributs des balises complexes
$zcode['cplx_attrs'] = array(
    0 => array('type'),
    1 => array('lien', 'nom', 'rid', 'class'),
    2 => array('legende'),
    3 => array('type', 'url'),
    4 => array('nom'),
    5 => array('cache'),
    6 => array('type', 'titre', 'debut', 'url', 'surligne'),
    7 => array('valeur'),
    8 => array('valeur'),
    9 => array('valeur'),
    10 => array('nom'),
    11 => array('nom'),
    12 => array('valeur'),
    13 => array('fusion_lig', 'fusion_col'),
    14 => array('fusion_lig', 'fusion_col')
);


// Valeurs possibles de certains attributs
$zcode['attrs_val'][1][4] = array('test');
$zcode['attrs_val'][0][0] = array('1', 'i', 'I', 'A', 'a');
$zcode['attrs_val'][3][0] = array('google', 'wikipedia');
$zcode['attrs_val'][5][0] = array('0', '1');
$zcode['attrs_val'][6][0] = array('php', 'xhtml', 'zcode', 'autre'); // A COMPLETER
$zcode['attrs_val'][7][0] = array('justifie', 'centre', 'gauche', 'droite');
$zcode['attrs_val'][8][0] = array('gauche', 'droite');
$zcode['attrs_val'][9][0] = array('gros', 'tgros', 'ttgros', 'petit', 'tpetit', 'ttpetit', 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30);
$zcode['attrs_val'][10][0] = array('rose', 'rouge', 'orange', 'jaune', 'vertc', 'vertf', 'olive', 'turquoise', 'bleugris', 'bleu', 'marine', 'violet', 'marron', 'noir', 'gris', 'argent', 'blanc');
$zcode['attrs_val'][11][0] = array('arial', 'times', 'courrier', 'impact', 'geneva', 'optima');


// Textes divers
$zcode['alt_img'] = 'Image utilisateur';
$zcode['txt_code'] = 'Code : ';
$zcode['txt_citation'] = 'Citation';
$zcode['txt_citation_auteur'] = 'Citation : ';
$zcode['txt_spoiler'] = 'Secret (cliquez pour afficher)';
$zcode['txt_code_num'] = 'Afficher / masquer les numéros de ligne';
$zcode['type_lien_url'] = array('google' => 'http://www.google.fr/search?q=', 'wikipedia' => 'http://fr.wikipedia.org/wiki/');
$zcode['class_lien_url'] = array('test' => 'rel="test"');

// Alias de langages
$zcode['alias']['html'] = 'HTMLonly';
$zcode['alias']['php'] = 'PHP';
$zcode['alias']['zcode'] = 'XML';
$zcode['alias']['html_php'] = 'HTML';
$zcode['alias']['cpp'] = 'CPP';
$zcode['alias']['javascript'] = 'JS';
$zcode['alias']['sql'] = 'SQL';
$zcode['alias']['python'] = 'PY';
$zcode['alias']['java'] = 'JAVA';
$zcode['alias']['autre'] = 'AUTRE';

// Balise racine, ne pouvant être employée ailleurs
$zcode['bal_root'] = 'data';


// Noms des codes en langage compréhensible. Le code Autre doit toujours être en dernier !
$zcode['codes'] = array(
    'CSS'            => 'CSS',
    'PHP'            => 'PHP',
    'CPP'            => 'C++',
    'HTML'            => 'xHTML+PHP',
    'HTMLonly'        => 'xHTML',
    'JS'            => 'Javascript',
    'JAVA'            => 'Java',
    'SQL'            => 'SQL',
    'PY'            => 'Python',
    'XML'            => 'XML',
    'ZCODE'            => 'atCode',
    'AUTRE'            => 'Autre'
    
);


// Codes smilies et images correspondantes
$zcode['smilies'] = array(
    ':)' => 'smile.png',
    ':D' => 'heureux.png',
    ';)' => 'clin.png',
    ':p' => 'langue.png',
    ':lol:' => 'rire.gif',
    ':euh:' => 'unsure.gif',
    ':(' => 'triste.png',
    ':o' => 'huh.png',
    ':colere2:' => 'mechant.png',
    'o_O' => 'blink.gif',
    '^^' => 'hihi.png',
    ':-°' => 'siffle.png',
    ':ange:' => 'ange.png',
    ':colere:' => 'angry.gif',
    ':diable:' => 'diable.png',
    ':magicien:' => 'magicien.png',
    ':ninja:' => 'ninja.png',
    ':-:' => 'pinch.png',
    ':pirate:' => 'pirate.png',
    ':\'(' => 'pleure.png',
    ':honte:' => 'rouge.png',
    ':soleil:' => 'soleil.png',
    ':waw:' => 'waw.png',
    ':zorro:' => 'zorro.png'
);
?>