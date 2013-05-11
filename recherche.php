<?php
require('top.php');
?>

<div id="Centre">
<title>Recherche</title>
<?php 
if(empty($_POST['recherche']))
{
  echo "Veuillez saisir une recherche !";
}
else
{
	$recherche = $_POST['recherche'];
	$nb = 0;	
	
	//Affichage des qcm publics
	$req = $bdd->query("SELECT QCM.ID_QCM,QCM.INTITULE,LIAISON.ID_GROUPE FROM QCM,LIAISON WHERE QCM.INTITULE LIKE '%".$recherche."%' AND LIAISON.ID_GROUPE=1 AND QCM.ID_QCM=LIAISON.ID_QCM;");
	$req->setFetchMode(PDO::FETCH_OBJ);
	while( $res = $req->fetch() )
	{
		echo '<a href="qcm.php?id='.$res->ID_QCM.'">'.$res->INTITULE.'</a><br>';
		$nb++;
	}
	
	//Si authentifié on ajoute les qcm reservé a son groupe
	if(isAuth())
	{
	$req = $bdd->query("SELECT QCM.ID_QCM,QCM.INTITULE,LIAISON.ID_GROUPE,FONT_PARTIE.ID_USERS,FONT_PARTIE.ID_GROUPE FROM QCM,LIAISON,FONT_PARTIE WHERE QCM.INTITULE LIKE '%".$recherche."%' AND QCM.ID_QCM=LIAISON.ID_QCM AND LIAISON.ID_GROUPE=FONT_PARTIE.ID_GROUPE AND FONT_PARTIE.ID_USERS=".$_SESSION['uid'].";");
	$req->setFetchMode(PDO::FETCH_OBJ);
	while( $res = $req->fetch() )
	{
		echo '<a href="qcm.php?id='.$res->ID_QCM.'">'.$res->INTITULE.'</a><br>';
		$nb++;
	}
	}
	
	
	if($nb == 0)
	{
		echo "Aucun résultat pour votre recherche";
	}
	else
	{
		echo $nb." résultat(s) trouvé(s)";
	}
}
?>
</div>

<?php
require('bottom.php');
?>
