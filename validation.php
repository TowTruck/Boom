<?php
require('connect.php');

if(isset($_GET['id']))
{
$res=$bdd->query("SELECT COUNT(*) AS COMPT FROM USERS WHERE VALIDE='".$_GET['id']."'");
$res->setFetchMode(PDO::FETCH_OBJ);
$ligne=$res->fetch();
if($ligne->COMPT==1)
{
$res=$bdd->query("UPDATE USERS SET VALIDE=NULL WHERE VALIDE='".$_GET['id']."'");
echo "<h1>Compte valide, vous allez etre redirige</h1>";
header ("Refresh: 2;URL=index.php");
}
else
{
echo "<h1>Erreur</h1>";
}
}

?>