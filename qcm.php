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
if($ligne)
{return true;}
else {return false;}

}

}

if(isset($_POST['mail'])&&isset($_GET['id']))
{
/*-----------------------------------------------------------------
				Section envoie des results par mail
-------------------------------------------------------------------
*/
$selecti = $bdd->query("SELECT * FROM QCM WHERE ID_QCM=".$idqcm);
$selecti->setFetchMode(PDO::FETCH_OBJ);
$lignei=$selecti->fetch();

$select = $bdd->query("SELECT * FROM USERS WHERE ID_USERS=".$lignei->ID_USERS);
$select->setFetchMode(PDO::FETCH_OBJ);
$ligne=$select->fetch();

$to = $ligne->MAIL;
$subject = 'Universite de Bourgogne : Resultats qcm --> '.$lignei->INTITULE;
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Service QCM <qcm@u-bourgogne.fr>' . "\r\n";
$headers .= "Reply-To: Service QCM <qcm@u-bourgogne.fr> \r\n";
$message = "<body>Bonjour,".$ligne->NOM." ".$ligne->PRENOM." voici les resultats de votre qcm : <br/><br/>";

$selectn = $bdd->query("SELECT REPOND.NOTE,USERS.MAIL FROM REPOND,USERS WHERE REPOND.ID_QCM=".$idqcm." AND USERS.ID_USERS=REPOND.ID_USERS");
$selectn->setFetchMode(PDO::FETCH_OBJ);
	while($lignen=$selectn->fetch())
	{
	$message.=$ligne->MAIL." --> ".$ligne->NOTE."<br/>";
	}

mail($to, $subject, $message,$headers);

echo "<script langage=\"text/javascript\">
		alert(\"Resultats envoyés !\");
		</script>";

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
	$selecti = $bdd->query("SELECT * FROM QCM WHERE ID_QCM=".$idqcm);
	$selecti->setFetchMode(PDO::FETCH_OBJ);
	$ligne=$selecti->fetch();
	echo "<h1>Resultats du qcm : ".$ligne->INTITULE."</h1><br/><br/>";
	$notes=0;
	$tot=0;
	echo "<h3>Mail --> Note </h3><br/>";
	$select = $bdd->query("SELECT REPOND.NOTE,USERS.MAIL FROM REPOND,USERS WHERE REPOND.ID_QCM=".$idqcm." AND USERS.ID_USERS=REPOND.ID_USERS");
	$select->setFetchMode(PDO::FETCH_OBJ);
	while($ligne=$select->fetch())
	{
	echo $ligne->MAIL." --> ".$ligne->NOTE;
	$notes+=$ligne->NOTE;
	$tot++;
	}
	echo "<br/><br/>";
	echo "<h3>La moyenne est de : </h3>".$notes/$tot."<br/><br/>";
?>
<form action="" method="post">
<input type="hidden" name="mail" value="mail"/>
<input type="submit" value="Recevoir les resultats par mail"/>
</form>
<?php	
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
$selecti = $bdd->query("SELECT * FROM QCM WHERE ID_QCM=".$idqcm);
$selecti->setFetchMode(PDO::FETCH_OBJ);
$ligne=$selecti->fetch();
echo "<h1>".$ligne->INTITULE."</h1><br/>";
if($ligne->TYPES==1)
{
echo "<h3>Ce qcm est de type 1 : il n'y a qu'une seule reponse possible par question.</h3><br/>";
}
else
{
echo "<h3>Ce qcm est de type 5 : il y a entre 1 et 5 reponses possible par question.</h3><br/>";
}
if($ligne->NOTE)
{
echo "<h3>Votre note sera enregistrer</h3><br/>";
}
else
{
echo "<h3>Votre pourrez recommencer ce qcm</h3><br/>";
}

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
