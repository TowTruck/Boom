<?php
/*
Page création de QCM
si le qcm est noté, pas de validation nécessaire par l’administrateur
on indique le nombre de questions ou ajout question par question avec le bouton “+”
pour chaque question, on indique le nombre des réponses ainsi que la ou les bonnes
réponses

-le nom
-le mode : entrainement ou noté
-la difficulté, si il est public ou réservé à un groupe
-le nombre de questions:
soit avec un bouton “+” (pas besoin de renseigner le nombre)
on a également la possibilité d’indiquer le “type” du QCM, par exemple le type 0 
correspond à un QCM avec une seule réponse possible par question alors que le type 1 permet plusieurs 
réponses par questions, le nombre étant indiqué par le contribueur 
option pour autoriser les commentaires (si les commentaires ont été implémentés)
*/
?>
<div id="centre">

<?php

//Verification auth
if(!isAuth())
{
echo "<h1>Vous n'êtes pas autorisés à créer des QCM. Authentifiez vous auparavant.</h1>";
}

//Si authentifié
else
{
$user=$_SESSION['login'];
//On verifie si un qcm est soumis
if(isset($_POST['qcm']))
{
//Section ajout du qcm à la bdd
//TODO !
}
else
{
//Section affichage du formulaire
?>

<form action="creationqcm.php" method="post">

<fieldset>
<legend>Informations</legend>

<label for="nom">Nom : </label>
<input type="text" id="nom" name="nom"/><br/>

<label>Mode : </label><br/>

<input type="radio" id="entrainement" name="mode" value="entrainement">
<label for="entrainement">Entrainement</label><br/>

<input type="radio" id="note" name="mode" value="note">
<label for="note">Note</label><br/>


<label>Reserve à : </label><br/>

<input type="radio" id="groupe" name="pour" value="groupe" onclick="listeGroupe();">
<label for="groupe">Groupe</label>

<select id="lstGr" name="lstGr">
//Code php pour lister les groupes
<?php
$res=$bdd->query("SELECT NOM FROM GROUPE WHERE ID_USERS in(SELECT ID_USERS FROM USERS WHERE LOGIN='".$user."');");
$res->setFetchMode(PDO::FETCH_OBJ);
while($ligne=$res->fetch())
{
echo '<option value="'.$ligne->NOM.'">'.$ligne->NOM.'</option>';
}
$res->closeCursor();
?>
</select><br/>
<input type="radio" id="public" name="pour" value="public" onclick="listeGroupe();">
<label for="public">Public</label><br/>

<label>Type : </label><br/>

<input type="radio" id="t1" name="type" value="t1">
<label for="t1">Type 1 :: Une seule réponse possible</label><br/>

<input type="radio" id="t5" name="type" value="t5">
<label for="t5">Type 5 :: Une ou plusieurs réponses possibles</label><br/>

</fieldset>
<fieldset>
<legend>Questions</legend>

<fieldset>
<legend>Question 1</legend>
<label for="q0">Question :</label>
<input type="text" id="q0" name="q0"/><br/>
<label for="r0.1">Reponse 1</label>
<input type="text" id="r0.1" name="r0.1"/><br/>
<label for="r0.2">Reponse 2</label>
<input type="text" id="r0.2" name="r0.2"/><br/>
<label for="r0.3">Reponse 3</label>
<input type="text" id="r0.3" name="r0.3"/><br/>
<label for="r0.4">Reponse 4</label>
<input type="text" id="r0.4" name="r0.4"/><br/>
<label for="r0.5">Reponse 5</label>
<input type="text" id="r0.5" name="r0.5"/><br/>
</fieldset>
<input type="button" value="Ajouter une question" onclick="addquestion();"/>
</fieldset>
</form>
<?php
}







}
?>
