<?php
require('top.php');
?>
<div id="centre">

<?php
	
	$idg=$_GET['id'];

	//si ajout d'utilisateur
	if(isset($_POST['groupe'])&&($_POST['groupe']=='sub'))
	{
		$indice=1;
		while(isset($_POST['user'.$indice]))
		{
			// verifier avant le premier insert
			$select=$bdd->query("SELECT COUNT(*) AS COMPT FROM USERS WHERE MAIL= '".$_POST['user'.$indice]."' AND VALIDE IS NULL ;");
			$select->setFetchMode(PDO::FETCH_OBJ);
			$ligne=$select->fetch();
			if($ligne->COMPT == 0){
				echo "<h2>L'utilisateur ayant le mail ".$_POST['user'.$indice]." n'est pas enregistr&eacute; ou non valid&eacute;. SI vous avez fait une erreur, ajoutez cet utilisateur sur la page du groupe</h2>";
				
			}
			
		
			//recupere id associé au mail
			//si pas de ligne echo de l'adresse mail qui marche pas, plus verif champ valid null quand mis en place donc echo différent
			else {
			
			$ident = $bdd->query("SELECT ID_USERS AS ID FROM USERS WHERE MAIL= '".$_POST['user'.$indice]."';");
			$ident->setFetchMode(PDO::FETCH_OBJ);
			$ide=$ident->fetch();
			$res=$bdd->query("INSERT INTO FONT_PARTIE (ID_USERS,ID_GROUPE) VALUES(".$ide->ID.",".$idg." )");
			echo "<h2>L'utilisateur ayant le mail ".$_POST['user'.$indice]." a &eacute;t&eacute; ajout&eacute; au groupe.</h2><br />";
			}
			
			$indice++;
		}
	}
	// recuperation du groupe + informations
	
	
	$select=$bdd->query("SELECT * FROM USERS WHERE ID_USERS IN (SELECT ID_USERS FROM GROUPE WHERE ID_GROUPE=".$idg.");");
	$select->setFetchMode(PDO::FETCH_OBJ);
	$info=$select->fetch();
	echo "<h2>Le propri&eacute;taire du groupe est ".$info->PRENOM." ".$info->NOM.".</h2><br />";
	
	$nb=$bdd->query("SELECT COUNT(*) AS COMPT FROM FONT_PARTIE WHERE ID_GROUPE=".$idg." ;");
	$nb->setFetchMode(PDO::FETCH_OBJ);
	$nombre=$nb->fetch();
	echo "<h2>Le groupe a ".$nombre->COMPT." utilisateur(s).</h2><br />";
	
	echo "<h2>Les QCMs du groupe: </h2><br />";
	$nbqcm = $bdd->query("SELECT COUNT(*) AS COMPT FROM LIAISON WHERE ID_GROUPE=".$idg." ;");
	$nbqcm->setFetchMode(PDO::FETCH_OBJ);
	$nbqcms=$nbqcm->fetch();
	if($nbqcms->COMPT == 0)
		echo "<h2>Ce groupe n'a pas encore de QCM</h2><br />";
	else
	{
		$select = $bdd->query("SELECT * FROM QCM WHERE QCM.ID_QCM IN (SELECT ID_QCM FROM LIAISON WHERE ID_GROUPE=".$idg.");");
		$select->setFetchMode(PDO::FETCH_OBJ);
		$info=$select->fetch();
		while( $enregistrement = $select->fetch() )
		{
			echo '<a href="qcm.php?id='.$enregistrement->ID_QCM.'">'.$enregistrement->INTITULE.'</a><br>';
		}
	}
	//verification si propriétaire, affichage des utilisateurs du groupe si oui
	if(isAuth())
	{
		$my_id = $_SESSION['uid'];
		$select = $bdd->query("SELECT * FROM GROUPE WHERE ID_USERS=".$my_id." AND ID_GROUPE=".$idg.";");
		$select->setFetchMode(PDO::FETCH_OBJ);
		$info=$select->fetch();
		if($info->ID_GROUPE == $idg)
		{
			echo "<h2> Vous etes le propr&eacute;taire du groupe. Affichage de la gestion de utilisateurs<h2> <br /> <br />";
			echo "<table>";
			$select1 = $bdd->query("SELECT NOM,PRENOM FROM USERS WHERE ID_USERS IN (SELECT ID_USERS FROM FONT_PARTIE WHERE ID_GROUPE=".$idg.") ;");
			$select1->setFetchMode(PDO::FETCH_OBJ);
			while( $enregistrement1 = $select1->fetch() )
			{
				echo "<tr><td>".$enregistrement1->PRENOM."</td><td> ".$enregistrement1->NOM."</td></tr>";
			}
			echo"</table";
		
		//echo '<form action="groupe.php?id='.$idg.'" method="post">';		
		?>
		<form action="groupe.php?id=32" method="post">
		<input type="hidden" name="groupe" value="sub">
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
		<label for="user1"> Mail l'utilisateur 1: </legend>
		<input type="text" id="user1" name="user1"/><br />
		</fieldset>
		<input type="button" value="Ajouter un utilisateur" onclick="adduser();"/><br />
		<input type="submit" value="Valider"/>
		</form>
		<?php
		}
		
	}
	?>
<?php


echo "</div>";
require('bottom.php');
?>