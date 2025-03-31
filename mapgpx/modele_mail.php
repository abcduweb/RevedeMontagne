<?php
// On va dabors définir le fichier à envoyer et à qui
$fichier = 'mon_fichier.pdf';
$destinataire = 'mon_client@son_fai.fr';
$sujet = 'Votre facture';
// On créer un boundary unique
$boundary = md5(uniqid(rand(), true));
// On met les entêtes
$entetes = 'Content-Type: multipart/mixed;'."n".' boundary="'.$boundary.'"';
$body = 'This is a multi-part message in MIME format.'."n";
$body .= '--'.$boundary."n";
// ici, c'est la première partie, notre texte HTML (ou pas !)
// Là, on met l'entête
$body .= 'Content-Type: text/html; charset="UTF-8"'."n";
// On peut aussi mettres les autres (voir à la fin)
$body .= "n";
// On remet un deuxième retour à la ligne pour dire que les entêtes sont finie, on peut afficher notre texte !
$body .= 'Bonjour,
Voici ci-joint la facture de Juillet 2008 a payer sous 2 heures';
// Le texte est finie, on va faire un saut à la ligne
$body .= "n";
// Et on commence notre deuxième partie qui va contenir le PDF
$body .= '--'.$boundary."n";
// On lui dit (dans le Content-type) que c'est un fichier PDF
$body .= 'Content-Type: application/pdf; name="'.$fichier.'"'."n";
$body .= 'Content-Transfer-Encoding: base64'."n";
$body .= 'Content-Disposition: attachment; filename="'.$fichier.'"'."n";
// Les entêtes sont finies, on met un deuxième retour à la ligne
$body .= "n";
$source = file_get_contents($fichier);
$source = base64_encode ($source);
$source = chunk_split($source);
$body .= $source;
// On ferme la dernière partie :
$body .= "n".'--'.$boundary.'--';
// On envoi le mail :
mail($destinataire, $sujet, $body, $entetes);
?>