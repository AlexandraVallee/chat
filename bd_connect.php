<?php

//$link = mysqli_connect("127.0.0.1", "root", "", "chat");

$host = "127.0.0.1";
$login = "root";
$password = "";
$db = "chat";

$GLOBALS['db'] = new mysqli($host, $login, $password, $db);

if (!$GLOBALS['db']) {
    echo "Erreur : Impossible de se connecter à MySQL." . PHP_EOL;
    echo "Errno de débogage : " . mysqli_connect_errno() . PHP_EOL;
    echo "Erreur de débogage : " . mysqli_connect_error() . PHP_EOL;
    exit;
}
/*echo "Succès : Une connexion correcte à MySQL a été faite! La base de donnée log est génial." . PHP_EOL;
echo "Information d'hôte : " . mysqli_get_host_info($GLOBALS['db']) . PHP_EOL;
echo "<br>";*/
