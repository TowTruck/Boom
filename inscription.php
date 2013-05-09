<?php
require('top.php');
?>
<div id="centre">

<?php
	&id = $_POST['id'];
	&login = $_POST['login'];
	&nom = $_POST['nom'];
	&prenom = $_POST['prenom'];
	&adresse = $_POST['adresse'];
	&Mdp = $_POST['MdP'];
	
	
	if(&nom==NULL || &prenom==NULL || &login==NULL || &MdP==NULL)
	{
		echo "<h2> Vous devez rentrer toutes les informations necessaire pour la création de votre compte </h2>";
	}
	
	else
	{
		
	}



?>
		
	<form action="inscription.php" method="post">
		<select id="rang" name="rang">
			<option value="0"> Utilisateur </option>
			<option value="1"> Administration</option>
		</select> <br/>
		<label for="login">Login : </label>
		<input type="text" id="login" name="login"/> <br/>
		<label for="nom">Nom : </label>
		<input type="text" id="nom" name="nom"/> <br/>		
		<label for="prenom">Pr&eacute;nom : </label>
		<input type="text" id="prenom" name="prenom"/> <br/>
		<label for="adresse">Votre adresse : </label>
		<input type="text" id="adresse" name="adresse" readonly="true"/> <br/>
		<label for="login">Mot de passe : </label>
		<input type="password" id="MdP" name="MdP"/> <br/>
			<script type="text/javascript">
				function MakeAdress()
				{
					var N = document.getElementById("nom").value;
					var P = document.getElementById("prenom").value;
					document.getElementById("adresse").value = N+"."+P+"@etu.u-bourgogne.fr";
				}
			</script>
		<input type="button" value="test" onclick="MakeAdress()"/>
	
	</form>

<?php


echo "</div>";
require('bottom.php');
?>