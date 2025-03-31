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

//Fonction renvoyant le code de la touche appuyée lors d'un événement clavier
function getKeyCode(evenement)
{
    for (prop in evenement)
    {
        if(prop == 'which')
        {
            return evenement.which;
        }
    }
	alert(event.keyCode);
    return event.keyCode;
}

//Fonction renvoyant une valeur "aléatoire" pour forcer le navigateur (ie...)
//à envoyer la requête de mise à jour
function ieTrick(sep)
{
	d = new Date();
	trick = d.getYear() + "ie" + d.getMonth() + "t" + d.getDate() + "r" + d.getHours() + "i" + d.getMinutes() + "c" + d.getSeconds() + "k" + d.getMilliseconds();

	if (sep != "?")
	{
		sep = "&";
	}

	return sep + "ietrick=" + trick;
}



//On ne pourra éditer qu'une valeur à la fois
var editionEnCours = false;

//variable évitant une seconde sauvegarde lors de la suppression de l'input
var sauve = false;

//Fonction de modification inline de l'élément double-cliqué
function inlineMod(id, obj)
{
	if(editionEnCours)
	{
		return false;
	}
	else
	{
		editionEnCours = true;
		sauve = false;
	}

	//Objet servant à l'édition de la valeur dans la page
	var calqueGroupe = null;
	var backupFirstChild  = obj.firstChild;
	var input = null;
	var ht = null;

	//Assignation de la valeur
	XHR = getXMLHTTP();

	if(!XHR)
	{
		return false;
	}
	XHR.open("POST", "ajax/load_edit.php", true);
	XHR.onreadystatechange = function()
	{
		
		if (XHR.readyState == 4)
		{
			var backupHeight = obj.offsetHeight;
			var baseHeight = obj.offsetHeight;
			
			input = document.createElement("textarea");
			
			boutonSauver = document.createElement("a");
			textSauver = document.createTextNode("Modifier");
			boutonSauver.appendChild(textSauver);
			boutonSauver.href = "#r"+id;
			
			boutonAnnuler = document.createElement("a");
			textAnnuler = document.createTextNode("Annuler");
			boutonAnnuler.appendChild(textAnnuler);
			boutonAnnuler.href = "#r"+id;
			
			input.innerHTML = XHR.responseText;
			
			calqueGroup = document.createElement("div");
			var calqueClass = document.createAttribute("class");
			calqueClass.nodeValue = "edition_rapide";
			calqueGroup.setAttributeNode(calqueClass);
			
			calqueGroup.style.width  = obj.offsetWidth - 15 + "px";

			calqueGroup.style.height  =  baseHeight * 1.5 + "px";
			obj.style.height = obj.offsetHeight * 1.6 +"px";

			input.style.width = 100 + "%";
			input.style.height  =  baseHeight * 1 + "px";
			
			
			calqueGroup.style.position = "absolute";
			calqueGroup.appendChild(input);
			calqueGroup.appendChild(document.createElement("br"));
			
			//sauvegarde
			//input.onblur
			boutonSauver.onclick = function sortir(){
				sauverMod(id, obj, input.value);
				obj.style.height = backupHeight + "px";
				delete calqueGroup;
			};
			
			boutonAnnuler.onclick = function supprimer(){
				obj.replaceChild(backupFirstChild,obj.firstChild);
				obj.style.height = backupHeight + "px";
				editionEnCours = false;
				delete calqueGroup;
			};
			
			calqueGroup.appendChild(boutonSauver);
			calqueGroup.appendChild(boutonAnnuler);
			
			if(input.value != '0') obj.replaceChild(calqueGroup, obj.firstChild);
			//On donne le focus à l'input et on sélectionne le texte qu'il contient
			input.focus();
			input.select();
		}
	}
	XHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded;Charset=ISO-8859-1");
	var var_transmettre = "id="+id;
	XHR.send(var_transmettre);
}

function escapeURI(La){
  if(encodeURIComponent) {
    return encodeURIComponent(La);
  }
  if(escape) {
    return escape(La)
  }
}


//Objet XMLHTTPRequest
var XHR = null;

//Fonction de sauvegarde des modifications apportées
function sauverMod(id, obj,valeur)
{
	//Si on a déjà sauvé la valeur en cours, on sort
	if(sauve)
	{
		return false;
	}
	else
	{
		sauve = true;
	}	

	//Si l'objet existe déjà on abandonne la requête et on le supprime
	if(XHR && XHR.readyState != 0)
	{
		XHR.abort();
		delete XHR;
	}

	//Création de l'objet XMLHTTPRequest
	XHR = getXMLHTTP();

	if(!XHR)
	{
		return false;
	}

	//URL du script de sauvegarde auquel on passe la valeur à modifier
	XHR.open("POST", "ajax/save_edit.php", true);
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
	XHR.Charset="ISO-8859-1";
	XHR.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	valeur = escapeURI(valeur);
	var var_transmettre = "m="+id+"&texte="+valeur;
	XHR.send(var_transmettre);	
}