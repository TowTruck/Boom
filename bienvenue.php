<?php
require('top.php');
?>
<div id="centre">
  if(isAuth())
	{	
		<h3>Bienvenu sur le site de QCM de l'université de bourgogne ! <br/><br/><br/></h3>
		
		<p>Accéder dès maintenant à vos résultats et aux nouveaux QCM mis en ligne.</p>
	}
	else
	{
		<h3>Bienvenu sur le site de QCM de l'université de bourgogne ! <br/><br/><br/></h3>
		
		<p>Vous trouverez sur ce site des QCM relatifs à toutes les matières enseignées sur le campus.<br/><br/>
		
		Ce site est à but pédagogique, principalement pour tester ses connaissances.<br/>
		Cependant, les professeurs utiliseront ce site dans le but de d'évaluer vos connaissances.<br/><br/>
		
		Inscrivez-vous et connectez-vous afin d'avoir accès à toutes les rubriques !<br/>
		Les QCM publics sont à la dispositions de tous les utilisateurs.</p>
	}	
</div>

<?php
require('bottom.php');
?>
