<?php
require('top.php');
?>
<div id="centre">

<?php

//validation des qcms

if(isset($_POST['validation'])&&($_POST['validation']=='val'))
{
	$select=$bdd->query("SELECT ID_QCM FROM QCM WHERE ID_QCM IN (SELECT ID_QCM FROM LIAISON WHERE ID_GROUPE = 0);");
	$select->setFetchMode(PDO::FETCH_OBJ);
	while($ligne=$select->fetch())
	{
		//si validation
		if (isset($_POST['val'.$ligne->ID_QCM])) 
		{
			if($_POST['val'.$ligne->ID_QCM] == 'validation')
			{
			$maj=$bdd->query("UPDATE LIAISON SET ID_GROUPE=1 WHERE ID_QCM='".$ligne->ID_QCM."';");
			echo '<h2> QCM'.$ligne->ID_QCM.' valid&eacute;';
			}
	
		//si suppression
			else 
			{
				$del=$bdd->query("DELETE FROM LIAISON WHERE ID_QCM='".$ligne->ID_QCM."';");
				$del=$bdd->query("DELETE FROM QCM WHERE ID_QCM='".$ligne->ID_QCM."';");
				echo '<h2> QCM'.$ligne->ID_QCM.' supprim&eacute;';
			}
		}
	}
}


//suppression des utilisateurs

if(isset($_POST['suppr'])&&($_POST['suppr']=='del'))
{
	//on verif si checkbox cochee
	$select=$bdd->query("SELECT ID_USERS FROM USERS;");
	$select->setFetchMode(PDO::FETCH_OBJ);
	while($ligne=$select->fetch())
	{
		if (isset($_POST[$ligne->ID_USERS])) 
		{
			//on supprime l'utilisateur et où il est propriétaire de groupe/qcm, on met l'admin en proprio
			$up=$bdd->query("UPDATE GROUPE USERS SET ID_USERS = 1 WHERE ID_USERS='".$ligne->ID_USERS."';");
			$up=$bdd->query("UPDATE QCM USERS SET ID_USERS = 1 WHERE ID_USERS='".$ligne->ID_USERS."';");
			$suppr=$bdd->query("DELETE FROM REPOND WHERE ID_USERS='".$ligne->ID_USERS."';");
			$suppr=$bdd->query("DELETE FROM FONT_PARTIE WHERE ID_USERS='".$ligne->ID_USERS."';");
			$suppr=$bdd->query("DELETE FROM USERS WHERE ID_USERS='".$ligne->ID_USERS."';");
			echo '<h2> Utilisateur ayant pour id '.$ligne->ID_USERS.' supprime du groupe.</h2>';

		}
	}
}

if(!isAdmin())
{
	echo '<h2>Page r&eacute;serv&eacute;e &agrave; l\'administration.';
} 
else
{
	echo'<h2> QCM en attente de validation </h2>';
	echo '<form action="administration.php" method="post">';
			echo '<input type="hidden" name="validation" value="val">';
			echo "<table>";
			echo "<tr><td> Id du createur </td> <td> Intitul&eacute; du QCM </td> <td> Valider le QCM? </td><td> Supprimer le QCM </td></tr>";
			$select1 = $bdd->query("SELECT * FROM QCM WHERE ID_QCM IN (SELECT ID_QCM FROM LIAISON WHERE ID_GROUPE = 0);");
			$select1->setFetchMode(PDO::FETCH_OBJ);
			while( $enregistrement1 = $select1->fetch())
			{
				
				echo '<tr><td>'.$enregistrement1->ID_USERS.'<td><a href="qcm.php?id='.$enregistrement1->ID_QCM.'" target="_blank">'.$enregistrement1->INTITULE.'</a></td><td> <input type="radio" id="val'.$enregistrement1->ID_QCM.'" name="val'.$enregistrement1->ID_QCM.'" value="validation" /></td><td> <input type="radio" id="sup'.$enregistrement1->ID_QCM.'" name="val'.$enregistrement1->ID_QCM.'" value="suppression"/></td></tr>';
				
			}
			echo"</table>";
			echo '<input type="submit" value="Valider/Supprimer"/>';
			echo "</form>";

	
	echo'<h2> Gestion des utilisateurs </h2>';
	echo '<form action="administration.php" method="post">';
			echo '<input type="hidden" name="suppr" value="del">';
			echo "<table>";
			echo "<tr><td> Id </td> <td> Nom </td> <td> Prenom </td> <td> Supprimer l'utilisateur? </td></tr>";
			$select1 = $bdd->query("SELECT NOM,PRENOM,ID_USERS,ID_RANG FROM USERS;");
			$select1->setFetchMode(PDO::FETCH_OBJ);
			while( $enregistrement1 = $select1->fetch())
			{
				if($enregistrement1->ID_RANG == 1)
				{
					echo '<tr><td>'.$enregistrement1->ID_USERS.'<td>'.$enregistrement1->PRENOM.'</td><td> '.$enregistrement1->NOM.'</td><td>Administrateur</td></tr>';
				}
				else
				{
					echo '<tr><td>'.$enregistrement1->ID_USERS.'<td>'.$enregistrement1->PRENOM.'</td><td> '.$enregistrement1->NOM.'</td><td><input type="checkbox" id="'.$enregistrement1->ID_USERS.'" name="'.$enregistrement1->ID_USERS.'" /></tr>';
				}
			}
			echo"</table>";
			echo '<input type="submit" value="Supprimer"/>';
			echo "</form>";
}

echo "</div>";
require('bottom.php');
?>