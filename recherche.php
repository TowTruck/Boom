<?php
require('top.php');
?>

<div id="Centre">

<?php 
if(empty($_POST['recherche']))
{
  echo "Veuillez saisir une recherche !";
}
else
{
	$recherche = $_POST['recherche'];
	$nb = 0;	
	
	$req = $bdd->query("SELECT * FROM QCM WHERE INTITULE = %".$recherche."%;");
	$req->setFetchMode(PDO::FETCH_OBJ);
	while( $res = $req->fetch() )
	{
		echo '<a href="qcm.php?id='.$res->ID_QCM.'">'.$res->INTITULE.'</a><br>';
		$nb++;
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
