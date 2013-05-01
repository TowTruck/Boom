<?php

session_start();

$ident="ve380591";
$serv="camus.iem";

$bdd = new PDO('mysql:host='.$serv.';dbname='.$ident,$ident,$ident);
?>