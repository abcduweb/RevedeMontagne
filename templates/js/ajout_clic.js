// retourne un objet xmlHttpRequest.
// méthode compatible entre tous les navigateurs (IE/Firefox/Opera)
function getXMLHTTP()
{
    var xhr = null;
    if(window.XMLHttpRequest)
    { // Firefox et autres
        xhr = new XMLHttpRequest();
    }
    else if(window.ActiveXObject)
    { // Internet Explorer
        try
        {
            xhr = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e)
        {
            try
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e1)
            {
                xhr = null;
            }
        }
    }
    else
    { // XMLHttpRequest non supporté par le navigateur
        alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
    }

    return xhr;
}


function ajout_clic(id)
{

	//Création de l'objet XMLHTTPRequest
	XHR = getXMLHTTP();

	
	var lien = null;
	var idlien = ajout_clic;
	lien = "idlien="+idlien; 


	//URL du script de sauvegarde auquel on passe la valeur à modifier
	XHR.open("GET", "modules/regie/ajout_clic.php", true);
	XHR.onreadystatechange = function()
	{
		//Si le chargement est terminé
		if (XHR.readyState == 4)
		{
			editionEnCours = false;
			if(XHR.responseText != 0){
				obj.removeChild(obj.firstChild);
				obj.innerHTML = XHR.responseText;
				//obj.replaceChild(document.createTextNode(XHR.responseText), obj.firstChild);
			}
			else
			{
				alert("Vous n'etes pas autorisé à modifier ce message");
				obj.removeChild(obj.firstChild);
			}
		}
	}
	XHR.send(lien);	
}

