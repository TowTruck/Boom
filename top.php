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
			<div id="MenuCote"><h3>Derniers QCM publi&eacute;s :</h3><br/><br/>
			<ul>
				<?php
				$res=$bdd->query("SELECT * FROM QCM WHERE ID_QCM IN(SELECT ID_QCM FROM LIAISON WHERE ID_GROUPE=1) GROUP BY ID_QCM DESC LIMIT 7");
				$res->setFetchMode(PDO::FETCH_OBJ);
				while($ligne=$res->fetch())
				{
				echo "<li><a href=\"qcm.php?id=".$ligne->ID_QCM."\">".$ligne->INTITULE."</a></li>";
				}
				?>
			</ul>
			</div>
