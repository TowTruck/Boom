<?php
require('top.php');
?>
<div id="centre">

<?php
	
	// recuperation du groupe
	$idg=$_GET['id'];
	//Verification que l'utilisateur est le propriétaire du groupe, si oui, on affiche les utilisateurs du groupe pour pouvoir les supprimer
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
	?>
<?php


echo "</div>";
require('bottom.php');
?>