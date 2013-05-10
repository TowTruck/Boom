<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="cssMenu.css" />
	<link rel="stylesheet" type="text/css" href="cssCentre.css" />	
  </head>
	
	<body>
<?php
require('connect.php');
require('auth.php');
?>
		<div id="fixe-haut">
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
			<div id="MenuCote">Menu gauche</div>
