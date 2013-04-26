<?php

function isAdmin()
{
if(isset($_SESSION['login'])&&($_SESSION['login']=='admin'))
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
else {
return false;
}
}

if(!isAuth()&&isset($_POST['login'])&&isset($_POST['mdp']))
{
//On hache le mot de passe avant de le verif dans la bdd
$mdp=;



}

?>