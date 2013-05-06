<?php
require('top.php');
?>
<div id="centre">

<?php

//Verification auth
if(!isAuth())
{
echo "<h1>Vous n'êtes pas autorisés à créer des groupes. Authentifiez vous auparavant.</h1>";
}

//Si authentifié
else
{
	$user=$_SESSION['login'];
	if(isset($_POST['groupe'])&&($_POST['groupe']=='sub'))
	{
		// ajout groupe
		$res=$bdd->query("INSERT INTO GROUPE (ID_GROUPE,ID_USERS,NOM) VALUES(".$_SESSION['uid'].",".$_POST['nom'].")");
		$idgroupe=$bdd->lastInsertId();
		
		//ajout users
		$indice=1;
		while(isset($_POST['user'.$indice))
		{
		$res=$bdd->query("INSERT INTO FONT_PARTIE (ID_USERS,ID_GROUPE) VALUES('".$_POST['user'.$ite]."',".$idgroupe." )");
		$indice++;
		}
	}


	else
	{
	//formulaire
	?>
		
		<form action="creationgroupe.php" method="post">
		<input type="hidden" name="groupe" value="sub">
		<fieldset>
		<legend>Nom</legend>
		<label for="nom">Nom : </label>
		<input type="text" id="nom" name="nom"/> <br/>
		</fieldset>
		<fieldset id="ajoutuser">
		<legend> Ajout d'utilisateurs </legend>
		<script type="text/javascript">
			var nbu=2;
			function adduser()
			{
				nbu++;
				var q=document.getElementById("ajoutuser");
				var form=document.createElement("div");
				var html="<label for=\"user"+nbu+"\">Id de l'utilisateur "+nbu"+</label><input type=\"text\" id=\"user"+nbu+"\" name=\"user"+nbu+"\"/><br/>"+"style=\"margin-left:2%;\">";
				form.innerHTML=html;
				q.appendChild(form);
			}
		</script>
		<label for="user1"> Id de l'utilisateur 1: </legend>
		<input type="text" id="user1" name="user1"/><br />
		</fieldset>
		<input type="button" value="Ajouter un utilisateur" onclick="adduser();"/><br />
		<input type="submit" value="Valider"/>
		</form>
		<?php
	}
}

echo "</div>";
require('bottom.php');
?>