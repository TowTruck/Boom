<?php

//Exemple type du site php.net

session_start();

if(isset($_SESSION['login']))
{
// D�truit toutes les variables de session
$_SESSION = array();

// Si vous voulez d�truire compl�tement la session, effacez �galement
// le cookie de session.
// Note : cela d�truira la session et pas seulement les donn�es de session !
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalement, on d�truit la session.
session_destroy();

}

echo "<h1>Vous allez etre redirige...</h1>";
header ("Refresh: 2;URL=index.php");

?>