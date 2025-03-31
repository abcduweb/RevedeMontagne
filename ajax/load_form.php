<?php
//##########################################################################
//Paramètres communs à chaque page
//##########################################################################
session_start();		
define('ROOT', '../');                         
define('INC_ROOT', ROOT.'include/');
define('FONC_ROOT', ROOT.'fonction/');
require_once(INC_ROOT.'param.php');
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');
define('CSS',ROOT.'templates/');			  
require_once(ROOT.'templates.php');
//##########################################################################
//fin
//##########################################################################
	include (INC_ROOT.'header.php');
	include (INC_ROOT.'divers.php');
header('Content-type: text/html; charset=iso-8859-1');
$sql = "SELECT acce_editeur FROM groupe WHERE id_groupe = '$_SESSION[group]'";
$db->requete($sql);
$row = $db->row();
if($row[0] == 1)
{
	if(!empty($_POST['format']))
	{
		$formId = intval($_POST['format']);
		switch($formId)
		{
			case 1:
			{

					
					
				//affectation des variables
				$nom_emplacement = '';
				$nom_site = '';
				$url_site = '';
				$desc_site = '';
				$format = '';
				$nb_pub = '1';
				$nb_caracteres_titre = '15';
				$nb_caracteres_texte = '50';
				$coul_bordure = '000000';
				$coul_fond = 'FFFFFF';
				$coul_titre = '0000FF';
				$coul_desc = '000000';
				$police = 'Times New Roman';
				$size_titre = '14';
				$size_desc = '12';
				$choix_cat = '';
				$choix_tag = '';
	
				//choix de la catégorie dans l'annuaire
				$requete2 = ('SELECT * FROM cat_annuaire ORDER BY cat_pos, id_cat ASC');
				$resultat2 = $db->requete($requete2);
				
				$annu = '';
				while($reponse2 = $db->fetch($resultat2))
					{	

							if($reponse2['id_cat_mere'] == 0)
								{
									$id_cat_mere = $reponse2['id_cat'];
									$id_choix = $reponse2['id_cat'];
									$cat_name = $reponse2['cat_name'];
									$selected = '';
								}
							else
								{	
									if (!empty($reponse1['id_cat']) AND ($reponse1['id_cat'] == $reponse2['id_cat']))
										$selected = 'selected="selected"';
									else
										$selected = '';
								
									$id_choix = $reponse2['id_cat'];
									if($reponse2['cat_chef'] == 1)
										$cat_name = '&nbsp; &rArr; '.$reponse2['cat_name'];
									else
										$cat_name = '&nbsp; &nbsp; &nbsp; &raquo; '.$reponse2['cat_name'];
								}

						
						//$data = parse_boucle('LISTE',$data,false,array('LISTE.selected'=>$selected, 'LISTE.id_choix'=>$id_choix, 'LISTE.nom_choix'=>$cat_name));
						$annu .= '<option value="'.$id_choix.'" '.$selected.'>'.$cat_name.'</option>';
						
						
					}
				

				echo parse_var(get_file(ROOT.'templates/fr/campagne/aff_textuelle_468_60.tpl'),
				array('ROOT'=>'','design'=>$_SESSION['design'],'intro'=>'','conclu'=>'',
					'format'=>$formId,
					'nom_emplacement'=>$nom_emplacement, 
					'nom_du_site'=>$nom_site,
					'url_du_site'=>$url_site, 
					'desc_du_site'=>$desc_site, 
					'nb_pub'=>$nb_pub, 
					'nb_caracteres_titre'=>$nb_caracteres_titre, 
					'nb_caracteres_texte'=>$nb_caracteres_texte,
					'coul_bordure' => $coul_bordure, 
					'coul_fond' => $coul_fond, 
					'coul_titre' => $coul_titre, 
					'coul_desc' => $coul_desc, 
					'police' => $police, 
					'size_titre' => $size_titre, 
					'size_desc' => $size_desc, 
					'choix_tags'=>$choix_tag,
					'annu'=>$annu
					));
				
			break;
			}
			case 2:
			{
				//affectation des variables
				$nom_emplacement = '';
				$nom_site = '';
				$url_site = '';
				$desc_site = '';
				$nb_pub = '1';
				$format = '';
				$choix_cat = '';
				$choix_tag = '';
				
				
				//choix de la catégorie dans l'annuaire
				$requete2 = ('SELECT * FROM cat_annuaire ORDER BY cat_pos, id_cat ASC');
				$resultat2 = $db->requete($requete2);
				
				$annu = '';
				while($reponse2 = $db->fetch($resultat2))
				{	
					if($reponse2['id_cat_mere'] == 0)
					{
						$id_cat_mere = $reponse2['id_cat'];
						$id_choix = $reponse2['id_cat'];
						$cat_name = $reponse2['cat_name'];
						$selected = '';
					}
					else
					{	
						if (!empty($reponse1['id_cat']) AND ($reponse1['id_cat'] == $reponse2['id_cat']))
							$selected = 'selected="selected"';
						else
							$selected = '';
						
						$id_choix = $reponse2['id_cat'];
						if($reponse2['cat_chef'] == 1)
							$cat_name = '&nbsp; &rArr; '.$reponse2['cat_name'];
						else
							$cat_name = '&nbsp; &nbsp; &nbsp; &raquo; '.$reponse2['cat_name'];
					}
					//$data = parse_boucle('LISTE',$data,false,array('LISTE.selected'=>$selected, 'LISTE.id_choix'=>$id_choix, 'LISTE.nom_choix'=>$cat_name));
					$annu .= '<option value="'.$id_choix.'" '.$selected.'>'.$cat_name.'</option>';		
				}
				
				echo parse_var(get_file(ROOT.'templates/fr/campagne/aff_image_468_60.tpl'),
				array('ROOT'=>'',
				'design'=>$_SESSION['design'],
				'format'=>$formId,
				'nom_emplacement'=>$nom_emplacement, 
				'nom_du_site'=>$nom_site,
				'url_du_site'=>$url_site, 
				'desc_du_site'=>$desc_site,
				'nb_pub'=>$nb_pub, 				
				'choix_tags'=>$choix_tag,
				'annu'=>$annu
				));
			
			break;
			}
			case 3:
			{
			//affectation des variables
				$nom_emplacement = '';
				$nom_site = '';
				$url_site = '';
				$desc_site = '';
				$format = '';
				$nb_pub = '1';
				$nb_caracteres_titre = '15';
				$nb_caracteres_texte = '50';
				$coul_bordure = '000000';
				$coul_fond = 'FFFFFF';
				$coul_titre = '0000FF';
				$coul_desc = '000000';
				$police = 'Times New Roman';
				$size_titre = '14';
				$size_desc = '12';
				$choix_cat = '';
				$choix_tag = '';
	
				//choix de la catégorie dans l'annuaire
				$requete2 = ('SELECT * FROM cat_annuaire ORDER BY cat_pos, id_cat ASC');
				$resultat2 = $db->requete($requete2);
				
				$annu = '';
				while($reponse2 = $db->fetch($resultat2))
					{	

							if($reponse2['id_cat_mere'] == 0)
								{
									$id_cat_mere = $reponse2['id_cat'];
									$id_choix = $reponse2['id_cat'];
									$cat_name = $reponse2['cat_name'];
									$selected = '';
								}
							else
								{	
									if (!empty($reponse1['id_cat']) AND ($reponse1['id_cat'] == $reponse2['id_cat']))
										$selected = 'selected="selected"';
									else
										$selected = '';
								
									$id_choix = $reponse2['id_cat'];
									if($reponse2['cat_chef'] == 1)
										$cat_name = '&nbsp; &rArr; '.$reponse2['cat_name'];
									else
										$cat_name = '&nbsp; &nbsp; &nbsp; &raquo; '.$reponse2['cat_name'];
								}

						
						//$data = parse_boucle('LISTE',$data,false,array('LISTE.selected'=>$selected, 'LISTE.id_choix'=>$id_choix, 'LISTE.nom_choix'=>$cat_name));
						$annu .= '<option value="'.$id_choix.'" '.$selected.'>'.$cat_name.'</option>';
						
						
					}
				

				echo parse_var(get_file(ROOT.'templates/fr/campagne/clic_textuelle_468_60.tpl'),
				array('ROOT'=>'','design'=>$_SESSION['design'],'intro'=>'','conclu'=>'',
					'format'=>$formId,
					'nom_emplacement'=>$nom_emplacement, 
					'nom_du_site'=>$nom_site,
					'url_du_site'=>$url_site, 
					'desc_du_site'=>$desc_site, 
					'nb_pub'=>$nb_pub, 
					'nb_caracteres_titre'=>$nb_caracteres_titre, 
					'nb_caracteres_texte'=>$nb_caracteres_texte,
					'coul_bordure' => $coul_bordure, 
					'coul_fond' => $coul_fond, 
					'coul_titre' => $coul_titre, 
					'coul_desc' => $coul_desc, 
					'police' => $police, 
					'size_titre' => $size_titre, 
					'size_desc' => $size_desc, 
					'choix_tags'=>$choix_tag,
					'annu'=>$annu
					));
					break;
			}
			case 4:
			{
				//affectation des variables
				$nom_emplacement = '';
				$nom_site = '';
				$url_site = '';
				$desc_site = '';
				$nb_pub = '1';
				$format = '';
				$choix_cat = '';
				$choix_tag = '';
				
				
				//choix de la catégorie dans l'annuaire
				$requete2 = ('SELECT * FROM cat_annuaire ORDER BY cat_pos, id_cat ASC');
				$resultat2 = $db->requete($requete2);
				
				$annu = '';
				while($reponse2 = $db->fetch($resultat2))
				{	
					if($reponse2['id_cat_mere'] == 0)
					{
						$id_cat_mere = $reponse2['id_cat'];
						$id_choix = $reponse2['id_cat'];
						$cat_name = $reponse2['cat_name'];
						$selected = '';
					}
					else
					{	
						if (!empty($reponse1['id_cat']) AND ($reponse1['id_cat'] == $reponse2['id_cat']))
							$selected = 'selected="selected"';
						else
							$selected = '';
						
						$id_choix = $reponse2['id_cat'];
						if($reponse2['cat_chef'] == 1)
							$cat_name = '&nbsp; &rArr; '.$reponse2['cat_name'];
						else
							$cat_name = '&nbsp; &nbsp; &nbsp; &raquo; '.$reponse2['cat_name'];
					}
					//$data = parse_boucle('LISTE',$data,false,array('LISTE.selected'=>$selected, 'LISTE.id_choix'=>$id_choix, 'LISTE.nom_choix'=>$cat_name));
					$annu .= '<option value="'.$id_choix.'" '.$selected.'>'.$cat_name.'</option>';		
				}
				
				echo parse_var(get_file(ROOT.'templates/fr/campagne/clic_image_468_60.tpl'),
				array('ROOT'=>'',
				'design'=>$_SESSION['design'],
				'format'=>$formId,
				'nom_emplacement'=>$nom_emplacement, 
				'nom_du_site'=>$nom_site,
				'url_du_site'=>$url_site, 
				'desc_du_site'=>$desc_site,
				'nb_pub'=>$nb_pub, 				
				'choix_tags'=>$choix_tag,
				'annu'=>$annu
				));
			
			break;
			}
			case 5:
			{
				//affectation des variables
				$nom_emplacement = '';
				$nom_site = '';
				$url_site = '';
				$desc_site = '';
				$nb_pub = '1';
				$format = '';
				$choix_cat = '';
				$choix_tag = '';
				
				
				//choix de la catégorie dans l'annuaire
				$requete2 = ('SELECT * FROM cat_annuaire ORDER BY cat_pos, id_cat ASC');
				$resultat2 = $db->requete($requete2);
				
				$annu = '';
				while($reponse2 = $db->fetch($resultat2))
				{	
					if($reponse2['id_cat_mere'] == 0)
					{
						$id_cat_mere = $reponse2['id_cat'];
						$id_choix = $reponse2['id_cat'];
						$cat_name = $reponse2['cat_name'];
						$selected = '';
					}
					else
					{	
						if (!empty($reponse1['id_cat']) AND ($reponse1['id_cat'] == $reponse2['id_cat']))
							$selected = 'selected="selected"';
						else
							$selected = '';
						
						$id_choix = $reponse2['id_cat'];
						if($reponse2['cat_chef'] == 1)
							$cat_name = '&nbsp; &rArr; '.$reponse2['cat_name'];
						else
							$cat_name = '&nbsp; &nbsp; &nbsp; &raquo; '.$reponse2['cat_name'];
					}
					//$data = parse_boucle('LISTE',$data,false,array('LISTE.selected'=>$selected, 'LISTE.id_choix'=>$id_choix, 'LISTE.nom_choix'=>$cat_name));
					$annu .= '<option value="'.$id_choix.'" '.$selected.'>'.$cat_name.'</option>';		
				}
				
				echo parse_var(get_file(ROOT.'templates/fr/campagne/aff_image_300_250.tpl'),
				array('ROOT'=>'',
				'design'=>$_SESSION['design'],
				'format'=>$formId,
				'nom_emplacement'=>$nom_emplacement, 
				'nom_du_site'=>$nom_site,
				'url_du_site'=>$url_site, 
				'desc_du_site'=>$desc_site,
				'nb_pub'=>$nb_pub, 				
				'choix_tags'=>$choix_tag,
				'annu'=>$annu
				));
			
			break;
			}
			case 6:
			{
				//affectation des variables
				$nom_emplacement = '';
				$nom_site = '';
				$url_site = '';
				$desc_site = '';
				$nb_pub = '1';
				$format = '';
				$choix_cat = '';
				$choix_tag = '';
				
				
				//choix de la catégorie dans l'annuaire
				$requete2 = ('SELECT * FROM cat_annuaire ORDER BY cat_pos, id_cat ASC');
				$resultat2 = $db->requete($requete2);
				
				$annu = '';
				while($reponse2 = $db->fetch($resultat2))
				{	
					if($reponse2['id_cat_mere'] == 0)
					{
						$id_cat_mere = $reponse2['id_cat'];
						$id_choix = $reponse2['id_cat'];
						$cat_name = $reponse2['cat_name'];
						$selected = '';
					}
					else
					{	
						if (!empty($reponse1['id_cat']) AND ($reponse1['id_cat'] == $reponse2['id_cat']))
							$selected = 'selected="selected"';
						else
							$selected = '';
						
						$id_choix = $reponse2['id_cat'];
						if($reponse2['cat_chef'] == 1)
							$cat_name = '&nbsp; &rArr; '.$reponse2['cat_name'];
						else
							$cat_name = '&nbsp; &nbsp; &nbsp; &raquo; '.$reponse2['cat_name'];
					}
					//$data = parse_boucle('LISTE',$data,false,array('LISTE.selected'=>$selected, 'LISTE.id_choix'=>$id_choix, 'LISTE.nom_choix'=>$cat_name));
					$annu .= '<option value="'.$id_choix.'" '.$selected.'>'.$cat_name.'</option>';		
				}
				
				echo parse_var(get_file(ROOT.'templates/fr/campagne/clic_image_300_250.tpl'),
				array('ROOT'=>'',
				'design'=>$_SESSION['design'],
				'format'=>$formId,
				'nom_emplacement'=>$nom_emplacement, 
				'nom_du_site'=>$nom_site,
				'url_du_site'=>$url_site, 
				'desc_du_site'=>$desc_site,
				'nb_pub'=>$nb_pub, 				
				'choix_tags'=>$choix_tag,
				'annu'=>$annu
				));
			
			break;
			}
			default:
			{
				echo "false1";
			break;
			}
		}
	}
	else
	{
		echo "test";
	}
}
else
{
	echo "false3";
}
?>