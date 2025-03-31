<?php
function createKeyword($data) {

	$data = strip_tags($data);
	$data = html_entity_decode($data);
	$data = str_replace(array("\n","\r"),' ',$data);
	$data = str_replace(array('!','?',' ','\\','�','+','`','<','>','_','=','}','{','#','@','.','(',')','[',']',';',',',':','/','�','%','*','^','�','$','�','�','\'','"','~','|','&'),' ',$data);
	$data = str_replace("  "," ",$data);
	$data = str_replace("   "," ",$data);
	$data = strtolower($data);
	$keywords = explode(' ',$data);	
	$blackword = array('II','1','III','2','IV','3','VI','4','VII','5','VIII','6','XI','7','XII','8','XIII','9',
	'XIV','0','XIX','$','XV','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u',
	'v','w','x','y','z','XVI','XVII','XVIII','XX','XXI','XXII','XXIII','XXIV','XXIX','XXV','XXVI','XXVII','XXVIII',
	'XXX','XXXI','XXXII','XXXIII','XXXIV','XXXIX','XXXV','XXXVI','XXXVII','XXXVIII','a','adieu','afin','ah','ai',
	'aie','aient','aies','ait','al.','alerte','all�','alors','apr.','apr�s','arri�re','as','attendu','attention',
	'au','aucun','aucune','aucunes','aucuns','audit','auquel','aura','aurai','auraient','aurais','aurait','auras',
	'aurez','auriez','aurions','aurons','auront','autant','autre','autres','autrui','aux','auxdites','auxdits',
	'auxquelles','auxquels','avaient','avais','avait','avant','avec','avez','aviez','avions','avoir','avons',
	'ayant','ayante','ayantes','ayants','ayez','ayons','a�e','bah','barbe','basta','beaucoup','bernique','bien',
	'bigre','billiard','bis','bof','bon','bougre','boum','bravissimo','bravo','car','ce','ceci','cela','celle',
	'celles','celui','centi�me','centi�mes','cents','cependant','certaines','certains','ces','cet','cette','ceux',
	'chacun','chacune','chaque','chez','chic','chiche','chouette','chut','ciao','ciel','cinq','cinquante','cinquanti�me',
	'cinquanti�mes','cinqui�me','cinqui�mes','clac','clic','comme','comment','concernant','contre','corbleu','coucou',
	'couic','crac','cric','cr�nom','da','dame','damnation','dans','de','debout','depuis','derri�re','des','desdites',
	'desdits','desquelles','desquels','deux','deuxi�me','deuxi�mes','devaient','devais','devait','devant','devante',
	'devantes','devants','devez','deviez','devions','devoir','devons','devra','devrai','devraient','devrais','devrait',
	'devras','devrez','devriez','devrions','devrons','devront','dia','diantre','dix','dixi�me','dixi�mes','dois','doit',
	'doive','doivent','doives','donc','dont','doucement','douze','douzi�me','douzi�mes','du','dudit','due','dues','duquel',
	'durant','durent','dus','dussent','dut','d�s','d�','d�t','eh','elle','elles','en','encontre','end�ans','entre','envers',
	'es','et','eu','eue','eues','euh','eurent','eur�ka','eus','eusse','eussent','eusses','eussiez','eussions','eut','eux',
	'except�','e�mes','e�t','e�tes','fi','fichtre','fixe','fl�te','foin','fors','fouchtra','furent','fus','fusse','fussent',
	'fusses','fussiez','fussions','fut','f�mes','f�t','f�tes','gare','gr�ce','gu�','ha','halte','hardi','hein','hem','hep',
	'heu','ho','hol�','hop','hormis','hors','hou','hourra','hue','huit','huitante','huitanti�me','huiti�me','huiti�mes',
	'hum','hurrah','h�','h�las','il','ils','jarnicoton','je','jusque','la','ladite','laquelle','las','le','ledit','lequel',
	'les','lesdites','lesdits','lesquelles','lesquels','leur','leurs','lorsque','lui','l�','ma','made','mais','malgr�',
	'mazette','me','merci','merde','mes','mien','mienne','miennes','miens','milliard','milliardi�me','milliardi�mes',
	'millioni�me','millioni�mes','milli�me','milli�mes','mince','minute','mis�ricorde','moi','moins','mon','morbleu',
	'motus','moyennant','m�tin','na','ne','neuf','neuvi�me','neuvi�mes','ni','nonante','nonanti�me','nonanti�mes',
	'nonobstant','nos','notre','nous','nul','nulle','nulles','nuls','n�tre','n�tres','octante','octanti�me','oh','oh�',
	'ol�','on','ont','onze','onzi�me','onzi�mes','or','ou','ouais','ouf','ouille','oust','ouste','outre','ou�e','o�',
	'paix','palsambleu','pan','par','parbleu','parce','pardi','pardieu','parmi','pas','pass�','patatras','pech�re',
	'pendant','personne','peu','peuch�re','peut','peuvent','peux','plein','plouf','plus','plusieurs','point','pouah',
	'pour','pourquoi','pourra','pourrai','pourraient','pourrais','pourrait','pourras','pourrez','pourriez','pourrions',
	'pourrons','pourront','pourvu','pouvaient','pouvais','pouvait','pouvant','pouvante','pouvantes','pouvants','pouvez',
	'pouviez','pouvions','pouvoir','pouvons','premier','premiers','premi�re','premi�res','psitt','pst','pu','pue','pues',
	'puis','puisque','puisse','puissent','puisses','puissiez','puissions','purent','pus','pussent','put','p�ca�re','p�t',
	'qq.','qqch.','qqn','quand','quant','quarante','quaranti�me','quaranti�mes','quatorze','quatorzi�me','quatorzi�mes',
	'quatre','quatri�me','quatri�mes','que','quel','quelle','quelles','quelqu\'un','quelqu\'une','quels','qui','quiconque',
	'quinze','quinzi�me','quinzi�mes','quoi','quoique','rataplan','revoici','revoil�','rien','sa','sacristi','salut',
	'sans','saperlipopette','sapristi','sauf','savoir','se','seize','seizi�me','seizi�mes','selon','sept','septante',
	'septanti�me','septi�me','septi�mes','sera','serai','seraient','serais','serait','seras','serez','seriez','serions',
	'serons','seront','ses','si','sien','sienne','siennes','siens','sinon','six','sixi�me','sixi�mes','soi','soient',
	'sois','soit','soixante','soixanti�me','soixanti�mes','sommes','son','sont','sous','soyez','soyons','stop','suis',
	'suivant','sur','ta','tandis','tant','taratata','tayaut','ta�aut','te','tel','telle','telles','tels','tes','tien',
	'tienne','tiennes','tiens','toi','ton','touchant','tous','tout','toute','toutes','treize','treizi�me','treizi�mes',
	'trente','trenti�me','trenti�mes','trois','troisi�me','troisi�mes','tu','tudieu','turlututu','un','une','uni�me',
	'uni�mes','v\'lan','va','vers','versus','veuille','veuillent','veuilles','veuillez','veuillons','veulent','veut',
	'veux','via','vingt','vingti�me','vingti�mes','vivement','vlan','voici','voil�','vos','votre','voudra','voudrai',
	'voudraient','voudrais','voudrait','voudras','voudrez','voudriez','voudrions','voudrons','voudront','voulaient',
	'voulais','voulait','voulant','voulante','voulantes','voulants','voulez','vouliez','voulions','vouloir','voulons',
	'voulu','voulue','voulues','voulurent','voulus','voulussent','voulut','voul�t','vous','vs','vu','v�tre','v�tres',
	'y','zut','�','�\'a','�\'aura','�\'aurait','�\'avait','�a','��','�s','�taient','�tais','�tait','�tant','�tante','�tantes',
	'�tants','�tiez','�tions','�voh�','�vo�','�tes','�tre','�','�t�','site','gras','faire','grand','aussi','encore',
	'permet','ainsi','lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche','janvier','fevrier','mars','avril',
	'mai','juin','juillet','aout','septembre','novembre','decembre');
	$tags = array();
	foreach($keywords as $keyword){
		$keyword = trim($keyword);
		if(!in_array($keyword,$blackword) AND strlen($keyword) > 3){
			if(isset($tags[$keyword]))
				$tags[$keyword] = $tags[$keyword]+1;
			else
				$tags[$keyword] = 1;
		}
	}
	arsort($tags);
	if(!is_cache(ROOT."testkeyword.txt",86400));write_cache(ROOT."testkeyword.txt",$tags);
}
?>
