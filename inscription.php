<?php
require('top.php');
?>
<div id="centre">

<?php

if(isset($_POST['logini']))
{
	$login = $_POST['logini'];
	$nom = $_POST['nomi'];
	$prenom = $_POST['prenomi'];
	$adresse = $_POST['maili'];
	$mdp = $_POST['mdpi'];
	
	
	if($nom==NULL || $nom=="" || $prenom=="" || $prenom==NULL || $login=="" || $login==NULL || $mdp=="" || $mdp==NULL)
	{
		echo "<script langage=\"text/javascript\">
		alert(\"Des informations sont manquantes\");
		</script>";
	}
	
	else
	{
		$mdp2=hash('sha256',$mdp);
		$mail=$adresse."@etu.u-bourgogne.fr";
		$rand=hash('sha256', (mt_rand().$mail));
		
		//Step 1 : on verifie que le login/mail n'existe pas deja
		$res=$bdd->query("SELECT COUNT(*) AS COMPT FROM USERS WHERE LOGIN='".$login."' AND MAIL='".$mail."'");
		$res->setFetchMode(PDO::FETCH_OBJ);
		$ligne=$res->fetch();
		if($ligne->COMPT!=0)
			{
			echo "<script langage=\"text/javascript\">
		alert(\"Ce login ou cette adresse mail est deja utilisé\");
		</script>";
			}
		else
		{
		//Step 2 : Insert + envoi du mail
		$res=$bdd->query("INSERT INTO USERS (ID_RANG,LOGIN,NOM,PRENOM,MDP,VALIDE,MAIL) VALUES (2,'".$login."','".$nom."','".$prenom."','".$mdp2."','".$rand."','".$mail."')");

		$to = $mail;
		$hebergement="http://ufrsciencestech.u-bourgogne.fr/~yh476107/Test/validation.php?id=";

		$subject = 'Universite de Bourgogne : Inscription QCM ';

		$message = "<body>Bonjour, veuillez valider votre compte en vous rendant à cette adresse : <a href=\"".$hebergement.$rand."\">Activation du compte</a></body>";

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// En-têtes additionnels
		$headers .= 'From: Service QCM <qcm@u-bourgogne.fr>' . "\r\n";
		$headers .= "Reply-To: Service QCM <qcm@u-bourgogne.fr> \r\n";

		mail($to, $subject, $message,$headers);

		echo "<script langage=\"text/javascript\">
		alert(\"Un mail vous a été envoyer !".$to."\");
		</script>";
		
		}
		
	}
}


?>
		<h2> Formulaire d'inscription </h2><br/>
	<form action="" method="post">

		<label for="login">Login : </label>
		<input type="text" id="login" name="logini"/> <br/>
		<label for="nom">Nom : </label>
		<input type="text" id="nom" name="nomi"/> <br/>		
		<label for="prenom">Pr&eacute;nom : </label>
		<input type="text" id="prenom" name="prenomi"/> <br/>
		<label for="mail">Adresse mail : </label>
		<input type="text" id="mail" name="maili" />@etu.u-bourgogne.fr <br/>
		<label for="mdp">Mot de passe : </label>
		<input type="password" id="mdp" name="mdpi"/> <br/>
			
				
		<input type="submit" value="Valider"/>
	</form>

<?php


echo "</div>";
require('bottom.php');
?>