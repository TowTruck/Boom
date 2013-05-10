<?php

require('top.php');

/* Page mesqcm
Pramètres (SESSION) : id de l'utilisateur

Description :
Affiche la liste des qcm créés par l'utilisateur en paramètres
Affiche la liste de ceux auxquels il a répondu
Affiche la liste de ceux auxquels il peut répondre
Permet d'accéder à la page de création de qcm
*/

try {
  $my_id = (isset($_SESSION['uid']))?$_SESSION['uid']:0;

	if($my_id > 0 and isAuth())
	{
?>

<div id="Centre">
<title>Mes qcm</title>
	<div id="crees">
	<h1>Ceux que j'ai créés</h1>
	
	<?php

		$select = $bdd->query("SELECT * FROM QCM WHERE ID_USERS = ".$my_id.";");
		$select->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement = $select->fetch() )
		{
			echo '<a href="qcm.php?id='.$enregistrement->ID_QCM.'">'.$enregistrement->INTITULE.'</a><br>';
		}
	?>
	
	</div>
	<div id="repondu">
	<br/><h1>Ceux auxquels j'ai répondu</h1>
	
	<?php
		
		$select = $bdd->query("SELECT REPOND.NOTE,QCM.INTITULE FROM REPOND,QCM WHERE QCM.ID_QCM=REPOND.ID_QCM AND REPOND.ID_USERS=".$my_id);
		$select->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement = $select->fetch() )
		{
			echo $enregistrement->INTITULE.' --> Note : '.$enregistrement->NOTE.'<br/>';
		}
	?>

	</div>
	<div id="possibles">
	<br/><h1>Ceux auxquels je peux répondre</h1>
	
	<?php
	// qcm auxquels l'user n'a pas encore répondu, et ceux dans les groupes où il est + qcm public
		$select = $bdd->query("SELECT * FROM QCM WHERE ID_USERS <> ".$my_id." AND QCM.ID_QCM NOT IN (SELECT ID_QCM FROM REPOND WHERE ID_USERS = ".$my_id.") AND QCM.ID_QCM IN (SELECT ID_QCM FROM LIAISON WHERE ID_GROUPE IN (SELECT ID_GROUPE FROM FONT_PARTIE WHERE ID_USERS=".$my_id."));");
		//$select = $bdd->query("SELECT * FROM QCM WHERE ID_USERS <> ".$my_id." AND QCM.ID_QCM NOT IN (SELECT ID_QCM FROM REPOND WHERE ID_USERS = ".$my_id.");");
		$select->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement = $select->fetch() )
		{
			echo '<a href="qcm.php?id='.$enregistrement->ID_QCM.'">'.$enregistrement->INTITULE.'</a><br/>';
		}
		
		$select1 = $bdd->query("SELECT * FROM QCM WHERE ID_QCM IN (SELECT ID_QCM FROM LIAISON WHERE ID_GROUPE=1);");
		$select1->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement1 = $select1->fetch() )
		{
			echo '<a href="qcm.php?id='.$enregistrement1->ID_QCM.'">'.$enregistrement1->INTITULE.'</a><br/>';
		}
	?>
	
	</div>

	<br/><h1>Je veux créer un qcm</h1>
		<a href="creationqcm.php">Créer un qcm</a>
</div>

<?php
	}
	else
	{
		echo "id utilisateur inconnu ou non authentifié";
	}

}catch ( Exception $e ) {
	echo "Erreur : ", $e->getMessage();
	die();
}

require('bottom.php');

?>
