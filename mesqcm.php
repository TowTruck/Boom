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

<div id="content">
	<div id="crees">
	<h1>Ceux que j'ai créés</h1>
	
	<?php
		$select = $bdd->query("SELECT * FROM QCM WHERE ID_USERS = ".$my_id.";");
		$select->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement = $select->fetch() )
		{
			echo $enregistrement->INTITULE.'<br>';
		}
	?>
	
	</div>
	<div id="repondu">
	<h1>Ceux auxquels j'ai répondu</h1>
	
	<?php
		$select = $bdd->query("SELECT * FROM QCM WHERE QCM.ID_QCM IN (SELECT ID_QCM FROM REPOND WHERE ID_USERS = ".$my_id.");");
		$select->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement = $select->fetch() )
		{
			echo $enregistrement->INTITULE.', note : '.$enregistrement->NOTE.'<br>';
		}
	?>
	
	</div>
	<div id="possibles">
	<h1>Ceux auxquels je peux répondre</h1>
	
	<?php
		$select = $bdd->query("SELECT * FROM QCM WHERE ID_USERS <> ".$my_id." AND QCM.ID_QCM NOT IN (SELECT ID_QCM FROM REPOND WHERE ID_USERS = ".$my_id.");");
		$select->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement = $select->fetch() )
		{
			echo '<a href="qcm.php?id='.$enregistrement->ID_QCM.'">'.$enregistrement->INTITULE.'</a><br>';
		}
	?>
	
	</div>

	<h1>Je veux créer un qcm</h1>
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
