<?php
/*
Page mon compte permettant la modification du mot de passe

*/

require('top.php');
?>
<div id="Centre">
<title>Mon compte</title>
<?php
if(isset($_POST['qcm']))
{
$mdp=hash('sha256',$_POST['oldpasswd']);
$res=$bdd->query("SELECT MDP FROM USERS WHERE ID_USERS=".$_SESSION['uid']."");
$res->setFetchMode(PDO::FETCH_OBJ);
$ligne=$res->fetch();

if($ligne->MDP!=$mdp)
{
echo "<script langage=\"text/javascript\">alert(\"Erreur - Ancien mot de passe incorrect\");</script>";
}
else
{
if($_POST['newpasswd1']!=$_POST['newpasswd2'])
{
echo "<script langage=\"text/javascript\">alert(\"Erreur - Mots de passe différents\");</script>";
}
else
{
$mdp=hash('sha256',$_POST['newpasswd1']);
$res=$bdd->query("UPDATE USERS SET MDP='".$mdp."' WHERE ID_USERS=".$_SESSION['uid']);
echo "<script langage=\"text/javascript\">alert(\"Mot de passe mis à jour\");</script>";
}
}
}

if(isAuth())
{
echo "<table class=\"table\"> <tr> <td colspan=\"2\"><h2>Mes informations : </h2> </td> </tr>";
$id=$_SESSION['uid'];
$res=$bdd->query("SELECT * FROM USERS WHERE ID_USERS=".$id."");
$res->setFetchMode(PDO::FETCH_OBJ);
$ligne=$res->fetch();

echo "<tr> <td> Nom :</td> <td> ".$ligne->NOM."</td></tr>";
echo "<tr> <td>Prenom :</td> <td>  ".$ligne->PRENOM."</td></tr>";
echo "<tr> <td> Mail :</td> <td>  ".$ligne->MAIL."</td></tr>";
?>

	<form action="" method="post">
	<input type="hidden" name="qcm" value="sub"/>
			
	<tr>
			<td><label for="oldpasswd">Ancien mot de passe : </label></td>
			<td><input id="oldpasswd" name="oldpasswd" type="password" /></td>
	</tr>
	<tr>
			<td><label for="newpasswd1">Tapez votre nouveau mot de passe : </label></td>
			<td><input id="newpasswd1" name="newpasswd1" type="password" /></td>
	</tr>
	<tr>
			<td><label for="newpasswd2">Retapez votre nouveau mot de passe : </label></td>
			<td><input id="newpasswd2" name="newpasswd2" type="password" /></td>
	</tr>
		
	<tr>
		<td><input type="submit" value="Changer mon mot de passe"/></td>
		<td></td>
	</tr>
	
	</table>	

	</form>
<?php

}
else
{
echo "<h1>Vous devez etre authentifié.</h1>";
}

echo "</div>";
require('bottom.php');
?>
