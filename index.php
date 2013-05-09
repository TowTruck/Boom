<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">

	<head>
		<title> Centre de la page </title>
		<link rel="stylesheet" type="text/css" href="cssMenu.css" />
		<link rel="stylesheet" type="text/css" href="cssCentre.css" />		
	</head>
	
	<body>
<?php
require_once('connect.php');
require_once('auth.php');
?>
		<div id="fixe-haut"><!--
			<p>
				<a href="Inscription.html">Inscription</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="oublie.php">Mot de passe oublié ?</a> <br/>	
		<form method="post" action="">
			<fieldset>
				<input type="text" maxlength="255" />
				<input type="password" maxlength="255" />
				<input type="button" src="" class="button" value="se connecter"/>
			</fieldset>
		</form>		
			</p>-->
		</div>
		
		
		<div id="Barremenu" class="Menu">
			<ul>
				<li><a href="#" id="MenuBoutonGauche">Accueil</a></li>				
				<li><a href="#">Lien 1</a>
					<ul>
						<li><a href="#">sous lien 1.1</a></li>
						<li><a href="#">sous lien 1.2</a></li>
					</ul>
				</li>
				<li><a href="#">Lien 2</a>
					<ul>
						<li><a href="#">sous lien 2.1</a></li>
						<li><a href="#">sous lien 2.2</a></li>
						<li><a href="#">sous lien 2.3</a></li>
						<li><a href="#">sous lien 2.3</a></li>
					</ul>
				</li>
				<li><a href="#">Contact</a></li>
				<?php
				
				if(!isAuth())
				{
				?>
				<li><a href="#">Connexion</a>
				<form method="post" action="">
					<ul>
						<li>Login : <input type="text" name="login" maxlength="255" /></li>
						<li>MdP : <input type="password" name="mdp" maxlength="255" /></li>
						<li> <input type="submit" value="connexion" /></li>
					</ul>
					</form>
				</li>
				<li>
					<form method="post" action="recherche.php">
					<a href="#">Recherche
						<input type="text" name="recherche" maxlength="50" />
						<input type="submit" value="Go ! " />
					</a>						
					</form>
				</li>
				<?php
				}
				else
				{
				echo "<li><a href=\"#\">Bienvenue ".$_SESSION['login']."</a></li>";
				echo "<li><a href=\"deconnect.php\">Deconnexion</a></li>";
				}
				?>
			</ul>			
		</div>
		
		<div id="CentrePage">
			<table>
				<tr>
					<td id="MenuCote">Menu gauche</td>
					<td id="Centre">Centre</td>
				</tr>
			</table>
		</div>
		
	</body>
	
</html>
