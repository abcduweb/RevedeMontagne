<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<script type="text/javascript" src="{DOMAINE}/templates/js/upload.js"></script>
		<title>{titre_page}</title>
		<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/commun.css" />
		<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/polices.css" />
		<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/news.css" />
		<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/tableaux.css" />
		<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/upload.css" />
		<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel='stylesheet' />
	</head>
<body onload="init();">

	<form id="upload" method="post" action="{DOMAINE}sorties/upload.php?idp={idp}" enctype="multipart/form-data">
		<div id="drop">
				Glisser vos photos ici
			<a>Parcourir</a>
			<input type="file" name="upl" multiple />
		</div>

		<ul>
		<!-- The file uploads will be shown here -->
		</ul>
	</form>
<!-- JavaScript Includes -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="{DOMAINE}/templates/js/assets/jquery.knob.js"></script>

<!-- jQuery File Upload Dependencies -->
	<script src="{DOMAINE}/templates/js/assets/jquery.ui.widget.js"></script>
	<script src="{DOMAINE}/templates/js/assets/jquery.iframe-transport.js"></script>
	<script src="{DOMAINE}/templates/js/assets/jquery.fileupload.js"></script>

<!-- Our main JS file -->
	<script src="templates/js/assets/script.js"></script> 

	</body>
</html>