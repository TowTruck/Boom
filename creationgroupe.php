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
		//si public (peut importe la casse)
		if(strcasecmp($_POST['nom'], "public") == 0)
		{
			echo "<h2>Vous ne pouvez pas utiliser ce nom pour un groupe </h2>";
		}
		else
		{
			// ajout groupe
			$res=$bdd->query("INSERT INTO GROUPE (ID_USERS,NOM) VALUES(".$_SESSION['uid'].",'".$_POST['nom']."')");
			$idgroupe=$bdd->lastInsertId();
		
			//ajout users
			$indice=1;
			while(isset($_POST['user'.$indice]))
			{
				// verifier avant le premier insert
				$select=$bdd->query("SELECT COUNT(*) AS COMPT FROM USERS WHERE MAIL= '".$_POST['user'.$indice]."' AND VALIDE IS NULL ;");
				$select->setFetchMode(PDO::FETCH_OBJ);
				$ligne=$select->fetch();
				if($ligne->COMPT == 0){
					echo "<h2>L'utilisateur ayant le mail ".$_POST['user'.$indice]." n'est pas enregistr&eacute; ou non valid&eacute;. Si vous avez fait une erreur, ajoutez cet utilisateur sur la page du groupe</h2>";
				
				}
			
		
				//recupere id associé au mail
				//si pas de ligne echo de l'adresse mail qui marche pas, plus verif champ valid null quand mis en place donc echo différent
				else {
				
				$ident = $bdd->query("SELECT ID_USERS AS ID FROM USERS WHERE MAIL= '".$_POST['user'.$indice]."';");
				$ident->setFetchMode(PDO::FETCH_OBJ);
				$ide=$ident->fetch();
				$res=$bdd->query("INSERT INTO FONT_PARTIE (ID_USERS,ID_GROUPE) VALUES(".$ide->ID.",".$idgroupe." )");
				echo "<h2>L'utilisateur ayant le mail ".$_POST['user'.$indice]." a &eacute;t&eacute; ajout&eacute; au groupe.</h2><br />";
				}
				
				$indice++;
			}
		}
	}


	else
	{
	//formulaire
	?>
		
		<form action="creationgroupe.php" method="post">
		<input type="hidden" name="groupe" value="sub">
		<label for="nom">Nom : </label>
		<input type="text" id="nom" name="nom"/> <br/>
		<fieldset id="ajoutuser">
		<legend> Ajout d'utilisateurs </legend>
		<script type="text/javascript">
			var nbu=1;
			function adduser()
			{
				nbu++;
				var q=document.getElementById("ajoutuser");
				var form=document.createElement("div");
				var html="<label for=\"user"+nbu+"\">Mail de l'utilisateur "+nbu+" :</label><input type=\"text\" id=\"user"+nbu+"\" name=\"user"+nbu+"\"/><br/>";
				form.innerHTML=html;
				q.appendChild(form);
			}
		</script>
		<label for="user1"> Mail l'utilisateur 1: </label>
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