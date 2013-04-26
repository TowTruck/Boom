<?php

session_start();

$ident="";
$serv="camus.iem";

$bdd = new PDO('mysql:host='.$serv.';dbname='.$ident, $ident, $ident);
?>