<?php
require('top.php');
?>
<div id="Centre">
<title>Inscription</title>
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
		$res=$bdd->query("SELECT COUNT(*) AS COMPT FROM USERS WHERE LOGIN='".$login."' OR MAIL='".$mail."'");
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
		$hebergement="http://ufrsciencestech.u-bourgogne.fr/~an123429/QCM/validation.php?id=";

		$subject = 'Universite de Bourgogne : Inscription QCM ';

		$message = "<body>Bonjour, veuillez valider votre compte en vous rendant à cette adresse : <a href=\"".$hebergement.$rand."\">Activation du compte</a></body>";

		$headers  = 'MIME-Version: 1.0' . "\r\n";

		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// En-têtes additionnels
		$headers .= 'From: Service QCM <qcm@u-bourgogne.fr>' . "\r\n";
		$headers .= "Reply-To: Service QCM <qcm@u-bourgogne.fr> \r\n";

		mail($to, $subject, $message,$headers);

		echo "<script langage=\"text/javascript\">
		alert(\"Un mail vous a ete envoye a l'adresse : ".$to."\");
		</script>";
		
		}
		
	}
}


?>
		<table class="table">
					<tr>
						<td colspan="2"><h2> Formulaire d'inscription </h2></td>
					</tr>
					<form action="" method="post">
						
						<tr>
							<td><label for="login">Login : </label></td>
							<td><input type="text" id="login" name="logini"/> <br/></td>
						</tr>
						<tr>
							<td><label for="nom">Nom : </label></td>
							<td><input type="text" id="nom" name="nomi"/> <br/>	</td>
						</tr>
						<tr>
							<td><label for="prenom">Pr&eacute;nom : </label></td>
							<td><input type="text" id="prenom" name="prenomi"/> <br/></td>
						</tr>
						<tr>
							<td><label for="mail">Adresse mail : </label></td>
							<td><input type="text" id="mail" name="maili" />@etu.u-bourgogne.fr <br/></td>
						</tr>
						<tr>
							<td><label for="mdp">Mot de passe : </label></td>
							<td><input type="password" id="mdp" name="mdpi"/> <br/></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Valider"/></td>
						</tr>
								
					</form>
		</table>

<?php


echo "</div>";
require('bottom.php');
?>