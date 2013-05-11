<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="cssMenu3.css" />
	<link rel="stylesheet" type="text/css" href="cssCentre.css" />	
  </head>
	
	<body>
<?php
require('connect.php');
require('auth.php');
?>
		
		
		
		<div id="Barremenu" >
			<ul class="menu">
				<li><a href="index.php" class="accueil">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Accueil</a></li>				
				
				<?php
				
				if(isAuth())
				{
				?>
				<li><a href="#" class="menu_qcm">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Qcm</a>
					<ul>
						<li><a href="mesqcm.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mes Qcm </a></li>
						<li><a href="creationqcm.php">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Creation de qcm</a></li>
					</ul>
				</li>
				
				<li><a href="#" class="menu_groupe">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Groupes</a>
					<ul>
						<li><a href="mesgroupes.php">Mes groupes </a></li>
						<li><a href="creationgroupe.php">Creation de groupe</a></li>
					</ul>
				</li>
				
				<?php
				}
				if(isAdmin())
				{
				?>
				<li><a href="administration.php" class="menu_admin">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Administration</a></li>
				<?php
				}
				?>
				<li><a href="contact.php" class="menu_contact">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Contact</a></li>
				<li><form method="post" action="recherche.php"><a href="#" class="menu_rech">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recherche <input type="text" name="recherche" maxlength="50" /><input type="submit" value="Go ! " /></a></form></li>
				
				<div class="droite">
				
				<?php
				
				if(!isAuth())
				{
				?>
				<li><a href="#" class="menu_conn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Connexion</a>
				<form method="post" action="">
					<ul>
						<li>Login : <input type="text" name="login" maxlength="255" /></li>
						<li>MdP : <input type="password" name="mdp" maxlength="255" /></li>
						<li> <input type="submit" value="connexion" /></li>
					</ul>
					</form>
				</li>
				<li><a href="inscription.php" class="menu_insc">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inscription</a></li>
				<?php
				}
				else
				{
				echo "<li><a href=\"#\" class=\"menu_welcome\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bienvenue ".$_SESSION['login']."</a><ul>";
				echo "<li><a href=\"compte.php\">Mon compte</a></li>";
				echo "<li><a href=\"deconnect.php\">Deconnexion</a></li></ul></li>";
				}
				?>
				
				
			</div>
			</ul>			
		</div>
		
		<div id="fixe-haut">
		</div>
		
		
		<div id="CentrePage">
			<div id="MenuCote">Menu gauche</div>
					<div id="Centre">
					
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
	
	</div>
				
		</div>
		
	</body>
	
</html>
