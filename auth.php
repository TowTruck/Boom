<?php

function isAdmin()
{
	if(isset($_SESSION['adm'])&&($_SESSION['adm']==true))
	{
		return true;
	}
	else 
	{
		return false;
	}
}

function isAuth()
{
	if(isset($_SESSION['login']))
	{
		return true;
	}
	else 
	{
		return false;
	}
}


//Verifie si un couple login/mdp a ete soumis a la page, si oui on verifie la validite de ces derniers
if(!isAuth()&&isset($_POST['login'])&&isset($_POST['mdp']))
{
	//On hache le mot de passe avant de le verif dans la bdd
	$mdp=hash('sha256',$_POST['mdp']);
	$req="SELECT COUNT(*) FROM USERS WHERE LOGIN='".$_POST['login']."' AND MDP='".$mdp."'";
	$res=$bdd->query($req);
	$donnees=$res->fetchAll();

	if($donnees[0][0]==1)
	{
		//Utilisateur confirmé
		$_SESSION['login']=$_POST['login'];

		$req="SELECT USERS.ID_USERS,RANG.NOM FROM USERS,RANG WHERE LOGIN='".$_POST['login']."' AND USERS.ID_RANG=RANG.ID_RANG";		
		$res=$bdd->query($req);
		$donnees=$res->fetchAll();
		
		$_SESSION['uid']=$donnees[0][0];
		
		if($donnees[0][1]=='admin')
		{
		$_SESSION['adm']=true;
		}
		else
		{
		$_SESSION['adm']=false;
		}
		
	}
	else
	{
		//Mauvais login/mdp
		?>
		<script langage="text/javascript">
		alert("Erreur - Mauvais login/mdp");
		</script>
		<?php
	}

}

?>