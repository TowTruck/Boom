<?php
/*
Page reponse a un qcm

Si le qcm a été créer par l'utilisateur log, on affiche les résultats obtenus par les membres du groupes
Sinon on propose le qcm.

*/

require('top.php');
?>
<div id="Centre">
<title>Qcm</title>
<?php

function check_proprio()
{
global $bdd,$idqcm;
$res=$bdd->query("SELECT ID_USERS FROM QCM WHERE ID_QCM=".$idqcm);

$res->setFetchMode(PDO::FETCH_OBJ);
$ligne=$res->fetch();

if($ligne&&$ligne->ID_USERS)
{
return ($ligne->ID_USERS==$_SESSION['uid']);
}

}

function autorisation_qcm()
{
//On regarde a qui est destiné ce qcm et s'il est public
global $bdd,$idqcm;
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

if(isset($_POST['qcm'])&&isset($_GET['id']))
{
/*-----------------------------------------------------------------
				Section soumission d'un qcm
-------------------------------------------------------------------
*/
$idqcm=$_GET['id'];
$select = $bdd->query("SELECT * FROM QUESTIONS WHERE ID_QCM = ".$idqcm." ORDER BY ID_QUESTIONS ASC");
$select->setFetchMode(PDO::FETCH_OBJ);

$score=0;
$total=0;

while( $enregistrement = $select->fetch() )
{
	$select2 = $bdd->query("SELECT * FROM REPONSES WHERE ID_QUESTIONS = ".$enregistrement->ID_QUESTIONS." ORDER BY ID_REPONSES ASC");
	$select2->setFetchMode(PDO::FETCH_OBJ);
	$q_ok=true;
	while( $enregistrement2 = $select2->fetch() )
	{
	//Si pas coché et reponse vrai OU coché et reponse fausse ALORS question invalidé.
	if(((!(isset($_POST[$enregistrement2->ID_REPONSES])))&&$enregistrement2->VALEUR)||((isset($_POST[$enregistrement2->ID_REPONSES]))&&(!($enregistrement2->VALEUR))))
	{
	$q_ok=false;
	}
		
	}
	if($q_ok)
	{
	$score++;
	}
	$total++;
	
}

$select = $bdd->query("SELECT NOTE FROM QCM WHERE ID_QCM = ".$idqcm);
$select->setFetchMode(PDO::FETCH_OBJ);
$ligne=$select->fetch();

if(isAuth()&&$ligne->NOTE)
{
$select = $bdd->query("INSERT INTO REPOND (ID_USERS,ID_QCM,NOTE) VALUES (".$_SESSION['uid'].",".$idqcm.",".$score.")");
echo "Note correctement enregistrée. <br/><h1>Votre score est de ".$score." sur ".$total."</h1>";
}
else
{
echo "<h1>Votre score est de ".$score." sur ".$total."</h1>";
}

}
else
{

if(isset($_GET['id']))
{
$idqcm=$_GET['id'];
	if(isAuth()&&check_proprio())
	{
	/*-----------------------------------------------------------------
				Section affichage des notes des participants
	-------------------------------------------------------------------
	*/
	echo "Tu es proprio";
	}
	else
	{

	//On verifie que l'on a le droit ou non d'effectuer ce qcm
	if(autorisation_qcm())
	{
	/*-----------------------------------------------------------------
				Section affichage du qcm
	-------------------------------------------------------------------
	*/
	?>
<form action="" method="post">
<input type="hidden" name="qcm" value="sub">
	<?php
// Récupère toutes les question du QCM
$select = $bdd->query("SELECT * FROM QUESTIONS WHERE ID_QCM = ".$idqcm." ORDER BY ID_QUESTIONS ASC");
$select->setFetchMode(PDO::FETCH_OBJ);
while( $enregistrement = $select->fetch() )
{
// Affichage de la question
	echo "<div id=\"question_".$enregistrement->ID_QUESTIONS."\" class=\"question\">";
	echo "<h2>Question : ".$enregistrement->INTITULE."</h2><br/>";

	// Récupère les réponses à une question
	$select2 = $bdd->query("SELECT * FROM REPONSES WHERE ID_QUESTIONS = ".$enregistrement->ID_QUESTIONS." ORDER BY ID_REPONSES ASC");
	$select2->setFetchMode(PDO::FETCH_OBJ);

	while( $enregistrement2 = $select2->fetch() )
	{
		// Affichage des réponses
		echo "<label for=\"".$enregistrement2->ID_REPONSES."\">".$enregistrement2->NOM."   </label>";
		echo "<input type=\"checkbox\" name=\"".$enregistrement2->ID_REPONSES."\"/><br/>";
		
	}

	// Fin de la question
	echo "</div><br/><br/>";
}
echo "<input type=\"submit\" value=\"Valider\"/></form>";	
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

}
echo "</div>";
require('bottom.php');
?>
