<?php
/*
Page cr�ation de QCM
si le qcm est not�, pas de validation n�cessaire par l�administrateur
on indique le nombre de questions ou ajout question par question avec le bouton �+�
pour chaque question, on indique le nombre des r�ponses ainsi que la ou les bonnes
r�ponses

-le nom
-le mode : entrainement ou not�
-la difficult�, si il est public ou r�serv� � un groupe
-le nombre de questions:
soit avec un bouton �+� (pas besoin de renseigner le nombre)
on a �galement la possibilit� d�indiquer le �type� du QCM, par exemple le type 0 
correspond � un QCM avec une seule r�ponse possible par question alors que le type 1 permet plusieurs 
r�ponses par questions, le nombre �tant indiqu� par le contribueur 
option pour autoriser les commentaires (si les commentaires ont �t� impl�ment�s)
*/

require('top.php');
?>
<title>Creation de qcm</title>
<div id="Centre">

<?php

//Verification auth
if(!isAuth())
{
echo "<h1>Vous n'�tes pas autoris�s � cr�er des QCM. Authentifiez vous auparavant.</h1>";
}

//Si authentifi�
else
{
$user=$_SESSION['login'];
//On verifie si un qcm est soumis
if(isset($_POST['qcm'])&&($_POST['qcm']=='sub'))
{
//Section ajout du qcm � la bdd

//Selection du mode
if($_POST['mode']=='entrainement')
{
$note="FALSE";
}
else
{
$note="TRUE";
}

//Selection public/groupe
if($_POST['pour']=='public')
{
$pour=0;
}
else
{
$pour=$_POST['lstGr'];
}

//Ajout qcm
$res=$bdd->query("INSERT INTO QCM (ID_THEME,ID_USERS,INTITULE,NOTE,TYPES) VALUES(NULL,".$_SESSION['uid'].",'".$_POST['nom']."',".$note.",".$_POST['type'].")");
$idqcm=$bdd->lastInsertId();

$res=$bdd->query("INSERT INTO LIAISON (ID_QCM,ID_GROUPE) VALUES (".$idqcm.",".$pour.")");

//Ajout des questions
$ite=1;
while(isset($_POST['q'.$ite]))
{
$res=$bdd->query("INSERT INTO QUESTIONS (ID_QCM,INTITULE) VALUES (".$idqcm.",'".$_POST['q'.$ite]."')");
$idquest=$bdd->lastInsertId();

$itee=1;

while(isset($_POST['r'.$ite.'_'.$itee]))
{
if(isset($_POST['r'.$ite.'_'.$itee.'x']))
{$val="TRUE";}
else
{$val="FALSE";}
$res=$bdd->query("INSERT INTO REPONSES (ID_QUESTIONS,NOM,VALEUR) VALUES (".$idquest.",'".$_POST['r'.$ite.'_'.$itee]."',".$val.")");
$itee++;
}

$ite++;
}

echo "<h1>Ajout OK</h1>";
}
else
{
//Section affichage du formulaire
?>

<form action="creationqcm.php" method="post">
<input type="hidden" name="qcm" value="sub">
<fieldset>
<legend>Informations</legend>

<label for="nom">Nom : </label>
<input type="text" id="nom" name="nom"/><br/>

<label>Mode : </label><br/>

<input type="radio" id="entrainement" name="mode" value="entrainement">
<label for="entrainement">Entrainement</label><br/>

<input type="radio" id="note" name="mode" value="note">
<label for="note">Note</label><br/>


<label>Reserve � : </label><br/>



<?php
//Code php pour lister les groupes
$res=$bdd->query("SELECT ID_GROUPE,NOM FROM GROUPE WHERE ID_USERS in(SELECT ID_USERS FROM USERS WHERE LOGIN='".$user."');");
$res->setFetchMode(PDO::FETCH_OBJ);
$okl=false;
if($ligne=$res->fetch())
{
echo "<input type=\"radio\" id=\"groupe\" name=\"pour\" value=\"groupe\"><label for=\"groupe\">Groupe</label>";
echo "<select id=\"lstGr\" name=\"lstGr\">";
echo '<option value="'.$ligne->ID_GROUPE.'">'.$ligne->NOM.'</option>';
$okl=true;
}
while($ligne=$res->fetch())
{
echo '<option value="'.$ligne->ID_GROUPE.'">'.$ligne->NOM.'</option>';
}
$res->closeCursor();
if($okl)
{
echo "</select>";
}
?>
<br/>
<input type="radio" id="public" name="pour" value="public">
<label for="public">Public</label><br/>

<label>Type : </label><br/>

<input type="radio" id="t1" name="type" value="1">
<label for="t1">Type 1 :: Une seule r�ponse possible</label><br/>

<input type="radio" id="t5" name="type" value="5">
<label for="t5">Type 5 :: Une ou plusieurs r�ponses possibles</label><br/>

</fieldset>
<fieldset id="questions">
<legend>Questions</legend>
<script type="text/javascript">
var nbq=1;
function addquestion()
{
nbq++;
var q=document.getElementById("questions");
var form=document.createElement("div");
var html="<fieldset><legend>Question "+nbq+"</legend>"+"<label for=\"q"+nbq+"\">Question :</label><input type=\"text\" id=\"q"+nbq+"\" name=\"q"+nbq+"\"/><br/>"+"<div class=\"rep\" style=\"margin-left:2%;\">";
for(var i=1;i<6;i++)
{html+="<label for=\"r"+nbq+"."+i+"\">Reponse "+i+"</label><input type=\"text\" id=\"r"+nbq+"."+i+"\" name=\"r"+nbq+"."+i+"\"/><input type=\"checkbox\" name=\"r"+nbq+"."+i+"x\"/><br/>";}
html+="</fieldset>";
form.innerHTML=html;
q.appendChild(form);
}


function check_qcm()
{

}
</script>
<div>
<fieldset>
<legend>Question 1</legend>
<label for="q1">Question :</label>
<input type="text" id="q1" name="q1"/><br/>
<div class="rep" style="margin-left:2%;">
<label for="r1.1">Reponse 1</label>
<input type="text" id="r1.1" name="r1.1"/>
<input type="checkbox" name="r1.1x"/><br/>
<label for="r1.2">Reponse 2</label>
<input type="text" id="r1.2" name="r1.2"/>
<input type="checkbox" name="r1.2x"/><br/>
<label for="r1.3">Reponse 3</label>
<input type="text" id="r1.3" name="r1.3"/>
<input type="checkbox" name="r1.3x"/><br/>
<label for="r1.4">Reponse 4</label>
<input type="text" id="r1.4" name="r1.4"/>
<input type="checkbox" name="r1.4x"/><br/>
<label for="r1.5">Reponse 5</label>
<input type="text" id="r1.5" name="r1.5"/>
<input type="checkbox" name="r1.5x"/><br/>
</div>
</fieldset>
</div>
</fieldset>
<input type="button" value="Ajouter une question" onclick="addquestion();"/>
<input type="submit" value="Valider"/>
</form>
<?php
}







}
echo "</div>";
require('bottom.php');
?>
