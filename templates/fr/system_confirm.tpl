<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Confirmation</title>
		<link rel="stylesheet" href="{DOMAINE}/templates/css/{DESIGN}/commun.css" />
		<link rel="stylesheet" href="{DOMAINE}/templates/css/{DESIGN}/formulaire.css" />
		<link rel="stylesheet" href="{DOMAINE}/templates/css/{DESIGN}/alerte.css" />
		<style type="text/css">
			label{
				float:left;
				width:150px;
			}
		</style>
	</head>
	<body>
		<div class="validation">
			<div class="validation_hg">
				<div class="validation_hd">
					<h2>Confirmation</h2>
				</div>
			</div>
			<div class="validation_cg">
				<div class="validation_cd">
					<form action="{url}" method="post">
						{message}
						<div class="send buttons">
							<input type="hidden" name="valider" value="1" />
							<button type="submit" value="Oui" class="positive">
								<img src="{DOMAINE}/templates/images/{DESIGN}/tick.png" alt="Répondre"/>
								Oui
							</button>
							<button type="button" onclick="javascript:history.back(-1);" value="Non" class="negative">
								<img src="{DOMAINE}/templates/images/{DESIGN}/cross.png" alt="Non"/> 
								Non
							</button>
						</div>
					</form>
				</div>
			</div>
			<div class="validation_bg">
				<div class="validation_bd">
					<div class="validation_b">
						&nbsp;
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
