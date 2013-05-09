<?php
require('top.php');
?>
<div id="centre">

<?php

if(isset($_POST['email']) and $_POST['email']!="" and isset($_POST['sujet']) and $_POST['sujet']!="" and isset($_POST['message']) and $_POST['message']!="")
{
  $destinataire = 'augustin.neo@orange.fr';
        $email = htmlentities($_POST['email']);
        if(preg_match('#^(([a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+\.?)*[a-z0-9!\#$%&\\\'*+/=?^_`{|}~-]+)@(([a-z0-9-_]+\.?)*[a-z0-9-_]+)\.[a-z]{2,}$#i',str_replace('&amp;','&',$email)))
        {
		$sujet = 'Contact: '.stripslashes($_POST['sujet']);
		$message = stripslashes($_POST['message']);
		$headers = "From: <".$email.">\n";
		$headers .= "Reply-To: ".$email."\n";
		$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";
		if(mail($destinataire,$sujet,$message,$headers))
		{
		        echo "<strong>Votre message a bien &eacute;t&eacute; envoy&eacute;.</strong>";
		}
		else
		{
		        echo "<strong style=\"color:#ff0000;\">Une erreur c'est produite lors de l'envois du message.</strong>";
		}
        }
        else
        {
                echo "<strong style=\"color:#ff0000;\">L'email que vous avez entr&eacute; est invalide.</strong>";
        }
	      
}
else
{
?>
<form action="" method="post">
      <div id="centre">  
		<fieldset>
			<legend>Formulaire de contact</legend>
			<label for="email" style="display:inline-block;width:100px;"><strong>Votre Email:</strong></label> 
				<input type="text" name="email" id="email" /><br />
			<label for="sujet" style="display:inline-block;width:100px;"><strong>Sujet:</strong></label> 
				<input type="text" name="sujet" id="sujet" /><br />
			<label for="message"><strong>Message:</strong></label><br />
				<textarea cols="60" rows="4" name="message" id="message"></textarea><br />
			
			<input type="submit" value="Envoyer" />
		</fieldset>
	</div>		
</form>
<?php
}

require('bottom.php');
?>
