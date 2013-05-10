<?php
require('top.php');
?>
<div id="Centre">
<?php
  if(isAuth())
	{	
		echo " <h3>Bienvenue sur le site de QCM de l'universit&eacute; de Bourgogne ! <br/><br/><br/></h3>";
		
		echo "	<p>Acc&eacute;der d&egrave;s maintenant &agrave; vos r&eacute;sultats et aux nouveaux QCM mis en ligne.</p>";
	}
  else
	{
		echo"<h3>Bienvenu sur le site de QCM de l'universit&eacute; de bourgogne ! <br/><br/><br/></h3>";
		
		echo"<p>Vous trouverez sur ce site des QCM relatifs &agrave; toutes les mati&egrave;res enseign&eacute;es sur le campus.<br/><br/>
		
		Ce site est &agrave; but p&eacute;dagogique, principalement pour tester ses connaissances.<br/>
		Cependant, les professeurs utiliseront ce site dans le but de d'&eacute;valuer vos connaissances.<br/><br/>
		
		Inscrivez-vous et connectez-vous afin d'avoir acc&egrave;s &agrave; toutes les rubriques !<br/>
		Les QCM publics sont &agrave; la dispositions de tous les utilisateurs.</p>";
	}
?>
</div>

<?php
require('bottom.php');
?>
