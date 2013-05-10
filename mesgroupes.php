<?php
require('top.php');

/* Page mesgroupes
Pramètres (SESSION) : id de l'utilisateur

Description :
Affiche la liste des groupes créés par l'utilisateur en paramètres
Affiche la liste de ceux auxquels il appartient
Permet d'accéder à la page de création de groupe
*/

try {
  $my_id = (isset($_SESSION['uid']))?$_SESSION['uid']:0;

	if($my_id > 0 and isAuth())
	{
?>

<div id="Centre">
<title>Mes groupes</title>
	<div id="chef">
	<h1>Ceux que j'ai créés</h1>
	
	<?php
		$select = $bdd->query("SELECT * FROM GROUPE WHERE ID_USERS = ".$my_id.";");
		$select->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement = $select->fetch() )
		{
			echo '<a href="groupe.php?id='.$enregistrement->ID_GROUPE.'">'.$enregistrement->NOM.'</a><br>';
		}
	?>
	
	</div>
	<div id="groupes">
	<h1>Ceux auxquels j'appartiens</h1>
	
	<?php
		$select = $bdd->query("SELECT * FROM GROUPE WHERE ID_GROUPE IN (SELECT ID_GROUPE FROM FONT_PARTIE WHERE ID_USERS = ".$my_id.");");
		$select->setFetchMode(PDO::FETCH_OBJ);
		while( $enregistrement = $select->fetch() )
		{
			echo '<a href="groupe.php?id='.$enregistrement->ID_GROUPE.'">'.$enregistrement->NOM.'</a><br>';
		}
	?>
	
	</div>

	<h1>Je veux créer un groupe</h1>
	<a href="creationgroupe.php">Créer un groupe</a>
</div>

<?php
	}
	else
	{
		echo "id utilisateur inconnu ou non authentifié";
	}

}catch ( Exception $e ) {
	echo "Connection à MySQL impossible : ", $e->getMessage();
	die();
}

require('bottom.php');

?>
