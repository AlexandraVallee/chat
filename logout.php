
<?php
	require_once("header_html.php");
?>

<?php
session_unset();
session_destroy();
echo "vous êtes bien déconecté";  
?>

<?php
	require_once("footer_html.php");
?>