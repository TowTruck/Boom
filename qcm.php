<?php
/*
Page reponse a un qcm

Si le qcm a été créer par l'utilisateur log, on affiche les résultats obtenus par les membres du groupes
Sinon on propose le qcm.

*/

require('top.php');
?>
<div id="centre">

<?php

function check_proprio()
{
$res=$bdd->query("SELECT ID_USERS FROM QCM WHERE ID_QCM=".$idqcm."");
$res->setFetchMode(PDO::FETCH_OBJ);
$ligne=$res->fetch();

if($ligne&&$ligne->ID_USERS)
{
return $ligne->ID_USERS==$_SESSION['uid'];
}

}

function autorisation_qcm()
{
//On regarde a qui est destiné ce qcm et s'il est public

$res=$bdd->query("SELECT QCM.NOTE,LIAISON.ID_GROUPE,GROUPE.NOM FROM QCM,GROUPE,LIAISON WHERE QCM.ID_QCM=".$idqcm." AND LIAISON.ID_QCM=QCM.ID_QCM AND GROUPE.ID_GROUPE=LIAISON.ID_GROUPE");
$res->setFetchMode(PDO::FETCH_OBJ);
$ligne=$res->fetch();

if($ligne&&$ligne->NOM!="public")
{
$noteqcm=$ligne->NOTE;
//QCM non public : On verifie que l'utilisateur appartient bien au groupe auquel ce qcm est reserve
$res=$bdd->query("SELECT COUNT(*) AS COMPT FROM GROUPE WHERE ID_USERS=".$_SESSION['uid']." AND ID_GROUPE=".$ligne->ID_GROUPE."");
$res->setFetchMode(PDO::FETCH_OBJ);
$ligne=$res->fetch();

	if($ligne&&$ligne->COMPT)
	{
	//L'utilisation appartient bien au groupe on verifie qu'il n'a pas deja effectué ce qcm s'il est noté
		if($noteqcm)
		{
		//Qcm note il faut verifie s'il ne l'a pas deja fait
		$res=$bdd->query("SELECT COUNT(*) AS COMPT FROM REPOND WHERE ID_USERS=".$_SESSION['uid']." AND ID_QCM=".$idqcm."");
		$res->setFetchMode(PDO::FETCH_OBJ);
		$ligne=$res->fetch();
			if($ligne&&$ligne->COMPT)
			{
			//Il l'a deja fait : Pas bon
			return false;
			}
			else
			{
			//Il ne l'a jamais fait : OK
			return true;
			}
		}
		else
		{
		//Qcm entrainement on peut le refaire
		return true;
		}

	}
	else
	{
	//L'utilisateur n'appartient pas au groupe auquel est destiné ce qcm
	return false;
	}

}
else
{
//QCM public
return true;
}

}

if(isset($_GET['id']))
{
$idqcm=$_GET['id'];

	if(isAuth()&&check_proprio())
	{
	//Cas ou c'est le proprietaire : Il faut affiché les notes des participants
	
	}
	else
	{
	//On verifie que l'on a le droit ou non d'effectuer ce qcm
	if(autorisation_qcm())
	{
	//On balance le qcm
	
	}
	else
	{
	//Interdiction de faire ce qcm
	echo "<h1>Erreur d'autorisations</h1>";
	}
	
	
	}




}
else
{
echo "<h1>Erreur</h1>";
}
echo "</div>";
require('bottom.php');
?>
